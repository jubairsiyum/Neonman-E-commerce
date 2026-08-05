@extends('layouts.frontend')

@section('title', 'Privacy Policy - Neonman')

@section('content')
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4 sm:py-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold font-display text-gray-900 dark:text-gray-100">Privacy Policy</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8 sm:py-10 max-w-3xl">
    <div class="prose prose-gray dark:prose-invert max-w-none space-y-6">
        <h2>Information We Collect</h2>
        <p>When you place an order or create an account, we collect:</p>
        <ul>
            <li>Full name, email address, and phone number</li>
            <li>Shipping address and delivery preferences</li>
            <li>Order history and payment information</li>
        </ul>

        <h2>How We Use Your Information</h2>
        <ul>
            <li>To process and fulfill your orders</li>
            <li>To communicate about your order status and updates</li>
            <li>To improve our products and shopping experience</li>
            <li>To send promotional offers (only if you opt in)</li>
        </ul>

        <h2>Data Protection</h2>
        <p>We implement appropriate security measures to protect your personal information. All payment information is processed through secure, PCI-compliant payment gateways.</p>

        <h2>Third-Party Sharing</h2>
        <p>We do not sell or rent your personal data. We only share necessary information with:</p>
        <ul>
            <li>Payment processors (bKash) for transaction processing</li>
            <li>Courier partners for order delivery</li>
        </ul>

        <h2>Cookies</h2>
        <p>Our website uses cookies to improve your browsing experience. Cookies help us remember your cart, preferences, and provide a better shopping experience.</p>

        <h2>Contact Us</h2>
        <p>For privacy-related inquiries, email us at <strong>{{ config('app.shop_email', 'support@neonman.com') }}</strong>.</p>
    </div>
</div>
@endsection
