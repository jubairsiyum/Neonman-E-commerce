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
        $products = !empty($wishlistItems) ? \App\Models\Product::whereIn('id', $wishlistItems)->with('category')->get() : collect([]);
    @endphp

    @if($products->isEmpty())
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-12 text-center max-w-md mx-auto">
            <div class="text-6xl mb-4">💝</div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Your wishlist is empty</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Start adding products you love!</p>
            <a href="{{ url('/shop') }}" class="inline-block px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                Continue Shopping
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
                        <div class="absolute top-2 left-2 flex flex-col gap-2">
                            @if($product->is_featured)
                            <span class="px-2 py-1 bg-primary-900 text-white text-xs font-bold rounded">FEATURED</span>
                            @endif
                            @if($product->discount_price)
                            @php
                                $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                            @endphp
                            <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded">-{{ $discountPercent }}%</span>
                            @endif
                        </div>

                        <!-- Remove from Wishlist Button -->
                        <button onclick="removeFromWishlist({{ $product->id }})" class="absolute top-2 right-2 w-8 h-8 flex items-center justify-center bg-white dark:bg-gray-800 text-red-500 rounded-full shadow-md hover:bg-red-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
