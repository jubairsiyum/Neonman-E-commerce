@extends('layouts.frontend')

@section('title', 'Neonman - Bangladesh\'s Funniest Streetwear Brand')
@section('meta_description', 'Shop funny t-shirts, hoodies, and streetwear in Bangladesh. Neonman brings humor to fashion with witty designs and premium quality.')
@section('meta_keywords', 'streetwear bangladesh, funny tshirts dhaka, neonman, hoodies bangladesh, graphic tees')

@section('content')

<!-- Main Category Hero Section -->
<section class="bg-white dark:bg-gray-900 py-8 md:py-12">
    <div class="container mx-auto px-4">
        <!-- Main Categories Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
            <!-- Men -->
            <a href="{{ url('/shop?gender=men') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        👔
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 z-20">
                        <h3 class="text-white font-bold text-lg group-hover:text-primary-400 transition-colors">Men</h3>
                        <p class="text-white/80 text-xs">Shop Now</p>
                    </div>
                </div>
            </a>

            <!-- Women -->
            <a href="{{ url('/shop?gender=women') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        👗
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 z-20">
                        <h3 class="text-white font-bold text-lg group-hover:text-primary-400 transition-colors">Women</h3>
                        <p class="text-white/80 text-xs">Shop Now</p>
                    </div>
                </div>
            </a>

            <!-- Half Sleeves -->
            <a href="{{ url('/shop?sleeve=half') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        👕
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 z-20">
                        <h3 class="text-white font-bold text-lg group-hover:text-primary-400 transition-colors">Half Sleeves</h3>
                        <p class="text-white/80 text-xs">Shop Now</p>
                    </div>
                </div>
            </a>

            <!-- Full Sleeves -->
            <a href="{{ url('/shop?sleeve=full') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        🧥
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 z-20">
                        <h3 class="text-white font-bold text-lg group-hover:text-primary-400 transition-colors">Full Sleeves</h3>
                        <p class="text-white/80 text-xs">Shop Now</p>
                    </div>
                </div>
            </a>

            <!-- Polo -->
            <a href="{{ url('/shop?category=polo') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        👔
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 z-20">
                        <h3 class="text-white font-bold text-lg group-hover:text-primary-400 transition-colors">Polo</h3>
                        <p class="text-white/80 text-xs">Shop Now</p>
                    </div>
                </div>
            </a>

            <!-- Tops -->
            <a href="{{ url('/shop?category=tops') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        👚
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 z-20">
                        <h3 class="text-white font-bold text-lg group-hover:text-primary-400 transition-colors">Tops</h3>
                        <p class="text-white/80 text-xs">Shop Now</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Quick Stats Banner -->
<section class="py-6 bg-gray-50 dark:bg-gray-800 border-y border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-8 h-8 text-primary-900 dark:text-primary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Free Shipping</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">On orders ৳2000+</div>
            </div>
            <div class="flex flex-col items-center">
                <svg class="w-8 h-8 text-primary-900 dark:text-primary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Easy Returns</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">7 days guarantee</div>
            </div>
            <div class="flex flex-col items-center">
                <svg class="w-8 h-8 text-primary-900 dark:text-primary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Secure Payment</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">100% protected</div>
            </div>
            <div class="flex flex-col items-center">
                <svg class="w-8 h-8 text-primary-900 dark:text-primary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">24/7 Support</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">We're here to help</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-12 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">
                Featured Products
            </h2>
            <a href="{{ url('/shop') }}" class="text-sm font-medium text-primary-900 dark:text-primary-400 hover:underline">
                View All →
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

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

<!-- Promo Banner -->
<section class="py-10 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-block px-3 py-1 bg-primary-900 text-white text-xs font-bold rounded-full mb-3">
                SPECIAL OFFER
            </div>
            <h2 class="text-xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                Get 10% Off Your First Order
            </h2>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-4">
                Use code <span class="font-bold text-primary-900 dark:text-primary-400 bg-white dark:bg-gray-800 px-2 py-1 rounded border border-primary-900 dark:border-primary-400">WELCOME10</span> at checkout
            </p>
        </div>
    </div>
</section>

@endsection
