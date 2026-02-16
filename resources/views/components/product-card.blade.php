@props(['product'])

<div class="group bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
    <a href="{{ url('/product/' . $product->slug) }}" class="block relative aspect-square bg-gray-100 dark:bg-gray-800 overflow-hidden">
        @if($product->hasMedia('images'))
            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
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
        <div class="absolute top-2 left-2 right-2 flex items-start justify-between">
            <div class="flex flex-col gap-2">
                @if($product->has_discount)
                <div class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                    -{{ $product->discount_percentage }}%
                </div>
                @endif
                @if($product->is_best_seller)
                <div class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                    🔥 HOT
                </div>
                @endif
            </div>
            @if($product->is_new_arrival)
            <div class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                NEW
            </div>
            @endif
        </div>

        <!-- Wishlist Button -->
        @auth
        <button onclick="toggleWishlist({{ $product->id }})" class="absolute top-2 right-2 w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg hover:scale-110 transform">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>
        @endauth
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
        
        <!-- Price and Add to Cart -->
        <div class="flex items-center justify-between">
            <div>
                @if($product->has_discount)
                <div class="flex items-center gap-2">
                    <span class="text-lg font-bold text-primary-900 dark:text-primary-400">
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
            
            @if($product->in_stock)
            <button onclick="quickAddToCart({{ $product->id }})" class="p-2 rounded-full bg-primary-900 hover:bg-primary-950 text-white transition-colors transform hover:scale-110" title="Add to Cart">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </button>
            @else
            <span class="text-xs text-red-500 font-medium">Out of Stock</span>
            @endif
        </div>

        @if($product->in_stock && $product->stock_quantity < 10)
        <div class="mt-2 text-xs text-orange-500 font-medium">
            ⚠️ Only {{ $product->stock_quantity }} left!
        </div>
        @endif
    </div>
</div>
