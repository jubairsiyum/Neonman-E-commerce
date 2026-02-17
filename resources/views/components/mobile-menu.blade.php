<!-- Mobile Menu Overlay -->
<div id="mobileMenu" class="fixed inset-0 z-50 lg:hidden transform translate-x-full transition-transform duration-300 ease-in-out">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    
    <!-- Menu Panel -->
    <div class="absolute right-0 top-0 bottom-0 w-full max-w-sm bg-white dark:bg-gray-900 shadow-xl overflow-y-auto">
        
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('logo.svg') }}" alt="Neonman Logo" class="w-16 h-16 transition-transform hover:scale-105">
            </a>
            <button id="closeMobileMenu" type="button" class="p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- User Info (if logged in) -->
        @auth
        <div class="p-4 bg-primary-900 text-white">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-red-100">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
        @else
        <div class="p-4 space-y-2">
            <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-primary-900 hover:bg-primary-950 text-white font-medium rounded-lg transition-all">
                Login
            </a>
            <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 border-2 border-primary-900 text-primary-900 dark:text-primary-400 font-medium rounded-lg hover:bg-primary-50 dark:hover:bg-gray-800 transition-all">
                Sign Up
            </a>
        </div>
        @endauth

        <!-- Search Bar (Mobile) -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <form action="{{ url('/shop') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Search products..." class="w-full px-4 py-2 pl-10 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-900 dark:text-gray-100">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>

        <!-- Navigation Links -->
        <nav class="p-4 space-y-2">
            <a href="{{ url('/') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->is('/') ? 'bg-red-50 dark:bg-gray-800 text-primary-900 dark:text-primary-400' : '' }}">
                🏠 Home
            </a>

            <!-- Shop with Categories -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->is('shop*') ? 'bg-red-50 dark:bg-gray-800 text-primary-900 dark:text-primary-400' : '' }}">
                    <span>🛍️ Shop</span>
                    <svg class="w-5 h-5 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
                    @php
                        $categories = \App\Models\Category::where('is_active', true)
                            ->whereNull('parent_id')
                            ->orderBy('sort_order')
                            ->get();
                    @endphp
                    <a href="{{ url('/shop') }}" class="block px-4 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                        All Products
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ url('/shop?category=' . $category->slug) }}" class="block px-4 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ url('/new-arrivals') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->is('new-arrivals') ? 'bg-red-50 dark:bg-gray-800 text-primary-900 dark:text-primary-400' : '' }}">
                ✨ New Arrivals
            </a>

            <a href="{{ url('/best-sellers') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->is('best-sellers') ? 'bg-red-50 dark:bg-gray-800 text-primary-900 dark:text-primary-400' : '' }}">
                🔥 Best Sellers
            </a>

            @auth
            <a href="{{ url('/wishlist') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                ❤️ Wishlist
                @php
                    $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                @endphp
                @if($wishlistCount > 0)
                <span class="ml-2 px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                    {{ $wishlistCount }}
                </span>
                @endif
            </a>
            @endauth

            <a href="{{ url('/cart') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                🛒 Shopping Cart
                @php
                    $cartCount = \Darryldecode\Cart\Facades\CartFacade::getContent()->count();
                @endphp
                @if($cartCount > 0)
                <span class="ml-2 px-2 py-1 bg-primary-900 text-white text-xs font-bold rounded-full">
                    {{ $cartCount }}
                </span>
                @endif
            </a>

            <hr class="my-4 border-gray-200 dark:border-gray-700">

            <a href="{{ url('/about') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->is('about') ? 'bg-red-50 dark:bg-gray-800 text-primary-900 dark:text-primary-400' : '' }}">
                ℹ️ About Us
            </a>

            <a href="{{ url('/contact') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->is('contact') ? 'bg-red-50 dark:bg-gray-800 text-primary-900 dark:text-primary-400' : '' }}">
                📞 Contact
            </a>

            @auth
            <hr class="my-4 border-gray-200 dark:border-gray-700">

            <a href="{{ url('/dashboard') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                📊 Dashboard
            </a>

            <a href="{{ url('/orders') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                📦 My Orders
            </a>

            <a href="{{ url('/profile') }}" class="block px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                ⚙️ Profile Settings
            </a>
            @endauth
        </nav>

        <!-- Dark Mode Toggle (Mobile) -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <button id="mobileDarkModeToggle" type="button" class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-3 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg class="w-5 h-5 mr-3 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <span class="dark:hidden">Dark Mode</span>
                    <span class="hidden dark:block">Light Mode</span>
                </span>
                <div class="w-12 h-6 bg-gray-300 dark:bg-primary-900 rounded-full relative transition-colors">
                    <div class="absolute top-1 left-1 dark:left-7 w-4 h-4 bg-white rounded-full transition-all duration-200"></div>
                </div>
            </button>
        </div>

        @auth
        <!-- Logout Button -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors">
                    🚪 Logout
                </button>
            </form>
        </div>
        @endauth

        <!-- Footer Info -->
        <div class="p-4 bg-gray-50 dark:bg-gray-800 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} Neonman. All rights reserved.</p>
        </div>
    </div>
</div>

<!-- Alpine.js for mobile menu collapse -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
