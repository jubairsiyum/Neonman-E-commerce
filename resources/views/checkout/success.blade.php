@extends('layouts.frontend')

@section('title', 'Order Confirmed - Neonman')

@section('content')

<div class="container mx-auto px-4 py-12 sm:py-16 lg:py-20">
    <div class="max-w-2xl mx-auto">

        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-5">
                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Order Confirmed! 🎉</h1>
            <p class="text-gray-600 dark:text-gray-400">
                Thank you for your order. We'll notify you once it's been shipped.
            </p>
        </div>

        <!-- Order Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">

            <!-- Order Header -->
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Order Number</p>
                        <p class="font-bold text-gray-900 dark:text-gray-100 text-lg">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Date</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                    @elseif($order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                    @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 @endif">
                    <span class="w-2 h-2 rounded-full
                        @if($order->status === 'pending') bg-yellow-500
                        @elseif($order->status === 'processing') bg-blue-500
                        @elseif($order->status === 'shipped') bg-purple-500
                        @elseif($order->status === 'delivered') bg-green-500
                        @else bg-gray-400 @endif">
                    </span>
                    {{ ucfirst($order->status) }}
                </span>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Payment: <strong class="capitalize text-gray-800 dark:text-gray-200">{{ strtoupper($order->payment_method) }}</strong>
                </span>
            </div>

            <!-- Order Items -->
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($order->items as $item)
                <div class="px-6 py-4 flex items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-gray-900 dark:text-gray-100 truncate">{{ $item->product_name }}</p>
                        @if($item->variant_details)
                            @php $variants = json_decode($item->variant_details, true); @endphp
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                @if(!empty($variants['size'])) Size: {{ strtoupper($variants['size']) }} @endif
                                @if(!empty($variants['color'])) &nbsp;| Color: {{ ucfirst($variants['color']) }} @endif
                            </p>
                        @endif
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Qty: {{ $item->quantity }}</p>
                    </div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 flex-shrink-0">
                        ৳{{ number_format($item->total, 0) }}
                    </p>
                </div>
                @endforeach
            </div>

            <!-- Order Totals -->
            <div class="px-6 py-5 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30 space-y-2">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                    <span>Subtotal</span>
                    <span>৳{{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->discount > 0)
                <div class="flex justify-between text-sm text-green-600 dark:text-green-400">
                    <span>Discount</span>
                    <span>- ৳{{ number_format($order->discount, 0) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                    <span>Shipping</span>
                    <span>
                        @if($order->shipping_charge > 0) ৳{{ number_format($order->shipping_charge, 0) }}
                        @else <span class="text-green-600 dark:text-green-400 font-medium">FREE</span> @endif
                    </span>
                </div>
                <div class="flex justify-between font-bold text-base text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                    <span>Total</span>
                    <span class="text-primary-900 dark:text-primary-400">৳{{ number_format($order->total, 0) }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <h2 class="font-bold text-gray-900 dark:text-gray-100 mb-3">Shipping To</h2>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $order->guest_name }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $order->shipping_address }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $order->shipping_district }}, {{ $order->shipping_division }}
                @if($order->shipping_postal_code) – {{ $order->shipping_postal_code }} @endif
            </p>
            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">📞 {{ $order->shipping_phone }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            @auth
            <a href="{{ route('my-orders') }}" class="flex-1 text-center px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                View My Orders
            </a>
            @endauth
            <a href="{{ url('/shop') }}" class="flex-1 text-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Continue Shopping
            </a>
        </div>

        <!-- Payment instructions for bKash -->
        @if($order->payment_method === 'bkash')
        <div class="mt-6 bg-pink-50 dark:bg-pink-900/10 border border-pink-200 dark:border-pink-800 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-pink-500 text-white rounded text-sm font-bold">bKash</span>
                <h3 class="font-bold text-gray-900 dark:text-gray-100">Payment Instructions</h3>
            </div>
            <ol class="text-sm text-gray-700 dark:text-gray-300 space-y-1 list-decimal list-inside">
                <li>Open your bKash app and go to <strong>Send Money</strong></li>
                <li>Send <strong>৳{{ number_format($order->total, 0) }}</strong> to <strong>{{ config('app.bkash_number', '01XXX-XXXXXX') }}</strong></li>
                <li>Use order number <strong>{{ $order->order_number }}</strong> as the reference</li>
                <li>Take a screenshot and send it to our WhatsApp or email</li>
            </ol>
        </div>
        @endif

    </div>
</div>

@endsection
