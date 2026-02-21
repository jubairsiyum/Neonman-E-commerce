@extends('layouts.customer')

@section('title', 'Order Details - ' . config('app.name'))

@section('content')
<div class="mb-8 flex items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Order Details</h1>
        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">{{ $order->order_number }} placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
    </div>
    <a href="{{ route('my-orders') }}" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200">Back to orders</a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Items</h2>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($order->items as $item)
                <div class="p-5 flex items-center justify-between gap-3">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Quantity: {{ $item->quantity }}</p>
                    </div>
                    <p class="font-semibold text-gray-900 dark:text-white">Tk {{ number_format($item->total, 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="space-y-4">
        <section class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">Summary</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                    <span class="text-gray-900 dark:text-white">Tk {{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Discount</span>
                    <span class="text-gray-900 dark:text-white">Tk {{ number_format($order->discount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Shipping</span>
                    <span class="text-gray-900 dark:text-white">Tk {{ number_format($order->shipping_charge, 2) }}</span>
                </div>
                <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                    <span class="font-semibold text-gray-900 dark:text-white">Total</span>
                    <span class="font-bold text-primary-600 dark:text-primary-400">Tk {{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">Shipping</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $order->shipping_address }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $order->shipping_district }}, {{ $order->shipping_division }} {{ $order->shipping_postal_code }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">Phone: {{ $order->shipping_phone }}</p>
        </section>

        <section class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3">Status</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">{{ ucfirst($order->status) }}</p>
            @if($order->canBeCancelled())
                <form method="POST" action="{{ route('order.cancel', $order) }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 rounded-lg border border-red-300 text-red-700 hover:bg-red-50 text-sm font-medium">Cancel order</button>
                </form>
            @endif
        </section>
    </div>
</div>
@endsection
