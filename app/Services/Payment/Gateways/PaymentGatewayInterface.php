<?php

namespace App\Services\Payment\Gateways;

use App\Models\Order;
use App\Models\PaymentTransaction;

interface PaymentGatewayInterface
{
    /**
     * Get the gateway slug
     */
    public function getSlug(): string;

    /**
     * Create a payment and return redirect URL or payment data
     */
    public function createPayment(Order $order, array $params = []): array;

    /**
     * Execute/confirm a payment after customer approval
     */
    public function executePayment(PaymentTransaction $transaction, array $params = []): array;

    /**
     * Query payment status
     */
    public function queryPayment(PaymentTransaction $transaction): array;

    /**
     * Process callback from gateway
     */
    public function handleCallback(array $payload): array;

    /**
     * Process a refund
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason = ''): array;
}
