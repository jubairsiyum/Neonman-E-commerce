@extends('layouts.frontend')

@section('title', "Neonman - Bangladesh's Funniest Streetwear Brand")
@section('meta_description', 'Shop funny t-shirts, hoodies, and streetwear in Bangladesh. Neonman brings humor to fashion with witty designs and premium quality.')
@section('meta_keywords', 'streetwear bangladesh, funny tshirts dhaka, neonman, hoodies bangladesh, graphic tees')

@section('content')

<!-- HERO BANNER CAROUSEL -->
<style>
@keyframes hero-kenburns {
    0%   { transform: scale(1.06); }
    100% { transform: scale(1); }
}
@keyframes hero-fadeslide {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes carousel-bar {
    from { transform: scaleX(0); }
    to   { transform: scaleX(1); }
}
.hero-img-zoom { animation: hero-kenburns 6s ease-out forwards; }
.hero-content-in { animation: hero-fadeslide 0.6s ease-out forwards; }
</style>

<section
    class="relative w-full bg-black overflow-hidden"
    style="height:90svh;min-height:480px;max-height:860px;"
>
    @if(isset($banners) && $banners->isNotEmpty())

    {{-- ── CAROUSEL ─────────────────────────────────────────────────── --}}
    <div
        x-data="{
            current: 0,
            total: {{ $banners->count() }},
            timer: null,
            tick: 0,
            init() { this.startAuto(); },
            startAuto() {
                if (this.total > 1) {
                    this.timer = setInterval(() => { this.nextSlide(); }, 6000);
                }
            },
            stopAuto() { clearInterval(this.timer); this.timer = null; },
            nextSlide() { this.current = (this.current + 1) % this.total; this.tick++; },
            prevSlide() { this.current = (this.current - 1 + this.total) % this.total; this.tick++; },
            goTo(i) { this.current = i; this.tick++; }
        }"
        @mouseenter="stopAuto()"
        @mouseleave="startAuto()"
        class="absolute inset-0"
    >
        {{-- ── SLIDES ──────────────────────────────────────────────── --}}
        @foreach($banners as $index => $banner)
        <div
            x-show="current === {{ $index }}"
            x-transition:enter="transition-opacity duration-700 ease-in-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-500 ease-in-out"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0"
            style="display:none;"
        >
            {{-- ── IMAGE ── --}}
            @if($banner->image)
            <div class="absolute inset-0 overflow-hidden">
                <img
                    src="{{ asset('storage/' . $banner->image) }}"
                    alt="{{ $banner->title }}"
                    class="w-full h-full object-cover object-center hero-img-zoom"
                    :key="tick"
                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                >
            </div>
            {{-- Bottom scrim — editorial, not full overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
            @else
            {{-- No-image fallback --}}
            <div class="absolute inset-0" style="background:linear-gradient(135deg,#0f0f0f 0%,#1a0007 60%,#4C0519 100%);"></div>
            <div class="absolute inset-0 opacity-[0.07]" style="background-image:repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%);background-size:20px 20px;"></div>
            @endif

            {{-- ── CONTENT — bottom-left anchored, fashion editorial ── --}}
            <div class="relative h-full flex items-end pb-14 sm:pb-16 md:pb-20">
                <div class="w-full px-5 sm:px-10 md:px-16 lg:px-20">
                    <div class="max-w-xl hero-content-in">

                        {{-- Collection label --}}
                        @if($banner->description)
                        <p class="text-xs sm:text-sm font-bold tracking-[0.25em] uppercase text-primary-400 mb-3 md:mb-4">
                            {{ $banner->description }}
                        </p>
                        @endif

                        {{-- Main headline --}}
                        @if($banner->title)
                        <h2 class="font-black text-white leading-none tracking-tight mb-5 md:mb-7"
                            style="font-size:clamp(2.2rem,7vw,5rem);line-height:0.95;letter-spacing:-0.02em;text-shadow:0 4px 32px rgba(0,0,0,0.6);">
                            {!! nl2br(e($banner->title)) !!}
                        </h2>
                        @endif

                        {{-- CTA --}}
                        <div class="flex flex-wrap items-center gap-3">
                            <a
                                href="{{ $banner->link ?: url('/shop') }}"
                                class="group inline-flex items-center gap-2.5 px-6 sm:px-8 py-3 sm:py-3.5 bg-white text-gray-900 font-bold text-sm sm:text-base tracking-wide rounded-none transition-all duration-200 hover:bg-primary-900 hover:text-white"
                            >
                                {{ $banner->button_text ?: 'Shop Now' }}
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            <a
                                href="{{ url('/new-arrivals') }}"
                                class="inline-flex items-center gap-2 px-6 sm:px-8 py-3 sm:py-3.5 text-white/90 hover:text-white font-semibold text-sm sm:text-base border border-white/30 hover:border-white/70 rounded-none transition-all duration-200"
                            >
                                New Arrivals
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- ── ARROWS ───────────────────────────────────────────────── --}}
        @if($banners->count() > 1)
        <button
            @click="prevSlide(); stopAuto(); startAuto();"
            class="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 z-30 w-9 h-9 sm:w-11 sm:h-11 flex items-center justify-center border border-white/25 hover:border-white text-white/70 hover:text-white bg-black/20 hover:bg-black/50 backdrop-blur-sm transition-all duration-200 focus:outline-none"
            aria-label="Previous"
        >
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button
            @click="nextSlide(); stopAuto(); startAuto();"
            class="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 z-30 w-9 h-9 sm:w-11 sm:h-11 flex items-center justify-center border border-white/25 hover:border-white text-white/70 hover:text-white bg-black/20 hover:bg-black/50 backdrop-blur-sm transition-all duration-200 focus:outline-none"
            aria-label="Next"
        >
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- ── BOTTOM BAR: dots + counter ──────────────────────────── --}}
        <div class="absolute bottom-0 left-0 right-0 z-20 flex items-center justify-between px-5 sm:px-10 md:px-16 lg:px-20 py-4">

            {{-- Slide dots --}}
            <div class="flex items-center gap-1.5">
                @foreach($banners as $i => $b)
                <button
                    @click="goTo({{ $i }});"
                    :class="current === {{ $i }} ? 'w-8 bg-white' : 'w-2 bg-white/35 hover:bg-white/60'"
                    class="h-[3px] transition-all duration-400 focus:outline-none"
                    aria-label="Slide {{ $i + 1 }}"
                ></button>
                @endforeach
            </div>

            {{-- Counter --}}
            <span class="font-mono text-xs text-white/50 tracking-widest tabular-nums">
                <span x-text="String(current + 1).padStart(2,'0')"></span>&nbsp;/&nbsp;{{ str_pad($banners->count(), 2, '0', STR_PAD_LEFT) }}
            </span>

        </div>

        {{-- ── AUTO-PLAY PROGRESS LINE ─────────────────────────────── --}}
        <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-white/10 z-30" aria-hidden="true">
            <div
                x-show="timer !== null"
                class="h-full bg-primary-600 origin-left"
                style="animation:carousel-bar 6s linear infinite;"
            ></div>
        </div>
        @endif

    </div>

    @else

    {{-- ── FALLBACK — no banners configured yet ─────────────────────── --}}
    <div class="absolute inset-0" style="background:linear-gradient(160deg,#0f0f0f 0%,#1a0007 50%,#4C0519 100%);"></div>
    <div class="absolute inset-0 opacity-[0.06]" style="background-image:repeating-linear-gradient(45deg,#fff 0,#fff 1px,transparent 0,transparent 50%);background-size:20px 20px;"></div>
    {{-- Grain texture for editorial feel --}}
    <div class="absolute inset-0 opacity-20" style="background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22><filter id=%22n%22><feTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/><feColorMatrix type=%22saturate%22 values=%220%22/></filter><rect width=%22200%22 height=%22200%22 filter=%22url(%23n)%22/></svg>');"></div>

    <div class="relative h-full flex items-end pb-14 sm:pb-20">
        <div class="w-full px-5 sm:px-10 md:px-16 lg:px-20">
            <div class="max-w-2xl">
                <p class="text-xs sm:text-sm font-bold tracking-[0.3em] uppercase text-primary-400 mb-3 md:mb-4">
                    New Collection — 2026
                </p>
                <h1 class="font-black text-white leading-none tracking-tight mb-6"
                    style="font-size:clamp(2.8rem,9vw,6.5rem);line-height:0.92;letter-spacing:-0.03em;text-shadow:0 8px 48px rgba(0,0,0,0.5);">
                    Wear Your<br>Personality.
                </h1>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ url('/shop') }}" class="group inline-flex items-center gap-2.5 px-8 py-3.5 bg-white text-gray-900 font-bold text-base tracking-wide hover:bg-primary-900 hover:text-white transition-all duration-200">
                        Shop Now
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ url('/new-arrivals') }}" class="inline-flex items-center gap-2 px-8 py-3.5 text-white/80 hover:text-white font-semibold text-base border border-white/30 hover:border-white/70 transition-all duration-200">
                        New Arrivals
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @endif
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
