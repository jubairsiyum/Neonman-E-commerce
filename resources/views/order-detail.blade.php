@extends('layouts.frontend')

@section('title', 'Order Details - Neonman')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center gap-3">
            <a href="{{ url('/my-orders') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Order Details</h1>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    @php
        // Sample order data (will be replaced with database query)
        $orderId = '#10001';
        $orderDate = 'January 15, 2025';
        $orderStatus = 'Processing';
        $orderTotal = 2450;
        $orderItems = [];
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Order Items -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Order Header -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">Order {{ $orderId }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">Placed on {{ $orderDate }}</p>
                    </div>
                    <span class="px-4 py-2 bg-orange-100 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 text-sm font-semibold rounded-full">
                        {{ $orderStatus }}
                    </span>
                </div>

                <!-- Order Progress -->
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-gray-900 dark:text-gray-100">Pending</p>
                        </div>
                        <div class="h-0.5 flex-1 bg-green-500"></div>
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-gray-900 dark:text-gray-100">Processing</p>
                        </div>
                        <div class="h-0.5 flex-1 bg-gray-300 dark:bg-gray-700"></div>
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Shipped</p>
                        </div>
                        <div class="h-0.5 flex-1 bg-gray-300 dark:bg-gray-700"></div>
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400">Delivered</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Order Items</h3>
                </div>

                @if(empty($orderItems))
                <div class="p-8 text-center text-gray-600 dark:text-gray-400">
                    Sample order items will appear here
                </div>
                @else
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Sample Product Item (will be populated from database) -->
                    <!-- <div class="p-6 flex gap-4">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded overflow-hidden flex-shrink-0">
                            <img src="" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Product Name</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Size: M</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Qty: 2</span>
                                <span class="font-bold text-primary-900 dark:text-primary-400">৳1,200</span>
                            </div>
                        </div>
                    </div> -->
                </div>
                @endif
            </div>

        </div>

        <!-- Order Summary & Shipping -->
        <div class="space-y-6">
            
            <!-- Order Summary -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3>

                <div class="space-y-3 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">৳2,350</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">৳100</span>
                    </div>
                </div>

                <div class="flex justify-between mb-6">
                    <span class="font-bold text-gray-900 dark:text-gray-100">Total</span>
                    <span class="text-2xl font-bold text-primary-900 dark:text-primary-400">৳{{ number_format($orderTotal, 0) }}</span>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">Payment Method</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Cash on Delivery (COD)</p>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Shipping Address</h3>
                
                <div class="text-sm space-y-1">
                    <p class="font-medium text-gray-900 dark:text-gray-100">John Doe</p>
                    <p class="text-gray-600 dark:text-gray-400">House 123, Road 45</p>
                    <p class="text-gray-600 dark:text-gray-400">Mirpur, Dhaka</p>
                    <p class="text-gray-600 dark:text-gray-400">Dhaka - 1216</p>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Phone: +880 1712345678</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ url('/track-order') }}" class="block w-full px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white text-center font-semibold rounded-lg transition-colors">
                    Track Order
                </a>
                <button class="w-full px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Download Invoice
                </button>
                <button class="w-full px-6 py-3 border border-red-300 dark:border-red-600 text-red-600 font-medium rounded-lg hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                    Cancel Order
                </button>
            </div>

        </div>
    </div>
</div>

@endsection
