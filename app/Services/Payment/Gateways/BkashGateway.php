<?php

namespace App\Services\Payment\Gateways;

use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BkashGateway implements PaymentGatewayInterface
{
    private PaymentGateway $gateway;

    private string $baseUrl;

    public function __construct(PaymentGateway $gateway)
    {
        $this->gateway = $gateway;
        $this->baseUrl = $gateway->isSandbox()
            ? 'https://tokenized.sandbox.bka.sh/v1.2.0-beta'
            : 'https://tokenized.pay.bka.sh/v1.2.0-beta';
    }

    public function getSlug(): string
    {
        return 'bkash';
    }

    /**
     * Grant or refresh bKash API token
     */
    private function getToken(): string
    {
        $cacheKey = 'bkash_token_' . $this->gateway->id;
        $cached = Cache::get($cacheKey);

        if ($cached) {
            return $cached;
        }

        $response = Http::timeout(30)
            ->when($this->gateway->isSandbox(), fn ($http) => $http->withoutVerifying())
            ->withHeaders([
                'username' => $this->gateway->credential('username'),
                'password' => $this->gateway->credential('password'),
            ])
            ->post($this->baseUrl . '/tokenized/checkout/token/grant', [
                'app_key' => $this->gateway->credential('app_key'),
                'app_secret' => $this->gateway->credential('app_secret'),
            ]);

        $data = $response->json();

        if (!isset($data['id_token'])) {
            Log::error('bKash token grant failed', $data);
            throw new \RuntimeException('Failed to grant bKash token: ' . ($data['message'] ?? 'Unknown error'));
        }

        $token = $data['id_token'];
        $expiresIn = ($data['expires_in'] ?? 3600) - 60; // Subtract 60s buffer

        Cache::put($cacheKey, $token, $expiresIn);

        return $token;
    }

    /**
     * Make authenticated API request to bKash
     */
    private function apiRequest(string $method, string $endpoint, array $data = []): array
    {
        $token = $this->getToken();

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'X-APP-Key' => $this->gateway->credential('app_key'),
                'Content-Type' => 'application/json',
            ])
            ->when($this->gateway->isSandbox(), fn ($http) => $http->withoutVerifying())
            ->$method($this->baseUrl . $endpoint, $data);

        $result = $response->json();

        Log::info("bKash API {$endpoint}", [
            'request' => $data,
            'response' => $result,
        ]);

        return $result;
    }

    /**
     * Create payment and return bKash redirect URL
     */
    public function createPayment(Order $order, array $params = []): array
    {
        $callbackUrl = route('bkash.callback', [
            'order' => $order->order_number,
        ]);

        $payload = [
            'payerReference' => $order->customer_phone ?? $order->guest_phone ?? 'guest',
            'callbackURL' => $callbackUrl,
            'amount' => number_format($order->total, 2, '.', ''),
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $order->order_number,
        ];

        $payload = array_merge($payload, $params);

        // Create transaction record
        $transaction = PaymentTransaction::create([
            'order_id' => $order->id,
            'payment_gateway_id' => $this->gateway->id,
            'amount' => $order->total,
            'currency' => 'BDT',
            'status' => PaymentTransaction::STATUS_PENDING,
            'payment_method' => 'bkash',
            'request_payload' => $payload,
        ]);

        try {
            $result = $this->apiRequest('post', '/tokenized/checkout/create', $payload);

            if (isset($result['bkashURL'])) {
                $transaction->update([
                    'payment_id' => $result['paymentID'] ?? null,
                    'response_payload' => $result,
                ]);

                return [
                    'success' => true,
                    'redirect_url' => $result['bkashURL'],
                    'payment_id' => $result['paymentID'] ?? null,
                    'transaction_id' => $transaction->id,
                ];
            }

            $errorMessage = $result['statusMessage'] ?? $result['message'] ?? 'Failed to create bKash payment';
            $transaction->markFailed($errorMessage, $result);

            return [
                'success' => false,
                'message' => $errorMessage,
                'transaction_id' => $transaction->id,
            ];
        } catch (\Exception $e) {
            Log::error('bKash create payment error', ['error' => $e->getMessage()]);
            $transaction->markFailed($e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to connect to bKash gateway',
                'transaction_id' => $transaction->id,
            ];
        }
    }

    /**
     * Execute payment after customer approval
     */
    public function executePayment(PaymentTransaction $transaction, array $params = []): array
    {
        $paymentId = $transaction->payment_id;

        if (!$paymentId) {
            return ['success' => false, 'message' => 'No payment ID found'];
        }

        $transaction->update(['status' => PaymentTransaction::STATUS_PROCESSING]);

        try {
            $result = $this->apiRequest('post', '/tokenized/checkout/execute', [
                'paymentID' => $paymentId,
            ]);

            $transaction->update(['response_payload' => $result]);

            if (isset($result['statusCode']) && $result['statusCode'] === '0000') {
                $transaction->markCompleted($result['trxID'] ?? null, $result);

                // Update order payment status
                $transaction->order->update([
                    'payment_status' => 'paid',
                    'bkash_transaction_id' => $result['trxID'] ?? null,
                    'paid_at' => now(),
                ]);

                return [
                    'success' => true,
                    'trx_id' => $result['trxID'] ?? null,
                    'amount' => $result['amount'] ?? $transaction->amount,
                ];
            }

            $errorMessage = $result['statusMessage'] ?? 'Payment execution failed';
            $transaction->markFailed($errorMessage, $result);

            return [
                'success' => false,
                'message' => $errorMessage,
            ];
        } catch (\Exception $e) {
            Log::error('bKash execute payment error', ['error' => $e->getMessage()]);
            $transaction->markFailed($e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to execute bKash payment',
            ];
        }
    }

    /**
     * Query payment status
     */
    public function queryPayment(PaymentTransaction $transaction): array
    {
        $paymentId = $transaction->payment_id;

        if (!$paymentId) {
            return ['success' => false, 'message' => 'No payment ID found'];
        }

        try {
            $result = $this->apiRequest('post', '/tokenized/checkout/payment/status', [
                'paymentID' => $paymentId,
            ]);

            return [
                'success' => isset($result['statusCode']) && $result['statusCode'] === '0000',
                'data' => $result,
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Handle callback from bKash
     */
    public function handleCallback(array $payload): array
    {
        $paymentId = $payload['paymentID'] ?? null;
        $status = $payload['status'] ?? null;

        if (!$paymentId) {
            return ['success' => false, 'message' => 'No payment ID in callback'];
        }

        $transaction = PaymentTransaction::where('payment_id', $paymentId)
            ->where('payment_gateway_id', $this->gateway->id)
            ->first();

        if (!$transaction) {
            return ['success' => false, 'message' => 'Transaction not found'];
        }

        if ($status === 'failure' || $status === 'cancel') {
            $transaction->markFailed('Payment ' . $status, $payload);

            return [
                'success' => false,
                'message' => 'Payment was ' . $status,
                'order' => $transaction->order,
            ];
        }

        if ($status === 'success') {
            $executeResult = $this->executePayment($transaction);

            return [
                'success' => $executeResult['success'],
                'message' => $executeResult['message'] ?? 'Payment completed',
                'order' => $transaction->order,
                'transaction' => $transaction->fresh(),
            ];
        }

        return ['success' => false, 'message' => 'Unknown status: ' . $status];
    }

    /**
     * Process a refund
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason = ''): array
    {
        if (!$transaction->trx_id) {
            return ['success' => false, 'message' => 'No transaction ID to refund'];
        }

        try {
            $result = $this->apiRequest('post', '/tokenized/checkout/payment/refund', [
                'paymentID' => $transaction->payment_id,
                'trxID' => $transaction->trx_id,
                'refundAmount' => number_format($amount, 2, '.', ''),
                'reason' => $reason,
            ]);

            return [
                'success' => isset($result['statusCode']) && $result['statusCode'] === '0000',
                'data' => $result,
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
