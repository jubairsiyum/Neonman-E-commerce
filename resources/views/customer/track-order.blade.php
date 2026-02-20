@extends('layouts.customer')

@section('title', 'Track Order - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="mb-6 sm:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Track Your Order</h1>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Enter your order details to check the status</p>
</div>

<!-- Track Order Form -->
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-50 dark:bg-primary-900/20 rounded-xl mb-4">
                    <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Enter Your Order Details</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Enter your order ID and email to track your order status
                </p>
            </div>

            <form class="space-y-4">
                <div>
                    <label for="order_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Order ID *</label>
                    <input 
                        type="text" 
                        id="order_id" 
                        name="order_id" 
                        placeholder="#10001" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    />
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can find this in your order confirmation email</p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email Address *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="you@example.com" 
                        required 
                        class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    />
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-primary-900 to-primary-700 hover:from-primary-800 hover:to-primary-600 text-white font-medium rounded-lg shadow-lg shadow-primary-900/30 transition-all transform hover:-translate-y-0.5">
                    Track Order
                </button>
            </form>
        </div>
    </div>

    <!-- Help Section -->
    <div class="mt-8 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-3">Need Help?</h3>
        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Your Order ID can be found in your order confirmation email</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Use the email address you used when placing the order</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>If you're logged in, you can view all your orders in <a href="{{ route('my-orders') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium">My Orders</a></span>
            </li>
        </ul>

        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Still can't find your order? 
                <a href="{{ route('contact') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium">Contact our support team</a>
            </p>
        </div>
    </div>
</div>
@endsection
