@extends('layouts.frontend')

@section('title', 'Payment Failed - Neonman')

@section('content')
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4 sm:py-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold font-display text-gray-900 dark:text-gray-100">Payment Failed</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-6 sm:py-8">
    <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-16 text-center max-w-lg mx-auto">
        <div class="w-24 h-24 mx-auto mb-6 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">Payment Not Completed</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-2">{{ $message ?? 'Your payment could not be processed.' }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-500 mb-8">Your order has not been placed. No charges were made.</p>
        <div class="flex gap-3 justify-center">
            <a href="{{ url('/checkout') }}" class="inline-block px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                Try Again
            </a>
            <a href="{{ url('/shop') }}" class="inline-block px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
