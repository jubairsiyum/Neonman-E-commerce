@extends('layouts.frontend')

@section('title', 'Shipping Policy - Neonman')

@section('content')
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4 sm:py-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold font-display text-gray-900 dark:text-gray-100">Shipping Policy</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8 sm:py-10 max-w-3xl">
    <div class="prose prose-gray dark:prose-invert max-w-none space-y-6">
        <h2>Delivery Areas</h2>
        <p>We deliver to all 64 districts across Bangladesh. Delivery charges and timelines vary by location.</p>

        <h2>Delivery Zones & Charges</h2>
        <ul>
            <li><strong>Inside Dhaka:</strong> ৳60 delivery charge, free shipping on orders over ৳2,000. Estimated delivery: 1-3 business days.</li>
            <li><strong>Outside Dhaka:</strong> ৳120 delivery charge, free shipping on orders over ৳3,000. Estimated delivery: 3-7 business days.</li>
        </ul>

        <h2>Order Processing</h2>
        <p>All orders are processed within 24-48 hours of payment confirmation. Orders placed on weekends or public holidays will be processed the next business day.</p>

        <h2>Tracking Your Order</h2>
        <p>Once your order is shipped, you'll receive an SMS/email with a tracking number. You can also track your order on our website using the Track Order page.</p>

        <h2>Cash on Delivery</h2>
        <p>Cash on Delivery (COD) is available for all locations within Bangladesh. An additional COD charge may apply based on your delivery zone.</p>

        <h2>Shipping Partners</h2>
        <p>We work with trusted courier partners including Pathao, Steadfast, and RedX to ensure timely and safe delivery of your orders.</p>
    </div>
</div>
@endsection
