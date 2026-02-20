@extends('layouts.customer')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<!-- Welcome Section -->
<div class="mb-6 sm:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Here's what's happening with your account today.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 sm:mb-8">
    <!-- Total Orders -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 sm:p-6 hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
        <div class="flex items-start justify-between mb-3">
            <div class="flex-1">
                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Orders</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ auth()->user()->orders()->count() }}
                </p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-50 dark:bg-primary-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-5 h-5 sm:w-6 sm:h-6 stroke-primary-600 dark:stroke-primary-400">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">All time orders</p>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 sm:p-6 hover:border-orange-300 dark:hover:border-orange-700 transition-colors">
        <div class="flex items-start justify-between mb-3">
            <div class="flex-1">
                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Pending</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ auth()->user()->orders()->whereIn('status', ['pending', 'processing'])->count() }}
                </p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-50 dark:bg-orange-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-5 h-5 sm:w-6 sm:h-6 stroke-orange-600 dark:stroke-orange-400">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">In progress</p>
    </div>

    <!-- Wishlist Items -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 sm:p-6 hover:border-red-300 dark:hover:border-red-700 transition-colors">
        <div class="flex items-start justify-between mb-3">
            <div class="flex-1">
                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Wishlist</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ auth()->user()->wishlists()->count() }}
                </p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-5 h-5 sm:w-6 sm:h-6 stroke-red-600 dark:stroke-red-400">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">Saved items</p>
    </div>

    <!-- Total Spent -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 sm:p-6 hover:border-green-300 dark:hover:border-green-700 transition-colors">
        <div class="flex items-start justify-between mb-3">
            <div class="flex-1">
                <p class="text-xs sm:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Spent</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    ৳{{ number_format(auth()->user()->orders()->where('status', 'completed')->sum('total'), 0) }}
                </p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-5 h-5 sm:w-6 sm:h-6 stroke-green-600 dark:stroke-green-400">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">Lifetime value</p>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 sm:mb-8">
    <div class="px-5 sm:px-6 py-4 sm:py-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Recent Orders
        </h2>
        <a href="{{ route('my-orders') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 transition-colors">
            View All →
        </a>
    </div>

    @php
        $recentOrders = auth()->user()->orders()->latest()->take(5)->get();
    @endphp

    @if($recentOrders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-5 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Order ID</th>
                        <th class="px-5 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-5 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30 transition-colors">
                        <td class="px-5 sm:px-6 py-4">
                            <span class="text-sm font-mono font-semibold text-gray-900 dark:text-white">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-5 sm:px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-5 sm:px-6 py-4">
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
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-medium {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-5 sm:px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">৳{{ number_format($order->total, 2) }}</td>
                        <td class="px-5 sm:px-6 py-4">
                            <a href="{{ route('order.detail', $order->id) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 transition-colors">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12 px-4">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-900/50 rounded-2xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No orders yet</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Start shopping to see your orders here!</p>
            <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-900 to-primary-700 hover:from-primary-800 hover:to-primary-600 text-white text-sm font-medium rounded-xl shadow-lg shadow-primary-900/30 transition-all transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Start Shopping
            </a>
        </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Track Order -->
    <div class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 p-6 transition-all hover:shadow-lg">
        <div class="w-12 h-12 bg-primary-50 dark:bg-primary-900/20 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Track Your Order</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Check the status of your orders in real-time</p>
        <a href="{{ route('track-order') }}" class="inline-flex items-center text-sm font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 transition-colors">
            Track Now 
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- Browse Products -->
    <div class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-orange-300 dark:hover:border-orange-700 p-6 transition-all hover:shadow-lg">
        <div class="w-12 h-12 bg-orange-50 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Browse Products</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Discover our latest collection of products</p>
        <a href="{{ url('/shop') }}" class="inline-flex items-center text-sm font-semibold text-orange-600 hover:text-orange-700 dark:text-orange-400 transition-colors">
            Shop Now 
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- View Wishlist -->
    <div class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-red-300 dark:hover:border-red-700 p-6 transition-all hover:shadow-lg">
        <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Your Wishlist</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">View and manage your saved items</p>
        <a href="{{ route('wishlist') }}" class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-700 dark:text-red-400 transition-colors">
            View Wishlist 
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</div>
@endsection
