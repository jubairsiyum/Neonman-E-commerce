@extends('layouts.customer')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">My Orders</h1>
    <p class="text-gray-600 dark:text-gray-400">Track and manage all your orders in one place</p>
</div>

<!-- Filters & Search -->
<div class="card bg-white dark:bg-gray-800 shadow-lg mb-6">
    <div class="card-body">
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Search -->
            <div class="form-control flex-1">
                <div class="input-group">
                    <input type="text" placeholder="Search orders..." class="input input-bordered flex-1" />
                    <button class="btn btn-square btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Filter by Status -->
            <div class="form-control sm:w-48">
                <select class="select select-bordered">
                    <option>All Orders</option>
                    <option>Pending</option>
                    <option>Processing</option>
                    <option>Shipped</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>
            </div>
        </div>
    </div>
</div>

@php
    $orders = auth()->user()->orders()->latest()->get();
@endphp

@if($orders->count() > 0)
    <!-- Orders List -->
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="card bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-shadow">
            <div class="card-body">
                <!-- Order Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                            Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            $badgeClass = match($order->status) {
                                'pending' => 'badge-warning',
                                'processing' => 'badge-info',
                                'shipped' => 'badge-primary',
                                'completed' => 'badge-success',
                                'cancelled' => 'badge-error',
                                default => 'badge-ghost'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} badge-lg">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>

                <!-- Order Items Preview -->
                <div class="py-4">
                    @foreach($order->orderItems()->take(3)->get() as $item)
                    <div class="flex items-center gap-4 mb-3 last:mb-0">
                        <div class="avatar">
                            <div class="w-16 h-16 rounded">
                                @if($item->product && $item->product->getFirstMediaUrl('products'))
                                    <img src="{{ $item->product->getFirstMediaUrl('products') }}" alt="{{ $item->product_name }}" />
                                @else
                                    <div class="bg-gray-200 dark:bg-gray-700 w-full h-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $item->product_name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }} × ৳{{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900 dark:text-white">৳{{ number_format($item->quantity * $item->price, 2) }}</p>
                        </div>
                    </div>
                    @endforeach

                    @if($order->orderItems()->count() > 3)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-3">
                        +{{ $order->orderItems()->count() - 3 }} more item(s)
                    </p>
                    @endif
                </div>

                <!-- Order Footer -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount</p>
                        <p class="text-2xl font-bold text-primary">৳{{ number_format($order->total, 2) }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('order.detail', $order->id) }}" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Details
                        </a>
                        @if(in_array($order->status, ['pending', 'processing']))
                        <button class="btn btn-outline btn-error btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        <div class="flex justify-center">
            <div class="btn-group">
                <button class="btn btn-sm">«</button>
                <button class="btn btn-sm btn-active">1</button>
                <button class="btn btn-sm">2</button>
                <button class="btn btn-sm">3</button>
                <button class="btn btn-sm">»</button>
            </div>
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="card bg-white dark:bg-gray-800 shadow-lg">
        <div class="card-body text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No orders yet</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                You haven't placed any orders yet. Start shopping to see your orders here!
            </p>
            <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Start Shopping
            </a>
        </div>
    </div>
@endif
@endsection
