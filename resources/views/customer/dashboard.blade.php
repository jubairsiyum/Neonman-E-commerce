@extends('layouts.customer')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-gray-600 dark:text-gray-400">Here's what's happening with your account today.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Total Orders -->
    <div class="stats shadow bg-white dark:bg-gray-800">
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <div class="stat-title">Total Orders</div>
            <div class="stat-value text-primary">
                {{ auth()->user()->orders()->count() }}
            </div>
            <div class="stat-desc">All time orders</div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="stats shadow bg-white dark:bg-gray-800">
        <div class="stat">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Pending</div>
            <div class="stat-value text-warning">
                {{ auth()->user()->orders()->whereIn('status', ['pending', 'processing'])->count() }}
            </div>
            <div class="stat-desc">In progress</div>
        </div>
    </div>

    <!-- Wishlist Items -->
    <div class="stats shadow bg-white dark:bg-gray-800">
        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Wishlist</div>
            <div class="stat-value text-secondary">
                {{ auth()->user()->wishlists()->count() }}
            </div>
            <div class="stat-desc">Saved items</div>
        </div>
    </div>

    <!-- Total Spent -->
    <div class="stats shadow bg-white dark:bg-gray-800">
        <div class="stat">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Total Spent</div>
            <div class="stat-value text-success">
                ৳{{ number_format(auth()->user()->orders()->where('status', 'completed')->sum('total'), 0) }}
            </div>
            <div class="stat-desc">Lifetime value</div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card bg-white dark:bg-gray-800 shadow-lg mb-8">
    <div class="card-body">
        <h2 class="card-title flex items-center justify-between mb-4">
            <span class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Recent Orders
            </span>
            <a href="{{ route('my-orders') }}" class="btn btn-sm btn-ghost btn-primary">View All</a>
        </h2>

        @php
            $recentOrders = auth()->user()->orders()->latest()->take(5)->get();
        @endphp

        @if($recentOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td>
                                <span class="font-mono font-semibold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
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
                                <span class="badge {{ $badgeClass }} badge-sm">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="font-semibold">৳{{ number_format($order->total, 2) }}</td>
                            <td>
                                <a href="{{ route('order.detail', $order->id) }}" class="btn btn-ghost btn-xs">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No orders yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Start shopping to see your orders here!</p>
                <a href="{{ url('/shop') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Track Order -->
    <div class="card bg-gradient-to-br from-primary to-secondary text-white shadow-lg hover:shadow-xl transition-shadow">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <h3 class="card-title text-white">Track Your Order</h3>
            <p class="opacity-90 text-sm">Check the status of your orders in real-time</p>
            <div class="card-actions justify-end mt-4">
                <a href="{{ route('track-order') }}" class="btn btn-sm btn-ghost bg-white/20 hover:bg-white/30 border-0 text-white">
                    Track Now →
                </a>
            </div>
        </div>
    </div>

    <!-- Browse Products -->
    <div class="card bg-gradient-to-br from-accent to-warning text-white shadow-lg hover:shadow-xl transition-shadow">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="card-title text-white">Browse Products</h3>
            <p class="opacity-90 text-sm">Discover our latest collection of products</p>
            <div class="card-actions justify-end mt-4">
                <a href="{{ url('/shop') }}" class="btn btn-sm btn-ghost bg-white/20 hover:bg-white/30 border-0 text-white">
                    Shop Now →
                </a>
            </div>
        </div>
    </div>

    <!-- View Wishlist -->
    <div class="card bg-gradient-to-br from-secondary to-error text-white shadow-lg hover:shadow-xl transition-shadow">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <h3 class="card-title text-white">Your Wishlist</h3>
            <p class="opacity-90 text-sm">View and manage your saved items</p>
            <div class="card-actions justify-end mt-4">
                <a href="{{ route('wishlist') }}" class="btn btn-sm btn-ghost bg-white/20 hover:bg-white/30 border-0 text-white">
                    View Wishlist →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
