@extends('layouts.frontend')

@section('title', "Neonman - Bangladesh's Funniest Streetwear Brand")
@section('meta_description', 'Shop funny t-shirts, hoodies, and streetwear in Bangladesh. Neonman brings humor to fashion with witty designs and premium quality.')
@section('meta_keywords', 'streetwear bangladesh, funny tshirts dhaka, neonman, hoodies bangladesh, graphic tees')

@section('content')

<!-- HERO BANNER CAROUSEL -->
@php
    // Image-only hero slides sourced from admin banners.
    $heroSlides = isset($banners) && $banners->isNotEmpty()
        ? $banners->map(function ($banner) {
            $isExternal = \Illuminate\Support\Str::startsWith($banner->image, ['http://', 'https://', '//']);
            $imagePath = $banner->image ?: 'images/placeholder-product.jpg';
            $isStoragePath = \Illuminate\Support\Str::startsWith($imagePath, ['storage/', '/storage/']);

            return [
                'name' => $banner->title ?: 'Banner',
                'image' => $isExternal
                    ? $imagePath
                    : ($isStoragePath ? asset(ltrim($imagePath, '/')) : asset('storage/' . ltrim($imagePath, '/'))),
                'url' => $banner->link ?: route('shop'),
            ];
        })->values()
        : collect([
            [
                'name' => 'Neonman Banner',
                'image' => asset('images/placeholder-product.jpg'),
                'url' => route('shop'),
            ],
        ]);
@endphp

<style>
.hero-media-stage {
    height: 360px;
}
.hero-media-image {
    transition: transform 900ms cubic-bezier(.22,.61,.36,1);
}
.hero-media-slide:hover .hero-media-image {
    transform: scale(1.035);
}
@media (min-width: 640px) {
    .hero-media-stage {
        height: 440px;
    }
}
@media (min-width: 768px) {
    .hero-media-stage {
        height: 560px;
    }
}
@media (min-width: 1024px) {
    .hero-media-stage {
        height: 680px;
    }
}
@media (min-width: 1280px) {
    .hero-media-stage {
        height: 760px;
    }
}
</style>

<section class="bg-white dark:bg-gray-900" aria-label="Homepage banner hero">
    <div
        x-data="{
            current: 0,
            total: {{ $heroSlides->count() }},
            interval: 5200,
            timer: null,
            touchX: 0,
            init() {
                this.play();
            },
            play() {
                this.pause();
                if (this.total > 1) {
                    this.timer = setInterval(() => this.next(), this.interval);
                }
            },
            pause() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
            },
            next() {
                this.current = (this.current + 1) % this.total;
            },
            prev() {
                this.current = (this.current - 1 + this.total) % this.total;
            },
            goTo(index) {
                this.current = index;
            },
            touchStart(event) {
                this.touchX = event.changedTouches[0].screenX;
            },
            touchEnd(event) {
                const deltaX = event.changedTouches[0].screenX - this.touchX;
                if (Math.abs(deltaX) < 40) return;
                deltaX < 0 ? this.next() : this.prev();
                this.play();
            }
        }"
        @mouseenter="pause()"
        @mouseleave="play()"
        @touchstart.passive="touchStart($event)"
        @touchend.passive="touchEnd($event)"
        class="hero-media-stage relative overflow-hidden"
    >
        @foreach($heroSlides as $index => $slide)
        <a
            href="{{ $slide['url'] }}"
            x-show="current === {{ $index }}"
            x-transition:enter="transition-opacity duration-600 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-400 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="hero-media-slide absolute inset-0 block"
            style="{{ $index === 0 ? 'display:block;' : 'display:none;' }}"
            aria-roledescription="slide"
            aria-label="Slide {{ $index + 1 }}"
        >
            <img
                src="{{ $slide['image'] }}"
                alt="{{ $slide['name'] }}"
                class="hero-media-image absolute inset-0 h-full w-full object-cover object-center"
                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                fetchpriority="{{ $index === 0 ? 'high' : 'low' }}"
                decoding="async"
            >
        </a>
        @endforeach

        @if($heroSlides->count() > 1)
        <button
            @click="prev(); play()"
            class="absolute left-2 sm:left-5 top-1/2 -translate-y-1/2 z-20 h-10 w-10 sm:h-12 sm:w-12 rounded-full border border-white/70 bg-white/15 text-white hover:bg-white/28 shadow-[0_8px_20px_rgba(0,0,0,0.22)] backdrop-blur-[1px] transition-colors"
            aria-label="Previous slide"
        >
            <svg class="mx-auto h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <button
            @click="next(); play()"
            class="absolute right-2 sm:right-5 top-1/2 -translate-y-1/2 z-20 h-10 w-10 sm:h-12 sm:w-12 rounded-full border border-white/70 bg-white/15 text-white hover:bg-white/28 shadow-[0_8px_20px_rgba(0,0,0,0.22)] backdrop-blur-[1px] transition-colors"
            aria-label="Next slide"
        >
            <svg class="mx-auto h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <div class="absolute inset-x-0 bottom-3 sm:bottom-4 z-20 flex justify-center px-3">
            <div class="flex items-center gap-1.5 rounded-full bg-black/20 px-3 py-2 backdrop-blur-sm">
                    @foreach($heroSlides as $dotIndex => $slide)
                    <button
                        @click="goTo({{ $dotIndex }}); play()"
                        :class="current === {{ $dotIndex }} ? 'w-6 bg-white' : 'w-2 bg-white/45 hover:bg-white/80'"
                        class="h-1 rounded-full transition-all duration-300"
                        aria-label="Go to slide {{ $dotIndex + 1 }}"
                    ></button>
                    @endforeach
            </div>
        </div>
        @endif
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
