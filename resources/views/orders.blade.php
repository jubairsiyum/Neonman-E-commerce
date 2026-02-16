@extends('layouts.frontend')

@section('title', 'My Orders - Neonman')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">My Orders</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ url('/my-orders') }}" class="flex items-center gap-3 px-3 py-2 bg-primary-50 dark:bg-primary-900/10 text-primary-900 dark:text-primary-400 rounded-lg font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        My Orders
                    </a>

                    <a href="{{ route('wishlist') }}" class="flex items-center gap-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Wishlist
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile Settings
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            
            <!-- Filter Tabs -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
                <div class="flex overflow-x-auto">
                    <button class="px-6 py-3 text-sm font-medium text-primary-900 dark:text-primary-400 border-b-2 border-primary-900 dark:border-primary-400 whitespace-nowrap">
                        All Orders (0)
                    </button>
                    <button class="px-6 py-3 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 whitespace-nowrap">
                        Pending (0)
                    </button>
                    <button class="px-6 py-3 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 whitespace-nowrap">
                        Processing (0)
                    </button>
                    <button class="px-6 py-3 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 whitespace-nowrap">
                        Shipped (0)
                    </button>
                    <button class="px-6 py-3 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 whitespace-nowrap">
                        Delivered (0)
                    </button>
                </div>
            </div>

            <!-- Orders List -->
            @php
                // For now, empty orders. This will be replaced with actual orders from database
                $orders = [];
            @endphp

            @if(empty($orders))
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">No orders yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Start shopping to see your orders here!</p>
                <a href="{{ url('/shop') }}" class="inline-block px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                    Start Shopping
                </a>
            </div>
            @else
            <div class="space-y-4">
                <!-- Sample Order Card (will be populated from database) -->
                <!-- <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-1">Order #10001</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Placed on January 15, 2025</p>
                            </div>
                            <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 text-xs font-semibold rounded-full">
                                Processing
                            </span>
                        </div>

                        <div class="flex gap-4 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded overflow-hidden">
                                <img src="" alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-1">Product Name</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Size: M | Qty: 2</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount</p>
                                <p class="text-xl font-bold text-primary-900 dark:text-primary-400">৳2,450</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="#" class="px-4 py-2 border border-primary-900 dark:border-primary-400 text-primary-900 dark:text-primary-400 font-medium rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/10 transition-colors">
                                    View Details
                                </a>
                                <a href="#" class="px-4 py-2 bg-primary-900 hover:bg-primary-950 text-white font-medium rounded-lg transition-colors">
                                    Track Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            @endif

        </div>
    </div>
</div>

@endsection
