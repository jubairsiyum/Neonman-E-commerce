@extends('layouts.frontend')

@section('title', 'Frequently Asked Questions - Neonman')

@section('content')
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4 sm:py-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold font-display text-gray-900 dark:text-gray-100">Frequently Asked Questions</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8 sm:py-10 max-w-3xl">
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">How do I place an order?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Browse our collection, add items to your cart, and proceed to checkout. Enter your shipping details, choose a payment method, and confirm your order.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">What payment methods do you accept?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">We accept bKash online payment and Cash on Delivery (COD) across Bangladesh.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">How long does delivery take?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Inside Dhaka: 1-3 business days. Outside Dhaka: 3-7 business days. Delivery times may vary based on your location and courier availability.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Can I return or exchange an item?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Yes! We have a 7-day return policy. Items must be unused with original tags. Visit our <a href="{{ url('/return-policy') }}" class="text-primary-900 dark:text-primary-400 hover:underline">Return & Refund Policy</a> for details.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">How do I track my order?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Once your order is shipped, you'll receive an SMS with a tracking link. You can also use our <a href="{{ url('/track-order') }}" class="text-primary-900 dark:text-primary-400 hover:underline">Track Order</a> page.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Do you have a physical store?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">We are currently an online-only store, delivering across all 64 districts of Bangladesh.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">How can I contact customer support?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Email us at <strong>{{ config('app.shop_email', 'support@neonman.com') }}</strong> or call <strong>{{ config('app.shop_phone', '+880 1XXX-XXXXXX') }}</strong>. You can also use our <a href="{{ url('/contact') }}" class="text-primary-900 dark:text-primary-400 hover:underline">Contact</a> page.</p>
        </div>
    </div>
</div>
@endsection
