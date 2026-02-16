@extends('layouts.frontend')

@section('title', $product->name . ' - Neonman')
@section('meta_description', $product->short_description)

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center space-x-2 text-xs sm:text-sm overflow-x-auto">
            <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 whitespace-nowrap">Home</a>
            <span class="text-gray-400">/</span>
            <a href="{{ url('/shop') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 whitespace-nowrap">Shop</a>
            <span class="text-gray-400">/</span>
            <a href="{{ url('/shop?category=' . $product->category->slug) }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 whitespace-nowrap">
                {{ $product->category->name }}
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 dark:text-gray-100 truncate">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-6 sm:py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12">
        
        <!-- Product Images -->
        <div class="space-y-3 sm:space-y-4">
            <!-- Main Image -->
            <div class="aspect-square bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden">
                @if($product->hasMedia('images'))
                    <img id="mainImage" src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-9xl">
                        @if($product->category->slug === 't-shirts' || $product->category->parent?->slug === 't-shirts') 👕
                        @elseif($product->category->slug === 'hoodies') 🧥
                        @elseif($product->category->slug === 'jackets') 🧥
                        @elseif($product->category->slug === 'socks') 🧦
                        @else 🛍️
                        @endif
                    </div>
                @endif
            </div>

            <!-- Thumbnail Images -->
            @if($product->hasMedia('images') && $product->getMedia('images')->count() > 1)
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->getMedia('images') as $media)
                <button onclick="document.getElementById('mainImage').src='{{ $media->getUrl() }}'" class="aspect-square bg-gray-100 dark:bg-gray-800 rounded overflow-hidden border-2 border-transparent hover:border-primary-900 transition-colors">
                    <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div>
            <!-- Category & Badges -->
            <div class="flex items-center gap-2 mb-3">
                <span class="px-3 py-1 bg-primary-900 text-white text-xs font-bold tracking-wide">
                    {{ strtoupper($product->category->name) }}
                </span>
                @if($product->is_new_arrival)
                <span class="px-3 py-1 bg-blue-600 text-white text-xs font-bold tracking-wide">
                    NEW
                </span>
                @endif
                @if($product->is_best_seller)
                <span class="px-3 py-1 bg-green-600 text-white text-xs font-bold tracking-wide">
                    BESTSELLER
                </span>
                @endif
            </div>
            
            <!-- Product Name -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $product->name }}
            </h1>

            <!-- Price -->
            <div class="mb-6">
                @if($product->has_discount)
                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <span class="text-2xl sm:text-3xl font-bold text-primary-900 dark:text-primary-400">
                        ৳{{ number_format($product->effective_price, 0) }}
                    </span>
                    <span class="text-lg sm:text-xl text-gray-500 line-through">
                        ৳{{ number_format($product->price, 0) }}
                    </span>
                    <span class="px-2 py-1 bg-red-600 text-white text-sm font-bold tracking-wide">
                        SAVE {{ $product->discount_percentage }}%
                    </span>
                </div>
                @else
                <span class="text-2xl sm:text-3xl font-bold text-primary-900 dark:text-primary-400">
                    ৳{{ number_format($product->effective_price, 0) }}
                </span>
                @endif
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                @if($product->in_stock)
                    @if($product->stock_quantity < 10)
                        <div class="flex items-center gap-2 text-orange-600 dark:text-orange-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Only {{ $product->stock_quantity }} left in stock!</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">In Stock - Ready to Ship</span>
                        </div>
                    @endif
                @else
                    <div class="flex items-center gap-2 text-red-600 dark:text-red-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Out of Stock</span>
                    </div>
                @endif
            </div>

            <!-- Short Description -->
            @if($product->short_description)
            <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                {{ $product->short_description }}
            </p>
            @endif

            <!-- Size Selector -->
            @if($product->sizes && is_array($product->sizes) && count($product->sizes) > 0)
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-900 dark:text-gray-100 mb-3">Select Size</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->sizes as $size)
                    <button type="button" 
                        onclick="selectSize(this, '{{ $size }}')" 
                        class="size-option px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 font-semibold rounded hover:border-primary-900 hover:bg-primary-50 dark:hover:bg-gray-800 transition-all">
                        {{ strtoupper($size) }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Color Selector -->
            @if($product->colors && is_array($product->colors) && count($product->colors) > 0)
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-900 dark:text-gray-100 mb-3">Select Color</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->colors as $color)
                    <button type="button" 
                        onclick="selectColor(this, '{{ $color }}')" 
                        class="color-option px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 font-semibold rounded hover:border-primary-900 hover:bg-primary-50 dark:hover:bg-gray-800 transition-all">
                        {{ ucfirst($color) }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quantity Selector -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-900 dark:text-gray-100 mb-3">Quantity</label>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="decreaseQuantity()" class="w-10 h-10 flex items-center justify-center border-2 border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <input type="number" id="productQuantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                        class="w-20 h-10 text-center border-2 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-semibold">
                    <button type="button" onclick="increaseQuantity({{ $product->stock_quantity }})" class="w-10 h-10 flex items-center justify-center border-2 border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 mb-6 sm:mb-8">
                @if($product->in_stock)
                <button onclick="addToCartFromProductPage()" class="flex-1 px-4 sm:px-6 py-3 sm:py-4 bg-primary-900 hover:bg-primary-950 text-white font-bold text-base sm:text-lg rounded transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    ADD TO CART
                </button>
                @else
                <button disabled class="flex-1 px-4 sm:px-6 py-3 sm:py-4 bg-gray-400 text-white font-bold text-base sm:text-lg rounded cursor-not-allowed">
                    OUT OF STOCK
                </button>
                @endif

                <button onclick="toggleWishlist({{ $product->id }}, this)" 
                    class="wishlist-btn px-4 sm:px-6 py-3 sm:py-4 border-2 border-primary-900 {{ in_array($product->id, session('wishlist', [])) ? 'text-red-600 border-red-600' : 'text-primary-900 dark:text-primary-400' }} font-bold rounded hover:bg-primary-50 dark:hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="{{ in_array($product->id, session('wishlist', [])) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="hidden sm:inline">WISHLIST</span>
                </button>
            </div>

            <!-- Product Features -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 space-y-4">
                <div class="flex items-start gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 text-primary-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <span><strong>Free Shipping</strong> on orders over ৳2000 within Dhaka</span>
                </div>
                <div class="flex items-start gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 text-primary-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span><strong>7 Days Easy Return</strong> & exchange policy</span>
                </div>
                <div class="flex items-start gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 text-primary-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span><strong>100% Genuine Product</strong> guaranteed</span>
                </div>
                <div class="flex items-start gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 text-primary-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span><strong>Cash on Delivery</strong> available</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="mt-8 sm:mt-12">
        <div class="border-b border-gray-200 dark:border-gray-700 overflow-x-auto">
            <nav class="flex gap-4 sm:gap-8 min-w-max">
                <button onclick="switchTab('description')" id="tab-description" class="tab-btn px-1 pb-4 border-b-2 border-primary-900 text-primary-900 dark:text-primary-400 font-semibold">
                    Description
                </button>
                <button onclick="switchTab('specifications')" id="tab-specifications" class="tab-btn px-1 pb-4 border-b-2 border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    Specifications
                </button>
            </nav>
        </div>

        <div class="py-8">
            <!-- Description Tab -->
            <div id="content-description" class="tab-content">
                <div class="prose dark:prose-invert max-w-none">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Specifications Tab -->
            <div id="content-specifications" class="tab-content hidden">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">SKU</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->sku }}</dd>
                    </div>
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Category</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->category->name }}</dd>
                    </div>
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Stock Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}</dd>
                    </div>
                    @if($product->weight)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Weight</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->weight }}g</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
    <div class="mt-12 sm:mt-16">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 sm:mb-6">You May Also Like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($relatedProducts as $related)
                <x-product-card :product="$related" />
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
let selectedSize = null;
let selectedColor = null;

function switchTab(tab) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    // Remove active state from all tab buttons
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('border-primary-900', 'text-primary-900', 'dark:text-primary-400');
        el.classList.add('border-transparent', 'text-gray-600', 'dark:text-gray-400');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tab).classList.remove('hidden');
    // Add active state to selected tab button
    const btn = document.getElementById('tab-' + tab);
    btn.classList.add('border-primary-900', 'text-primary-900', 'dark:text-primary-400');
    btn.classList.remove('border-transparent', 'text-gray-600', 'dark:text-gray-400');
}

function selectSize(button, size) {
    // Remove selected state from all size buttons
    document.querySelectorAll('.size-option').forEach(btn => {
        btn.classList.remove('border-primary-900', 'bg-primary-900', 'text-white');
        btn.classList.add('border-gray-300', 'dark:border-gray-600', 'text-gray-900', 'dark:text-gray-100');
    });
    
    // Add selected state to clicked button
    button.classList.add('border-primary-900', 'bg-primary-900', 'text-white');
    button.classList.remove('border-gray-300', 'dark:border-gray-600', 'text-gray-900', 'dark:text-gray-100');
    
    selectedSize = size;
}

function selectColor(button, color) {
    // Remove selected state from all color buttons
    document.querySelectorAll('.color-option').forEach(btn => {
        btn.classList.remove('border-primary-900', 'bg-primary-900', 'text-white');
        btn.classList.add('border-gray-300', 'dark:border-gray-600', 'text-gray-900', 'dark:text-gray-100');
    });
    
    // Add selected state to clicked button
    button.classList.add('border-primary-900', 'bg-primary-900', 'text-white');
    button.classList.remove('border-gray-300', 'dark:border-gray-600', 'text-gray-900', 'dark:text-gray-100');
    
    selectedColor = color;
}

function increaseQuantity(maxQuantity) {
    const input = document.getElementById('productQuantity');
    const currentValue = parseInt(input.value);
    if (currentValue < maxQuantity) {
        input.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('productQuantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function addToCartFromProductPage() {
    const quantity = parseInt(document.getElementById('productQuantity').value);
    quickAddToCart({{ $product->id }}, quantity, selectedSize, selectedColor);
}
</script>

@endsection
