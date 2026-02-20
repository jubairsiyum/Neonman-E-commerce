@extends('layouts.customer')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
@php
    $orders = auth()->user()->orders()->latest()->get();
@endphp

@if($orders->count() > 0)
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
    <!-- Empty State with Recommendations -->
    <div class="space-y-6 sm:space-y-8">
        
        <!-- Welcome Empty State -->
        <div class="bg-gradient-to-br from-white via-primary-50/30 to-white dark:from-gray-800 dark:via-primary-900/10 dark:to-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="text-center py-10 sm:py-12 px-4">
                <!-- Neon Shopping Bag Icon -->
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-primary-900 to-primary-700 rounded-2xl mb-5 sm:mb-6 shadow-lg shadow-primary-900/30 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                
                <!-- Energetic Headline -->
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3">
                    Your Shopping Adventure Awaits! 🎉
                </h2>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-8 max-w-lg mx-auto">
                    Ready to rock your style? Explore our fresh collections and grab your first NEON MAN order!
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                    <a href="{{ url('/shop') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-3.5 bg-gradient-to-r from-primary-900 to-primary-700 hover:from-primary-800 hover:to-primary-600 text-white font-semibold rounded-xl shadow-lg shadow-primary-900/30 hover:shadow-xl hover:shadow-primary-900/40 transition-all transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Explore Collections
                    </a>
                    <a href="{{ url('/shop?featured=1') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-3.5 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-primary-300 dark:hover:border-primary-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Best Sellers
                    </a>
                </div>
            </div>
        </div>

        <!-- Recommended Products Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-5 sm:px-6 py-4 sm:py-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    Popular Right Now
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Trending items our customers love</p>
            </div>

            @php
                // Get random featured/popular products (limit to 6)
                $recommendedProducts = \App\Models\Product::where('is_active', true)
                    ->inRandomOrder()
                    ->limit(6)
                    ->get();
                
                // Fallback placeholder products if none exist
                if($recommendedProducts->count() === 0) {
                    $recommendedProducts = collect([
                        (object)['id' => 1, 'name' => 'Neon Graphic Tee', 'price' => 1499, 'slug' => '#'],
                        (object)['id' => 2, 'name' => 'Urban Streetwear Hoodie', 'price' => 2999, 'slug' => '#'],
                        (object)['id' => 3, 'name' => 'Maroon Jogger Pants', 'price' => 2199, 'slug' => '#'],
                        (object)['id' => 4, 'name' => 'Neon Snapback Cap', 'price' => 899, 'slug' => '#'],
                        (object)['id' => 5, 'name' => 'Electric Crew Socks', 'price' => 499, 'slug' => '#'],
                        (object)['id' => 6, 'name' => 'Glow Bomber Jacket', 'price' => 4999, 'slug' => '#'],
                    ]);
                }
            @endphp

            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                    @foreach($recommendedProducts as $product)
                    <a href="{{ is_object($product) && isset($product->slug) && $product->slug !== '#' ? route('product.show', $product->slug) : url('/shop') }}" class="group bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 overflow-hidden transition-all hover:shadow-lg hover:-translate-y-1">
                        <!-- Product Image -->
                        <div class="aspect-square bg-gray-100 dark:bg-gray-900 overflow-hidden relative">
                            @if(is_object($product) && method_exists($product, 'getFirstMediaUrl') && $product->getFirstMediaUrl('products'))
                                <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 sm:h-16 sm:w-16 text-gray-300 dark:text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <!-- Quick View Badge -->
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-2 py-1 rounded-lg text-xs font-medium shadow-lg">
                                    Quick View
                                </span>
                            </div>
                        </div>
                        <!-- Product Info -->
                        <div class="p-3 sm:p-4">
                            <h4 class="font-semibold text-sm sm:text-base text-gray-900 dark:text-white mb-1 truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                {{ $product->name }}
                            </h4>
                            <p class="text-base sm:text-lg font-bold text-primary-600 dark:text-primary-400">
                                ৳{{ number_format($product->price, 0) }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- View All Products Link -->
                <div class="mt-5 sm:mt-6 text-center">
                    <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors group">
                        View All Products
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Trust Elements -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 text-center hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-1">Free Shipping</h4>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">On orders over ৳2000</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 text-center hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-1">Easy Returns</h4>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">7-day return policy</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-5 text-center hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 dark:text-white mb-1">Cash on Delivery</h4>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Pay when you receive</p>
            </div>
        </div>

    </div>
@endif
@endsection
