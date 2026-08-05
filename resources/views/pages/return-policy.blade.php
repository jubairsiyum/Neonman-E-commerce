@extends('layouts.frontend')

@section('title', 'Return & Refund Policy - Neonman')

@section('content')
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4 sm:py-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold font-display text-gray-900 dark:text-gray-100">Return & Refund Policy</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8 sm:py-10 max-w-3xl">
    <div class="prose prose-gray dark:prose-invert max-w-none space-y-6">
        <h2>Return Policy</h2>
        <p>We offer a hassle-free 7-day return policy. If you're not satisfied with your purchase, you can return it within 7 days of delivery for a full refund or exchange.</p>

        <h2>Conditions for Return</h2>
        <ul>
            <li>Product must be unused, unworn, and in its original packaging with all tags attached.</li>
            <li>The return request must be initiated within 7 days of delivery.</li>
            <li>Damaged or defective products must be reported within 24 hours of delivery with photographic evidence.</li>
        </ul>

        <h2>Non-Returnable Items</h2>
        <ul>
            <li>Products on clearance or final sale.</li>
            <li>Products that have been used or washed.</li>
            <li>Products without original tags or packaging.</li>
        </ul>

        <h2>Refund Process</h2>
        <p>Once we receive and inspect your returned item, we will process your refund within 5-7 business days. Refunds will be issued to the original payment method:</p>
        <ul>
            <li><strong>bKash:</strong> Refunded to your bKash wallet.</li>
            <li><strong>Cash on Delivery:</strong> Refunded via bKash or bank transfer.</li>
        </ul>

        <h2>Exchange</h2>
        <p>If you'd like a different size, color, or product, you can request an exchange. Exchange shipping is free for the first exchange.</p>

        <h2>How to Return</h2>
        <p>Contact us via email at <strong>{{ config('app.shop_email', 'support@neonman.com') }}</strong> or call <strong>{{ config('app.shop_phone', '+880 1XXX-XXXXXX') }}</strong> to initiate a return.</p>
    </div>
</div>
@endsection
