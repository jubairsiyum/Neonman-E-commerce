@props(['product'])

@php
    $colorMap = [
        'black' => '#1a1a1a', 'white' => '#f5f5f5', 'red' => '#dc2626',
        'blue' => '#2563eb', 'navy' => '#1e3a5f', 'green' => '#16a34a',
        'yellow' => '#eab308', 'orange' => '#ea580c', 'pink' => '#ec4899',
        'purple' => '#9333ea', 'gray' => '#6b7280', 'grey' => '#6b7280',
        'beige' => '#d4c5a9', 'brown' => '#92400e', 'maroon' => '#7f1d1d',
        'cream' => '#fef3c7', 'olive' => '#65a30d', 'teal' => '#0d9488',
        'cyan' => '#06b6d4', 'gold' => '#ca8a04', 'silver' => '#c0c0c0',
        'charcoal' => '#374151', 'off-white' => '#f9fafb', 'light blue' => '#93c5fd',
        'dark blue' => '#1e40af', 'light pink' => '#fda4af', 'dark green' => '#15803d',
    ];
@endphp

<div class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-500 border border-gray-100 dark:border-gray-800 hover:border-gray-200 dark:hover:border-gray-700">
    <a href="{{ url('/product/' . $product->slug) }}" class="block relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 overflow-hidden">
        @if($product->hasMedia('images'))
            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
        
        <!-- Hover Overlay -->
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-500 z-10 flex items-center justify-center">
            <span class="opacity-0 group-hover:opacity-100 translate-y-3 group-hover:translate-y-0 transition-all duration-300 delay-100 px-5 py-2.5 bg-white text-gray-900 text-sm font-semibold rounded-full shadow-lg hover:bg-gray-900 hover:text-white">
                Quick View
            </span>
        </div>

        <!-- Badges Container -->
        <div class="absolute top-0 left-0 flex flex-col gap-0 z-20">
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

        <!-- Wishlist Button -->
        @auth
        <button onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist({{ $product->id }})" class="absolute top-3 right-3 w-9 h-9 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-md hover:bg-white dark:hover:bg-gray-800 hover:scale-110 transition-all duration-300 z-20 opacity-0 group-hover:opacity-100 translate-y-1 group-hover:translate-y-0">
            <svg class="w-4 h-4 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>
        @endauth
    </a>

    <div class="p-4">
        <div class="text-[11px] text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1.5 font-medium">
            {{ $product->category->name }}
        </div>
        <h3 class="font-semibold text-sm text-gray-900 dark:text-gray-100 mb-2 line-clamp-2 leading-snug font-display">
            <a href="{{ url('/product/' . $product->slug) }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                {{ $product->name }}
            </a>
        </h3>
        
        <!-- Price -->
        <div class="mb-3">
            @if($product->has_discount)
            <div class="flex items-baseline gap-2">
                <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    ৳{{ number_format($product->effective_price, 0) }}
                </span>
                <span class="text-sm text-gray-400 line-through">
                    ৳{{ number_format($product->price, 0) }}
                </span>
            </div>
            @else
            <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                ৳{{ number_format($product->effective_price, 0) }}
            </span>
            @endif
        </div>

        <!-- Color Swatches -->
        @if($product->colors && is_array($product->colors) && count($product->colors) > 0)
        @php
            $flatColors = collect($product->colors)->flatten()->filter(fn ($c) => is_string($c))->values()->take(5);
        @endphp
        @if($flatColors->isNotEmpty())
        <div class="flex items-center gap-1.5 mb-3">
            @foreach($flatColors as $color)
                @php
                    $hex = $colorMap[strtolower($color)] ?? '#9ca3af';
                @endphp
                <span class="w-4 h-4 rounded-full border border-gray-200 dark:border-gray-700 shadow-inner" style="background-color: {{ $hex }}" title="{{ $color }}"></span>
            @endforeach
            @if(count($product->colors) > 5)
                <span class="text-[10px] text-gray-400 font-medium">+{{ count($product->colors) - 5 }}</span>
            @endif
        </div>
        @endif
        @endif

        <!-- Stock Status -->
        @if(!$product->in_stock)
        <div class="mb-2 text-xs text-red-500 dark:text-red-400 font-medium">
            Out of Stock
        </div>
        @elseif($product->stock_quantity < 10)
        <div class="mb-2 text-xs text-amber-600 dark:text-amber-400 font-medium">
            Only {{ $product->stock_quantity }} left
        </div>
        @endif
        
        <!-- Add to Cart Button -->
        @if($product->in_stock)
        <button onclick="quickAddToCart({{ $product->id }})" class="w-full py-2.5 px-4 bg-gray-900 hover:bg-primary-900 dark:bg-white dark:hover:bg-primary-100 dark:text-gray-900 text-white text-sm font-semibold rounded-lg transition-all duration-300 active:scale-[0.97]">
            Add to Cart
        </button>
        @else
        <button disabled class="w-full py-2.5 px-4 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed">
            Sold Out
        </button>
        @endif
    </div>
</div>
