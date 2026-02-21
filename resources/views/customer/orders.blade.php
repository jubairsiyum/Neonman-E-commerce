@extends('layouts.customer')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">My Orders</h1>
    <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">Track, filter, and manage your purchases.</p>
</div>

@if(session('status'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('status') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        {{ session('error') }}
    </div>
@endif

<form method="GET" action="{{ route('my-orders') }}" class="mb-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div class="md:col-span-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by order number or id"
                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 text-gray-900 dark:text-white"
            />
        </div>
        <div>
            <select name="status" class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 text-gray-900 dark:text-white">
                <option value="">All statuses</option>
                @foreach(['pending', 'paid', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button class="flex-1 px-4 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium transition-colors duration-150">Apply</button>
            <a href="{{ route('my-orders') }}" class="px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200">Reset</a>
        </div>
    </div>
</form>

@if($orders->isEmpty())
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-10 text-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">No orders found</h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Try a different filter or place your first order.</p>
        <a href="{{ route('shop') }}" class="inline-flex mt-4 px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium transition-colors duration-150">Browse products</a>
    </div>
@else
    <div class="space-y-4">
        @foreach($orders as $order)
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 border-b border-gray-200 dark:border-gray-700 pb-5">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">Order</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">Status</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($order->status) }}</p>
                        <p class="text-lg font-bold text-rose-600 dark:text-rose-400">Tk {{ number_format($order->total, 2) }}</p>
                    </div>
                </div>

                <div class="mt-5 space-y-2.5">
                    @foreach($order->items->take(3) as $item)
                        <div class="flex items-center justify-between text-sm">
                            <p class="text-gray-900 dark:text-white">{{ $item->product_name }} x {{ $item->quantity }}</p>
                            <p class="text-gray-700 dark:text-gray-300">Tk {{ number_format($item->total, 2) }}</p>
                        </div>
                    @endforeach
                    @if($order->items->count() > 3)
                        <p class="text-xs text-gray-500 dark:text-gray-400">+ {{ $order->items->count() - 3 }} more items</p>
                    @endif
                </div>

                <div class="mt-5 flex items-center gap-2">
                    <a href="{{ route('order.detail', $order) }}" class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium transition-colors duration-150">View details</a>
                    @if($order->canBeCancelled())
                        <form method="POST" action="{{ route('order.cancel', $order) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg border border-red-300 text-red-700 text-sm font-medium hover:bg-red-50">Cancel order</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endif
@endsection
