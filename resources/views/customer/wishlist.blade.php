@extends('layouts.customer')

@section('title', 'My Wishlist - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="mb-6 sm:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">My Wishlist</h1>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Save your favorite items for later</p>
</div>

@php
    // For now, using session-based wishlist. Replace with database query for logged-in users
    $wishlistItems = session('wishlist', []);
    $products = !empty($wishlistItems) ? \App\Models\Product::whereIn('id', $wishlistItems)->where('is_active', true)->with('category')->get() : collect([]);
@endphp

@if($products->isEmpty())
    <!-- Empty State -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 sm:p-16 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 dark:bg-gray-900/50 rounded-2xl mb-6">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Your wishlist is empty</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-sm mx-auto">Save your favorite items for later. Start adding products you love!</p>
        <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-900 to-primary-700 hover:from-primary-800 hover:to-primary-600 text-white font-medium rounded-xl shadow-lg shadow-primary-900/30 transition-all transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Start Shopping
        </a>
    </div>
@else
    <!-- Wishlist Header -->
    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $products->count() }} {{ Str::plural('item', $products->count()) }} in your wishlist</p>
        <button onclick="clearWishlist()" class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 font-medium transition-colors">
            Clear All
        </button>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($products as $product)
        <div class="relative group">
            <!-- Product Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:border-primary-300 dark:hover:border-primary-700 transition-colors">
                <!-- Product Image -->
                <a href="{{ route('product.show', $product->slug) }}" class="block aspect-[3/4] bg-gray-100 dark:bg-gray-900/50 overflow-hidden relative">
                    @if($product->hasMedia('images'))
                        <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </a>

                <!-- Product Info -->
                <div class="p-3 sm:p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-2 line-clamp-2">{{ $product->name }}</h3>
                    <p class="text-lg font-bold text-primary-600 dark:text-primary-400 mb-3">৳{{ number_format($product->price, 0) }}</p>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button onclick="addToCart({{ $product->id }})" class="flex-1 px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Add to Cart
                        </button>
                        <button onclick="removeFromWishlist({{ $product->id }})" class="px-3 py-2 border border-gray-300 dark:border-gray-600 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@push('scripts')
<script>
function removeFromWishlist(productId) {
    // Implement wishlist remove logic
    console.log('Remove product:', productId);
}

function clearWishlist() {
    // Implement clear wishlist logic
    console.log('Clear wishlist');
}

function addToCart(productId) {
    // Implement add to cart logic
    console.log('Add to cart:', productId);
}
</script>
@endpush
@endsection
