@extends('layouts.frontend')

@section('title', 'Track Order - Neonman')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Track Your Order</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    
    <!-- Track Order Form -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Enter Your Order Details</h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Enter your order ID and email to track your order status
                </p>
            </div>

            <form class="space-y-5">
                <div>
                    <label for="order_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order ID *</label>
                    <input type="text" id="order_id" name="order_id" placeholder="#10001" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can find this in your order confirmation email</p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                    Track Order
                </button>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 rounded-lg p-6">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Need Help?</h3>
            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <p>• If you're logged in, you can view all your orders in <a href="{{ url('/my-orders') }}" class="text-primary-900 dark:text-primary-400 hover:underline">My Orders</a></p>
                <p>• Order tracking information is usually available within 24 hours of placing your order</p>
                <p>• For any issues, please <a href="{{ url('/contact') }}" class="text-primary-900 dark:text-primary-400 hover:underline">contact our support team</a></p>
            </div>
        </div>
    </div>

    <!-- Sample Order Status (shown after form submission) -->
    <!-- <div class="max-w-3xl mx-auto mt-8" style="display: none;" id="trackingResult">
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-1">Order #10001</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Placed on January 15, 2025</p>
                    </div>
                    <span class="px-4 py-2 bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 text-sm font-semibold rounded-full">
                        Out for Delivery
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="w-0.5 h-full bg-green-500 my-2"></div>
                        </div>
                        <div class="flex-1 pb-6">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100">Order Confirmed</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Jan 15, 2025 | 10:30 AM</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="w-0.5 h-full bg-green-500 my-2"></div>
                        </div>
                        <div class="flex-1 pb-6">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100">Processing</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Jan 15, 2025 | 2:15 PM</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="w-0.5 h-full bg-blue-500 my-2"></div>
                        </div>
                        <div class="flex-1 pb-6">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100">Shipped</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Jan 16, 2025 | 9:00 AM</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center">
                                <svg class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                            <div class="w-0.5 h-full bg-gray-300 dark:bg-gray-700 my-2"></div>
                        </div>
                        <div class="flex-1 pb-6">
                            <h4 class="font-semibold text-blue-700 dark:text-blue-400">Out for Delivery</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Jan 17, 2025 | 8:00 AM</p>
                            <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Your order is on its way!</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 text-gray-600 dark:text-gray-400 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-600 dark:text-gray-400">Delivered</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-500">Estimated: Jan 17, 2025</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Estimated Delivery</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Today, 5:00 PM - 7:00 PM</p>
                        </div>
                        <a href="#" class="px-6 py-2 bg-primary-900 hover:bg-primary-950 text-white font-medium rounded-lg transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

</div>

@endsection
