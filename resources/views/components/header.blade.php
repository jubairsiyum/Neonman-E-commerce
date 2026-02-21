<header class="sticky top-0 z-50 bg-white dark:bg-gray-900 shadow-md transition-colors duration-200">
    <!-- Top Announcement Bar -->
    <div class="bg-primary-900 text-white py-2.5">
        <div class="container mx-auto px-4">
            <p class="text-center text-xs sm:text-sm">
                Free Shipping Over ৳2000 <span class="hidden sm:inline">| Use Code: <span class="font-semibold">WELCOME10</span> for 10% Off</span>
            </p>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" type="button" class="lg:hidden p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Logo -->
                <div class="flex items-center flex-1 lg:flex-initial justify-center lg:justify-start">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ asset('logo.svg') }}" alt="Neonman Logo" class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 transition-transform hover:scale-105">
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors {{ request()->is('/') ? 'text-primary-900 dark:text-primary-400' : '' }}">
                        Home
                    </a>
                    <div class="relative group">
                        <a href="{{ url('/shop') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors flex items-center {{ request()->is('shop*') ? 'text-primary-900 dark:text-primary-400' : '' }}">
                            Shop
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        <!-- Dropdown Menu -->
                        <div class="absolute left-0 mt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2">
                            @php
                                $categories = \App\Models\Category::where('is_active', true)
                                    ->whereNull('parent_id')
                                    ->orderBy('sort_order')
                                    ->get();
                            @endphp
                            @foreach($categories as $category)
                            <a href="{{ url('/shop?category=' . $category->slug) }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                                {{ $category->name }}
                            </a>
                            @endforeach
                            <hr class="my-2 border-gray-200 dark:border-gray-700">
                            <a href="{{ url('/shop') }}" class="block px-4 py-2 text-primary-900 dark:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium transition-colors">
                                View All Products →
                            </a>
                        </div>
                    </div>
                    <a href="{{ url('/new-arrivals') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors {{ request()->is('new-arrivals') ? 'text-primary-900 dark:text-primary-400' : '' }}">
                        New Arrivals
                    </a>
                    <a href="{{ url('/best-sellers') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors {{ request()->is('best-sellers') ? 'text-primary-900 dark:text-primary-400' : '' }}">
                        Best Sellers
                    </a>
                    <a href="{{ url('/about') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors {{ request()->is('about') ? 'text-primary-900 dark:text-primary-400' : '' }}">
                        About
                    </a>
                    <a href="{{ url('/contact') }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors {{ request()->is('contact') ? 'text-primary-900 dark:text-primary-400' : '' }}">
                        Contact
                    </a>
                </div>

                <!-- Right Side Icons -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    
                    <!-- Search Icon (Desktop) -->
                    <button type="button" class="hidden md:block p-2 text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" type="button" class="hidden sm:block p-2 text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>

                    <!-- Wishlist -->
                    @auth
                    <a href="{{ url('/wishlist') }}" class="hidden sm:block relative p-2 text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        @php
                            $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                        @endphp
                        @if($wishlistCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $wishlistCount }}
                        </span>
                        @endif
                    </a>
                    @endauth

                    <!-- Shopping Cart -->
                    <a href="{{ url('/cart') }}" id="cartIcon" class="relative p-2 text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @php
                            $cartCount = \Darryldecode\Cart\Facades\CartFacade::getContent()->count();
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-primary-900 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    @auth
                    <div class="hidden lg:block relative group">
                        <button type="button" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <div class="w-8 h-8 bg-primary-900 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- User Dropdown -->
                        <div class="absolute right-0 mt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2">
                            <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                Dashboard
                            </a>
                            <a href="{{ route('my-orders') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                My Orders
                            </a>
                            <a href="{{ url('/profile') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                Profile Settings
                            </a>
                            <hr class="my-2 border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="hidden md:block px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="hidden md:block px-4 py-2 bg-primary-900 hover:bg-primary-950 text-white rounded-lg transition-all">
                        Sign Up
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
