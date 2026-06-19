<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\PaymentGatewayManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    /**
     * bKash payment callback
     */
    public function bkashCallback(Request $request, string $orderNumber)
    {
        Log::info('bKash callback received', [
            'order' => $orderNumber,
            'params' => $request->all(),
        ]);

        try {
            $gateway = PaymentGatewayManager::resolve('bkash');
            $result = $gateway->handleCallback($request->all());

            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return redirect()->route('checkout')
                    ->with('error', 'Order not found.');
            }

            if ($result['success']) {
                return redirect()->route('checkout.success', $order->order_number)
                    ->with('success', 'Payment completed successfully!');
            }

            return redirect()->route('checkout.success', $order->order_number)
                ->with('error', $result['message'] ?? 'Payment was not completed.');

        } catch (\Exception $e) {
            Log::error('bKash callback error', [
                'order' => $orderNumber,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('checkout')
                ->with('error', 'Payment processing failed. Please try again.');
        }
    }

    /**
     * Payment success page
     */
    public function success(Request $request, string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        return view('checkout.success', [
            'order' => $order,
        ]);
    }

    /**
     * Payment failed page
     */
    public function failed(Request $request)
    {
        return view('checkout.failed', [
            'message' => session('error', 'Payment was not completed.'),
        ]);
    }
}
