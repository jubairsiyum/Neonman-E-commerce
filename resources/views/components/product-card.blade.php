@props(['product'])

<div class="group bg-white dark:bg-gray-900 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-200 dark:border-gray-700">
    <a href="{{ url('/product/' . $product->slug) }}" class="block relative aspect-[3/4] bg-gray-100 dark:bg-gray-800 overflow-hidden">
        @if($product->hasMedia('images'))
            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center text-6xl">
                @if($product->category->slug === 't-shirts' || $product->category->parent?->slug === 't-shirts') 👕
                @elseif($product->category->slug === 'hoodies') 🧥
                @elseif($product->category->slug === 'jackets') 🧥
                @elseif($product->category->slug === 'socks') 🧦
                @else 🛍️
                @endif
            </div>
        @endif
        
        <!-- Badges Container -->
        <div class="absolute top-0 left-0 flex flex-col gap-0">
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
        <button onclick="toggleWishlist({{ $product->id }})" class="absolute top-3 right-3 w-9 h-9 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-md hover:bg-white dark:hover:bg-gray-800 hover:scale-110 transition-all">
            <svg class="w-4 h-4 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>
        @endauth
    </a>

    <div class="p-3.5">
        <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">
            {{ $product->category->name }}
        </div>
        <h3 class="font-semibold text-sm text-gray-900 dark:text-gray-100 mb-2 line-clamp-2 leading-tight">
            <a href="{{ url('/product/' . $product->slug) }}" class="hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
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

        <!-- Stock Status -->
        @if($product->in_stock)
            @if($product->stock_quantity < 10)
            <div class="mb-2 text-xs text-orange-600 dark:text-orange-400 font-medium">
                Only {{ $product->stock_quantity }} left
            </div>
            @endif
        @else
        <div class="mb-2 text-xs text-red-600 dark:text-red-400 font-medium">
            Out of Stock
        </div>
        @endif
        
        <!-- Add to Cart Button -->
        @if($product->in_stock)
        <button onclick="quickAddToCart({{ $product->id }})" class="w-full py-2 px-4 bg-primary-900 hover:bg-primary-950 text-white text-sm font-medium rounded transition-colors">
            Add to Cart
        </button>
        @else
        <button disabled class="w-full py-2 px-4 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm font-medium rounded cursor-not-allowed">
            Out of Stock
        </button>
        @endif
    </div>
</div>
