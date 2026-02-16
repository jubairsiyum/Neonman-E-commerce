@extends('layouts.frontend')

@section('title', 'Neonman - Bangladesh\'s Funniest Streetwear Brand')
@section('meta_description', 'Shop funny t-shirts, hoodies, and streetwear in Bangladesh. Neonman brings humor to fashion with witty designs and premium quality.')
@section('meta_keywords', 'streetwear bangladesh, funny tshirts dhaka, neonman, hoodies bangladesh, graphic tees')

@section('content')

<!-- Hero Banner Section -->
<section class="relative overflow-hidden bg-primary-900">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="container mx-auto px-4 py-20 md:py-32 relative z-10">
        <div class="max-w-3xl mx-auto text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in-up">
                Overthinking Just Got Stylish
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-red-100">
                Premium streetwear that understands your existential dread. Made in Bangladesh, for Bangladesh.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/shop') }}" class="px-8 py-4 bg-white text-primary-900 font-bold text-lg rounded-lg hover:bg-gray-100 transform hover:scale-105 transition-all shadow-xl">
                    Shop Now
                </a>
                <a href="{{ url('/new-arrivals') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold text-lg rounded-lg hover:bg-white hover:text-primary-900 transform hover:scale-105 transition-all">
                    New Arrivals
                </a>
            </div>
        </div>
    </div>
    <!-- Wave Shape -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white" class="dark:fill-gray-900"/>
        </svg>
    </div>
</section>

<!-- Quick Stats Banner -->
<section class="py-8 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-3xl font-bold text-primary-900 dark:text-primary-400">৳2000+</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Free Shipping</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-primary-900 dark:text-primary-400">7 Days</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Easy Return</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-primary-900 dark:text-primary-400">100%</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Genuine Products</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-primary-900 dark:text-primary-400">24/7</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Support</div>
            </div>
        </div>
    </div>
</section>

<!-- Shop by Category -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                Shop by Category
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Pick your vibe, embrace your chaos
            </p>
        </div>

        @php
            $categories = \App\Models\Category::where('is_active', true)
                ->whereNull('parent_id')
                ->orderBy('sort_order')
                ->get();
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($categories as $category)
            <a href="{{ url('/shop?category=' . $category->slug) }}" class="group">
                <div class="relative bg-gray-100 dark:bg-gray-800 rounded-2xl p-8 text-center hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border-2 border-transparent hover:border-primary-900">
                    <div class="text-5xl mb-4">
                        @if($category->slug === 't-shirts') 👕
                        @elseif($category->slug === 'hoodies') 🧥
                        @elseif($category->slug === 'jackets') 🧥
                        @elseif($category->slug === 'socks') 🧦
                        @elseif($category->slug === 'accessories') 🎒
                        @else 🛍️
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 group-hover:text-primary-900 dark:group-hover:text-primary-400 transition-colors">
                        {{ $category->name }}
                    </h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    Featured Products
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Our most popular anxiety-reducing apparel
                </p>
            </div>
            <a href="{{ url('/shop') }}" class="hidden md:block px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-medium rounded-lg transition-colors">
                View All
            </a>
        </div>

        @php
            $featuredProducts = \App\Models\Product::with('category')
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <div class="group bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                <a href="{{ url('/product/' . $product->slug) }}" class="block relative aspect-square bg-gray-100 dark:bg-gray-800 overflow-hidden">
                    @if($product->hasMedia('images'))
                        <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-6xl">
                            👕
                        </div>
                    @endif
                    
                    @if($product->has_discount)
                    <div class="absolute top-2 left-2 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                        -{{ $product->discount_percentage }}%
                    </div>
                    @endif

                    @if($product->is_new_arrival)
                    <div class="absolute top-2 right-2 px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                        NEW
                    </div>
                    @endif
                </a>

                <div class="p-4">
                    <div class="text-xs text-primary-900 dark:text-primary-400 font-medium mb-1">
                        {{ $product->category->name }}
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2 line-clamp-2 group-hover:text-primary-900 dark:group-hover:text-primary-400 transition-colors">
                        <a href="{{ url('/product/' . $product->slug) }}">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                        {{ $product->short_description }}
                    </p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->has_discount)
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                    ৳{{ number_format($product->effective_price, 0) }}
                                </span>
                                <span class="text-sm text-gray-500 line-through">
                                    ৳{{ number_format($product->price, 0) }}
                                </span>
                            </div>
                            @else
                            <span class="text-lg font-bold text-primary-900 dark:text-primary-400">
                                ৳{{ number_format($product->effective_price, 0) }}
                            </span>
                            @endif
                        </div>
                        <button class="p-2 rounded-full bg-primary-900 hover:bg-primary-950 text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8 md:hidden">
            <a href="{{ url('/shop') }}" class="inline-block px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-medium rounded-lg transition-colors">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Promo Banner -->
<section class="py-16 bg-primary-900 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-5xl font-bold mb-4">
            First Order? Get 10% Off! 🎉
        </h2>
        <p class="text-xl md:text-2xl mb-6 text-red-100">
            Use code <span class="font-bold bg-white text-primary-900 px-4 py-2 rounded-lg">WELCOME10</span> at checkout
        </p>
        <a href="{{ url('/shop') }}" class="inline-block px-8 py-4 bg-white text-primary-900 font-bold text-lg rounded-lg hover:bg-gray-100 transform hover:scale-105 transition-all shadow-xl">
            Start Shopping
        </a>
    </div>
</section>

<!-- New Arrivals -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    New Arrivals ✨
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Fresh designs, same existential dread
                </p>
            </div>
            <a href="{{ url('/new-arrivals') }}" class="hidden md:block px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-medium rounded-lg transition-colors">
                View All
            </a>
        </div>

        @php
            $newArrivals = \App\Models\Product::with('category')
                ->where('is_active', true)
                ->where('is_new_arrival', true)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($newArrivals as $product)
            <div class="group bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                <a href="{{ url('/product/' . $product->slug) }}" class="block relative aspect-square bg-gray-100 dark:bg-gray-800 overflow-hidden">
                    @if($product->hasMedia('images'))
                        <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-6xl">
                            👕
                        </div>
                    @endif
                    <div class="absolute top-2 right-2 px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full animate-pulse">
                        NEW
                    </div>
                </a>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2 line-clamp-1">
                        {{ $product->name }}
                    </h3>
                    <span class="text-lg font-bold text-primary-900 dark:text-primary-400">
                        ৳{{ number_format($product->effective_price, 0) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                Why Neonman?
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Because your wardrobe deserves better punchlines
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    Premium Quality
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    180-280 GSM heavyweight fabric. Built to last longer than your motivation.
                </p>
            </div>

            <div class="text-center p-6">
                <div class="w-16 h-16 bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    Fast Delivery
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    3-5 days nationwide. Faster than Dhaka traffic (low bar, we know).
                </p>
            </div>

            <div class="text-center p-6">
                <div class="w-16 h-16 bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    Funny AF
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Designs that get you. Because therapy is expensive, but tees aren't.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
