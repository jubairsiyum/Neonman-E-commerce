@extends('layouts.customer')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="mb-6 sm:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">My Orders</h1>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Track and manage all your orders in one place</p>
</div>

<!-- Filters & Search -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 mb-6">
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="flex items-stretch gap-2">
                <input 
                    type="text" 
                    placeholder="Search orders..." 
                    class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-sm"
                />
                <button class="px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-colors flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Filter by Status -->
        <div class="sm:w-48">
            <select class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all text-sm">
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

@php
    $orders = auth()->user()->orders()->latest()->get();
@endphp

@if($orders->count() > 0)
    <!-- Orders List -->
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 transition-colors overflow-hidden">
            <div class="p-5 sm:p-6">
                <!-- Order Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-200 dark:border-gray-700">
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
                                'pending' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
                                'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                            };
                        @endphp
                        <span class="inline-flex px-3 py-1.5 rounded-lg text-sm font-medium {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>

                <!-- Order Items Preview -->
                <div class="py-4 space-y-3">
                    @foreach($order->orderItems()->take(3)->get() as $item)
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900/50 flex-shrink-0">
                            @if($item->product && $item->product->getFirstMediaUrl('products'))
                                <img src="{{ $item->product->getFirstMediaUrl('products') }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 dark:text-white truncate">{{ $item->product_name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }} × ৳{{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-semibold text-gray-900 dark:text-white">৳{{ number_format($item->quantity * $item->price, 2) }}</p>
                        </div>
                    </div>
                    @endforeach

                    @if($order->orderItems()->count() > 3)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 pl-18 sm:pl-20">
                        +{{ $order->orderItems()->count() - 3 }} more item(s)
                    </p>
                    @endif
                </div>

                <!-- Order Footer -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Total Amount</p>
                        <p class="text-xl sm:text-2xl font-bold text-primary-600 dark:text-primary-400">৳{{ number_format($order->total, 2) }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('order.detail', $order->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Details
                        </a>
                        @if(in_array($order->status, ['pending', 'processing']))
                        <button class="inline-flex items-center gap-2 px-4 py-2.5 border border-red-300 dark:border-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 text-sm font-medium rounded-xl transition-colors">
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
        <div class="flex justify-center gap-2">
            <button class="px-3 py-2 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium">
                «
            </button>
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium">1</button>
            <button class="px-4 py-2 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium">2</button>
            <button class="px-4 py-2 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium">3</button>
            <button class="px-3 py-2 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium">
                »
            </button>
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
        <div class="text-center py-12 sm:py-16 px-4">
            <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 dark:bg-gray-900/50 rounded-2xl mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">No orders yet</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                You haven't placed any orders yet. Start shopping to see your orders here!
            </p>
            <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-900 to-primary-700 hover:from-primary-800 hover:to-primary-600 text-white font-medium rounded-xl shadow-lg shadow-primary-900/30 transition-all transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Start Shopping
            </a>
        </div>
    </div>
@endif
@endsection
