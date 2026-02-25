@extends('layouts.frontend')

@section('title', "Neonman - Bangladesh's Funniest Streetwear Brand")
@section('meta_description', 'Shop funny t-shirts, hoodies, and streetwear in Bangladesh. Neonman brings humor to fashion with witty designs and premium quality.')
@section('meta_keywords', 'streetwear bangladesh, funny tshirts dhaka, neonman, hoodies bangladesh, graphic tees')

@section('content')

<!-- HERO BANNER CAROUSEL -->
<section class="relative w-full overflow-hidden bg-gray-900" style="min-height:420px;height:clamp(420px,60vh,680px);">

    @if(isset($banners) && $banners->isNotEmpty())

    {{-- ===================== DYNAMIC CAROUSEL ===================== --}}
    <div
        x-data="{
            current: 0,
            total: {{ $banners->count() }},
            timer: null,
            init() { this.startAuto(); },
            startAuto() {
                if (this.total > 1) {
                    this.timer = setInterval(() => { this.next(); }, 5000);
                }
            },
            stopAuto() { clearInterval(this.timer); this.timer = null; },
            next() { this.current = (this.current + 1) % this.total; },
            prev() { this.current = (this.current - 1 + this.total) % this.total; },
            goTo(i) { this.current = i; }
        }"
        @mouseenter="stopAuto()"
        @mouseleave="startAuto()"
        class="relative w-full h-full"
        style="min-height:inherit;height:inherit;"
    >
        {{-- ── SLIDES ─────────────────────────────────────────────── --}}
        @foreach($banners as $index => $banner)
        <div
            x-show="current === {{ $index }}"
            x-transition:enter="transition-opacity ease-in-out duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in-out duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 w-full h-full"
            style="display:none;"
        >
            {{-- Background image --}}
            @if($banner->image)
            <img
                src="{{ asset('storage/' . $banner->image) }}"
                alt="{{ $banner->title }}"
                class="absolute inset-0 w-full h-full object-cover object-center"
                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/40 to-black/10"></div>
            @else
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-900 to-primary-950"></div>
            <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(rgba(255,255,255,0.6) 1px,transparent 1px);background-size:28px 28px;"></div>
            @endif

            {{-- Slide text content --}}
            <div class="relative h-full flex items-center" style="min-height:inherit;">
                <div class="container mx-auto px-6 sm:px-10 md:px-16" style="max-width:760px;margin-left:0;padding-left:clamp(1.5rem,6vw,5rem);">

                    @if($banner->title)
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[3.5rem] font-black text-white leading-tight mb-4 drop-shadow-lg"
                        style="text-shadow:0 2px 20px rgba(0,0,0,0.5);">
                        {!! nl2br(e($banner->title)) !!}
                    </h1>
                    @endif

                    @if($banner->description)
                    <p class="text-sm sm:text-base md:text-lg text-white/80 mb-7 max-w-lg leading-relaxed drop-shadow">
                        {{ $banner->description }}
                    </p>
                    @endif

                    @if($banner->link || $banner->button_text)
                    <a
                        href="{{ $banner->link ?: url('/shop') }}"
                        class="inline-flex items-center gap-2 px-7 py-3.5 bg-primary-900 hover:bg-primary-800 text-white font-bold text-base rounded-lg transition-all duration-200 hover:shadow-2xl hover:shadow-primary-900/40 hover:-translate-y-0.5 active:translate-y-0"
                    >
                        {{ $banner->button_text ?: 'Shop Now' }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    @endif

                </div>
            </div>
        </div>
        @endforeach

        {{-- ── PREV / NEXT ARROWS ─────────────────────────────────── --}}
        @if($banners->count() > 1)
        <button
            @click="prev(); stopAuto(); startAuto();"
            class="absolute left-3 sm:left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/30 hover:bg-black/60 text-white flex items-center justify-center backdrop-blur-sm border border-white/15 transition-all duration-200 hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
            aria-label="Previous banner"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button
            @click="next(); stopAuto(); startAuto();"
            class="absolute right-3 sm:right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/30 hover:bg-black/60 text-white flex items-center justify-center backdrop-blur-sm border border-white/15 transition-all duration-200 hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
            aria-label="Next banner"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- ── DOT INDICATORS ─────────────────────────────────────── --}}
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
            @foreach($banners as $index => $banner)
            <button
                @click="goTo({{ $index }}); stopAuto(); startAuto();"
                :class="current === {{ $index }} ? 'w-7 bg-white' : 'w-2.5 bg-white/40 hover:bg-white/70'"
                class="h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                aria-label="Go to slide {{ $index + 1 }}"
            ></button>
            @endforeach
        </div>

        {{-- ── SLIDE COUNTER ───────────────────────────────────────── --}}
        <div class="absolute bottom-5 right-5 z-20 px-2.5 py-1 bg-black/30 backdrop-blur-sm rounded-full text-white/70 text-xs font-medium tabular-nums">
            <span x-text="current + 1"></span>&thinsp;/&thinsp;{{ $banners->count() }}
        </div>

        {{-- ── AUTO-PLAY PROGRESS BAR ──────────────────────────────── --}}
        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-white/10 z-20 overflow-hidden">
            <div
                x-show="timer !== null"
                class="h-full bg-primary-500/80"
                style="animation: carousel-progress 5s linear infinite;"
            ></div>
        </div>
        @endif

    </div>

    @else

    {{-- ===================== FALLBACK (no banners) ================ --}}
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-900 to-primary-950"></div>
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(rgba(255,255,255,0.6) 1px,transparent 1px);background-size:28px 28px;"></div>
    <div class="relative h-full flex items-center justify-center" style="min-height:inherit;">
        <div class="container mx-auto px-4 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-900/30 border border-primary-900/50 rounded-full mb-5">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                <span class="text-primary-400 text-xs font-semibold tracking-widest uppercase">New Arrivals Just Dropped</span>
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white leading-tight mb-5">
                Wear Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-primary-600">Personality</span>
            </h1>
            <p class="text-base sm:text-lg text-white/70 mb-8 max-w-xl mx-auto leading-relaxed">
                Bangladesh's funniest streetwear brand — premium quality graphics, unbeatable comfort.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ url('/shop') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary-900 hover:bg-primary-800 text-white font-bold rounded-lg transition-all hover:shadow-lg hover:shadow-primary-900/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Shop Now
                </a>
                <a href="{{ url('/new-arrivals') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-lg border border-white/20 transition-all">
                    New Arrivals →
                </a>
            </div>
        </div>
    </div>

    @endif

    {{-- Progress bar keyframe --}}
    <style>
        @keyframes carousel-progress {
            from { width: 0%; }
            to   { width: 100%; }
        }
    </style>
</section>

<!-- QUICK STATS BAR -->
<section class="py-5 border-y border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5">
                <div class="w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <div class="text-left"><div class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100">Free Shipping</div><div class="text-[11px] text-gray-500 dark:text-gray-400">Orders over ৳2000</div></div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5">
                <div class="w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div class="text-left"><div class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100">Easy Returns</div><div class="text-[11px] text-gray-500 dark:text-gray-400">7-day guarantee</div></div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5">
                <div class="w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="text-left"><div class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100">Secure Payment</div><div class="text-[11px] text-gray-500 dark:text-gray-400">100% protected</div></div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5">
                <div class="w-10 h-10 rounded-full bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="text-left"><div class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100">24/7 Support</div><div class="text-[11px] text-gray-500 dark:text-gray-400">We're always here</div></div>
            </div>
        </div>
    </div>
</section>

<!-- SHOP BY CATEGORY -->
<section class="py-10 sm:py-14 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-6 sm:mb-8">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Shop by Category</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
            <a href="{{ url('/shop?gender=men') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">👔</div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 z-20">
                        <h3 class="text-white font-bold text-sm sm:text-base group-hover:text-primary-400 transition-colors">Men</h3>
                        <p class="text-white/70 text-xs">Shop Now →</p>
                    </div>
                </div>
            </a>
            <a href="{{ url('/shop?gender=women') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">👗</div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 z-20">
                        <h3 class="text-white font-bold text-sm sm:text-base group-hover:text-primary-400 transition-colors">Women</h3>
                        <p class="text-white/70 text-xs">Shop Now →</p>
                    </div>
                </div>
            </a>
            <a href="{{ url('/shop?sleeve=half') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">👕</div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 z-20">
                        <h3 class="text-white font-bold text-sm sm:text-base group-hover:text-primary-400 transition-colors">T-Shirts</h3>
                        <p class="text-white/70 text-xs">Shop Now →</p>
                    </div>
                </div>
            </a>
            <a href="{{ url('/shop?sleeve=full') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">🧥</div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 z-20">
                        <h3 class="text-white font-bold text-sm sm:text-base group-hover:text-primary-400 transition-colors">Hoodies</h3>
                        <p class="text-white/70 text-xs">Shop Now →</p>
                    </div>
                </div>
            </a>
            <a href="{{ url('/shop?category=polo') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">👔</div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 z-20">
                        <h3 class="text-white font-bold text-sm sm:text-base group-hover:text-primary-400 transition-colors">Polo</h3>
                        <p class="text-white/70 text-xs">Shop Now →</p>
                    </div>
                </div>
            </a>
            <a href="{{ url('/shop?category=tops') }}" class="group">
                <div class="relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary-900 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                    <div class="w-full h-full flex items-center justify-center text-7xl">👚</div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 z-20">
                        <h3 class="text-white font-bold text-sm sm:text-base group-hover:text-primary-400 transition-colors">Tops</h3>
                        <p class="text-white/70 text-xs">Shop Now →</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="py-10 sm:py-14 bg-gray-50 dark:bg-gray-800/50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-6 sm:mb-8">
            <div>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Featured Products</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Hand-picked by our team</p>
            </div>
            <a href="{{ url('/shop?featured=1') }}" class="text-sm font-semibold text-primary-900 dark:text-primary-400 hover:underline flex items-center gap-1">View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
        </div>
        @php
            $featuredProducts = \App\Models\Product::with('category')
                ->where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        @endphp
        @if($featuredProducts->isEmpty())
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <div class="text-5xl mb-3">🛍️</div>
            <p class="font-medium">Products coming soon. Check back later!</p>
        </div>
        @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- NEW ARRIVALS  -->
@php
    $newArrivals = \App\Models\Product::with('category')
        ->where('is_active', true)->where('is_new_arrival', true)
        ->orderBy('created_at', 'desc')->limit(4)->get();
@endphp
@if($newArrivals->isNotEmpty())
<section class="py-10 sm:py-14 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-6 sm:mb-8">
            <div class="flex items-center gap-3">
                <span class="inline-block px-3 py-1 bg-primary-900 text-white text-xs font-bold tracking-widest uppercase rounded-full">New</span>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">New Arrivals</h2>
            </div>
            <a href="{{ url('/new-arrivals') }}" class="text-sm font-semibold text-primary-900 dark:text-primary-400 hover:underline flex items-center gap-1">See All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5">
            @foreach($newArrivals as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- PROMO BANNER -->
<section class="py-12 sm:py-16 bg-primary-900 dark:bg-primary-950 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(rgba(255,255,255,0.6) 1px, transparent 1px);background-size:24px 24px;"></div>
    <div class="relative container mx-auto px-4 text-center">
        <p class="inline-block px-4 py-1 bg-white/20 text-white/90 text-xs font-bold tracking-widest uppercase rounded-full mb-4">Limited Offer</p>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-white mb-3">Get 10% Off Your First Order</h2>
        <p class="text-white/80 text-sm sm:text-base mb-6 max-w-lg mx-auto">
            Use code <span class="inline-block mx-1 px-3 py-0.5 bg-white text-primary-900 font-black rounded">WELCOME10</span> at checkout.
        </p>
        <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white hover:bg-gray-100 text-primary-900 font-bold rounded-lg transition-colors shadow-lg">Shop Now & Save</a>
    </div>
</section>

<!-- BEST SELLERS -->
@php
    $bestSellers = \App\Models\Product::with('category')
        ->where('is_active', true)->where('is_best_seller', true)
        ->orderBy('created_at', 'desc')->limit(4)->get();
@endphp
@if($bestSellers->isNotEmpty())
<section class="py-10 sm:py-14 bg-gray-50 dark:bg-gray-800/50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-6 sm:mb-8">
            <div class="flex items-center gap-3">
                <span class="text-2xl">🔥</span>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Best Sellers</h2>
            </div>
            <a href="{{ url('/best-sellers') }}" class="text-sm font-semibold text-primary-900 dark:text-primary-400 hover:underline flex items-center gap-1">See All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5">
            @foreach($bestSellers as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- WHY CHOOSE US -->
<section class="py-10 sm:py-14 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 text-center mb-8 sm:mb-10">Why Choose Neonman?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            <div class="text-center group">
                <div class="w-16 h-16 bg-primary-50 dark:bg-primary-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-900 group-hover:scale-105 transition-all duration-300">
                    <svg class="w-8 h-8 text-primary-900 dark:text-primary-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Premium Quality</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Every product is carefully inspected to ensure you get the best quality.</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-primary-50 dark:bg-primary-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-900 group-hover:scale-105 transition-all duration-300">
                    <svg class="w-8 h-8 text-primary-900 dark:text-primary-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Affordable Prices</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Great style at prices that won't empty your wallet.</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-primary-50 dark:bg-primary-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-900 group-hover:scale-105 transition-all duration-300">
                    <svg class="w-8 h-8 text-primary-900 dark:text-primary-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Fast Delivery</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Quick and reliable delivery across all of Bangladesh.</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-primary-50 dark:bg-primary-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-900 group-hover:scale-105 transition-all duration-300">
                    <svg class="w-8 h-8 text-primary-900 dark:text-primary-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Hassle-Free Returns</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Not happy? Return within 7 days, no questions asked.</p>
            </div>
        </div>
    </div>
</section>

@endsection
