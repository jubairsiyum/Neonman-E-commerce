@extends('layouts.frontend')

@section('title', $product->name . ' - Neonman')
@section('meta_description', $product->short_description)

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900">Home</a>
            <span class="text-gray-400">/</span>
            <a href="{{ url('/shop') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900">Shop</a>
            <span class="text-gray-400">/</span>
            <a href="{{ url('/shop?category=' . $product->category->slug) }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900">
                {{ $product->category->name }}
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 dark:text-gray-100">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        
        <!-- Product Images -->
        <div class="space-y-4">
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
                <button onclick="document.getElementById('mainImage').src='{{ $media->getUrl() }}'" class="aspect-square bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-900 transition-colors">
                    <img src="{{ $media->getUrl() }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div>
            <!-- Category Badge -->
            <div class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-800 text-primary-900 dark:text-primary-400 text-xs font-medium rounded-full mb-3">
                {{ $product->category->name }}
            </div>
            
            <!-- Product Name -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $product->name }}
            </h1>

            <!-- Price -->
            <div class="mb-6">
                @if($product->has_discount)
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold text-primary-900 dark:text-primary-400">
                        ৳{{ number_format($product->effective_price, 0) }}
                    </span>
                    <span class="text-xl text-gray-500 line-through">
                        ৳{{ number_format($product->price, 0) }}
                    </span>
                    <span class="px-2 py-1 bg-red-500 text-white text-sm font-bold rounded">
                        -{{ $product->discount_percentage }}%
                    </span>
                </div>
                @else
                <span class="text-3xl font-bold text-primary-900 dark:text-primary-400">
                    ৳{{ number_format($product->effective_price, 0) }}
                </span>
                @endif
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                @if($product->in_stock)
                    @if($product->stock_quantity < 10)
                        <p class="text-orange-500 font-medium">⚠️ Only {{ $product->stock_quantity }} left in stock!</p>
                    @else
                        <p class="text-green-500 font-medium">✓ In Stock</p>
                    @endif
                @else
                    <p class="text-red-500 font-medium">✗ Out of Stock</p>
                @endif
            </div>

            <!-- Short Description -->
            <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                {{ $product->short_description }}
            </p>

            <!-- Size Selector (if variants exist) -->
            @if($product->variants->isNotEmpty())
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">Size</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->variants as $variant)
                    <button class="px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg hover:border-primary-900 transition-colors {{ $variant->stock_quantity > 0 ? '' : 'opacity-50 cursor-not-allowed' }}" 
                        {{ $variant->stock_quantity > 0 ? '' : 'disabled' }}>
                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $variant->size }}</span>
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quantity Selector -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">Quantity</label>
                <div class="flex items-center gap-3">
                    <button class="w-10 h-10 flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <input type="number" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-20 h-10 text-center border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                    <button class="w-10 h-10 flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 mb-6">
                @if($product->in_stock)
                <button onclick="quickAddToCart({{ $product->id }})" class="flex-1 px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Add to Cart
                </button>
                @else
                <button disabled class="flex-1 px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed">
                    Out of Stock
                </button>
                @endif

                @auth
                <button onclick="toggleWishlist({{ $product->id }})" class="px-6 py-3 border-2 border-primary-900 text-primary-900 dark:text-primary-400 font-semibold rounded-lg hover:bg-primary-50 dark:hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Wishlist
                </button>
                @endauth
            </div>

            <!-- Product Features -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 space-y-3">
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <span>Free shipping on orders over ৳2000</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>7 days easy return & exchange</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>100% genuine product</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="mt-12">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex gap-8">
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
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">You May Also Like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($relatedProducts as $related)
                <x-product-card :product="$related" />
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
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
</script>

@endsection
