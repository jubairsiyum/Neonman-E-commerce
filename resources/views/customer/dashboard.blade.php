@extends('layouts.customer')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
    <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">Manage your orders, wishlist, and account from one place.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-8">
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_orders'] }}</p>
    </div>
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Orders</p>
        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_orders'] }}</p>
    </div>
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Wishlist Items</p>
        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['wishlist_count'] }}</p>
    </div>
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Spent</p>
        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Tk {{ number_format($stats['total_spent'], 2) }}</p>
    </div>
</div>

<div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Orders</h2>
        <a href="{{ route('my-orders') }}" class="text-sm font-semibold text-rose-600 dark:text-rose-400 hover:underline">View all</a>
    </div>

    @if($recentOrders->isEmpty())
        <div class="p-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">No orders yet.</p>
            <a href="{{ route('shop') }}" class="inline-flex mt-4 px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium transition-colors duration-150">Start shopping</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Order</th>
                        <th class="px-6 py-3 text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Date</th>
                        <th class="px-6 py-3 text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Items</th>
                        <th class="px-6 py-3 text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Total</th>
                        <th class="px-6 py-3 text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $order->items_count }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">Tk {{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ ucfirst($order->status) }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('order.detail', $order) }}" class="text-rose-600 dark:text-rose-400 hover:underline">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
