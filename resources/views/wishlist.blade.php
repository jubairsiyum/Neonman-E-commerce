@extends('layouts.frontend')

@section('title', 'My Wishlist - Neonman')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">My Wishlist</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    @php
        // For now, using session-based wishlist. Replace with database query for logged-in users
        $wishlistItems = session('wishlist', []);
        $products = !empty($wishlistItems) ? \App\Models\Product::whereIn('id', $wishlistItems)->where('is_active', true)->with('category')->get() : collect([]);
    @endphp

    @if($products->isEmpty())
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-16 text-center max-w-lg mx-auto">
            <!-- Empty Wishlist Icon -->
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">Your wishlist is empty</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Save your favorite items for later. Start adding products you love!</p>
            <a href="{{ url('/shop') }}" class="inline-block px-8 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                Start Shopping
            </a>
        </div>
    @else
        <div class="mb-6 flex items-center justify-between">
            <p class="text-gray-600 dark:text-gray-400">{{ $products->count() }} {{ Str::plural('item', $products->count()) }} in your wishlist</p>
            <button onclick="clearWishlist()" class="text-sm text-red-600 hover:text-red-700 font-medium">
                Clear All
            </button>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $product)
            <div class="relative group">
                <!-- Product Card -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Product Image -->
                    <a href="{{ route('product.show', $product->slug) }}" class="block aspect-[3/4] bg-gray-100 dark:bg-gray-800 overflow-hidden relative">
                        @if($product->hasMedia('images'))
                            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-6xl">👕</div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-0 left-0 flex flex-col gap-0">
                            @if($product->has_discount)
                            <div class="px-3 py-1.5 bg-red-600 text-white text-[10px] font-bold uppercase tracking-wide">
                                -{{ $product->discount_percentage }}%
                            </div>
                            @endif
                            @if($product->is_new_arrival)
                            <div class="px-3 py-1.5 bg-primary-900 text-white text-[10px] font-bold uppercase tracking-wide">
                                New
                            </div>
                            @endif
                            @if($product->is_best_seller)
                            <div class="px-3 py-1.5 bg-gray-900 text-white text-[10px] font-bold uppercase tracking-wide">
                                Best Seller
                            </div>
                            @endif
                        </div>

                        <!-- Remove from Wishlist Button -->
                        <button onclick="removeFromWishlist({{ $product->id }})" class="absolute top-3 right-3 w-9 h-9 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-md hover:bg-red-500 dark:hover:bg-red-500 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </a>

                    <!-- Product Info -->
                    <div class="p-3">
                        <!-- Category -->
                        @if($product->category)
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $product->category->name }}</p>
                        @endif

                        <!-- Product Name -->
                        <a href="{{ route('product.show', $product->slug) }}" class="block">
                            <h3 class="font-semibold text-sm text-gray-900 dark:text-gray-100 mb-2 line-clamp-2 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                                {{ $product->name }}
                            </h3>
                        </a>

                        <!-- Price -->
                        <div class="flex items-center gap-2 mb-3">
                            @if($product->discount_price)
                                <span class="text-lg font-bold text-primary-900 dark:text-primary-400">৳{{ number_format($product->discount_price, 0) }}</span>
                                <span class="text-sm text-gray-500 line-through">৳{{ number_format($product->price, 0) }}</span>
                            @else
                                <span class="text-lg font-bold text-primary-900 dark:text-primary-400">৳{{ number_format($product->price, 0) }}</span>
                            @endif
                        </div>

                        <!-- Add to Cart Button -->
                        @if($product->stock_quantity > 0)
                        <button onclick="quickAddToCart({{ $product->id }})" class="w-full px-4 py-2 bg-primary-900 hover:bg-primary-950 text-white text-sm font-semibold rounded-lg transition-colors">
                            Add to Cart
                        </button>
                        @else
                        <button disabled class="w-full px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm font-semibold rounded-lg cursor-not-allowed">
                            Out of Stock
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Continue Shopping -->
        <div class="mt-8 text-center">
            <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 text-primary-900 dark:text-primary-400 hover:underline font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Continue Shopping
            </a>
        </div>
    @endif
</div>

<script>
function removeFromWishlist(productId) {
    // AJAX call to remove from wishlist
    console.log('Remove from wishlist:', productId);
    // TODO: Implement wishlist removal AJAX
    // After successful removal, reload the page or remove the item from DOM
}

function clearWishlist() {
    if (confirm('Are you sure you want to clear your entire wishlist?')) {
        // AJAX call to clear wishlist
        console.log('Clear wishlist');
        // TODO: Implement clear wishlist AJAX
    }
}

function quickAddToCart(productId) {
    // AJAX call to add to cart and remove from wishlist
    console.log('Add to cart from wishlist:', productId);
    // TODO: Implement add to cart AJAX
}
</script>

@endsection
