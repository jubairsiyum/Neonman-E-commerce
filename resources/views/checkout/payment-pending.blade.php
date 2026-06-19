@extends('layouts.frontend')

@section('title', 'Complete Payment - Neonman')

@section('content')
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4 sm:py-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold font-display text-gray-900 dark:text-gray-100">Complete Your Payment</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-6 sm:py-8">
    <div class="max-w-lg mx-auto">

        @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-700 dark:text-red-400">
            {{ session('error') }}
        </div>
        @endif

        <!-- Order Info Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Order Number</p>
                        <p class="font-bold text-gray-900 dark:text-gray-100 text-lg">{{ $order->order_number }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                        Awaiting Payment
                    </span>
                </div>
            </div>

            <div class="px-6 py-5 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Payment Method</span>
                    <span class="font-semibold text-gray-900 dark:text-gray-100">bKash</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Items</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $order->items->count() }}</span>
                </div>
                <div class="flex justify-between font-bold text-base text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                    <span>Total Amount</span>
                    <span class="text-primary-900 dark:text-primary-400">৳{{ number_format($order->total, 0) }}</span>
                </div>
            </div>
        </div>

        <!-- bKash Payment Instructions -->
        <div class="bg-pink-50 dark:bg-pink-900/10 border border-pink-200 dark:border-pink-800 rounded-xl p-6 mb-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="px-2.5 py-1 bg-pink-500 text-white rounded text-sm font-bold">bKash</span>
                <h3 class="font-bold text-gray-900 dark:text-gray-100">How to Pay</h3>
            </div>
            <ol class="text-sm text-gray-700 dark:text-gray-300 space-y-2 list-decimal list-inside">
                <li>Open your bKash app and go to <strong>Send Money</strong></li>
                <li>Send <strong class="text-pink-600 dark:text-pink-400">৳{{ number_format($order->total, 0) }}</strong> to <strong>{{ config('app.bkash_number', '01XXX-XXXXXX') }}</strong></li>
                <li>Use <strong>{{ $order->order_number }}</strong> as reference</li>
                <li>After payment, click the button below to confirm</li>
            </ol>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('checkout.retry-bkash', $order->order_number) }}" class="flex-1 text-center px-6 py-3 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-lg transition-colors">
                Pay Now with bKash
            </a>
            <a href="{{ url('/shop') }}" class="flex-1 text-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Continue Shopping
            </a>
        </div>

        <p class="text-xs text-center text-gray-500 dark:text-gray-500 mt-4">
            Your order will be confirmed once payment is received.
        </p>
    </div>
</div>
@endsection
