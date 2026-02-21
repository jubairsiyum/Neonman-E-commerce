@extends('layouts.customer')

@section('title', 'Track Order - ' . config('app.name'))

@section('content')
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Track Order</h1>
    <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">Search by order number to get the latest shipping status.</p>
</div>

<div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 mb-6">
    <form method="GET" action="{{ route('track-order') }}" class="flex flex-col sm:flex-row gap-3">
        <input
            type="text"
            name="order"
            value="{{ request('order') }}"
            placeholder="Example: ORD-123ABC or id"
            class="flex-1 px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 text-gray-900 dark:text-white"
        >
        <button type="submit" class="px-4 py-2.5 rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium">Track</button>
    </form>
</div>

@if(request('order'))
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 mb-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Search Result</h2>
        @if($matchingOrder)
            <div class="space-y-2 text-sm">
                <p><span class="text-gray-500 dark:text-gray-400">Order:</span> <span class="font-semibold text-gray-900 dark:text-white">{{ $matchingOrder->order_number }}</span></p>
                <p><span class="text-gray-500 dark:text-gray-400">Date:</span> <span class="text-gray-900 dark:text-white">{{ $matchingOrder->created_at->format('M d, Y h:i A') }}</span></p>
                <p><span class="text-gray-500 dark:text-gray-400">Status:</span> <span class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($matchingOrder->status) }}</span></p>
                <p><span class="text-gray-500 dark:text-gray-400">Total:</span> <span class="font-semibold text-gray-900 dark:text-white">Tk {{ number_format($matchingOrder->total, 2) }}</span></p>
            </div>
            <a href="{{ route('order.detail', $matchingOrder) }}" class="inline-flex mt-4 px-4 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium">Open order details</a>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400">No order found for "{{ request('order') }}".</p>
        @endif
    </div>
@endif

<div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Orders</h2>
    </div>
    @if($latestOrders->isEmpty())
        <p class="p-5 text-sm text-gray-600 dark:text-gray-400">No recent orders available.</p>
    @else
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($latestOrders as $order)
                <div class="p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($order->status) }}</p>
                        <a href="{{ route('order.detail', $order) }}" class="text-sm font-semibold text-primary-600 dark:text-primary-400 hover:underline">Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
