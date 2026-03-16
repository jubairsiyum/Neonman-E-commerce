<!-- Mobile Menu Overlay -->
<div id="mobileMenu" class="fixed inset-0 z-50 lg:hidden translate-x-full transform transition-transform duration-300 ease-out">
    <div id="mobileMenuBackdrop" class="absolute inset-0 bg-zinc-950/55 backdrop-blur-[1px]"></div>

    <aside class="absolute right-0 top-0 bottom-0 w-[88%] max-w-sm sm:max-w-md overflow-y-auto bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-l border-gray-200/80 dark:border-gray-700/80 shadow-[0_20px_60px_-20px_rgba(0,0,0,0.55)]">
        <div class="sticky top-0 z-10 border-b border-gray-200/80 dark:border-gray-700/80 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl">
            <div class="flex items-center justify-between px-4 py-3.5">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ asset('logo.svg') }}" alt="Neonman Logo" class="h-20 w-20 sm:h-24 sm:w-24 object-contain transition-transform duration-200 hover:scale-[1.03]">
                </a>
                <button id="closeMobileMenu" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" aria-label="Close mobile menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        @auth
        <section class="mx-4 mt-4 rounded-2xl bg-gradient-to-r from-primary-900 to-primary-800 px-4 py-4 text-white shadow-lg">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-white/25 text-base font-bold uppercase">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-white/85">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </section>
        @else
        <section class="mx-4 mt-4 grid grid-cols-2 gap-2">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl bg-primary-900 px-3 py-2.5 text-sm font-semibold text-white hover:bg-primary-950 transition-colors">
                Login
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl border border-primary-900 px-3 py-2.5 text-sm font-semibold text-primary-900 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-gray-800 transition-colors">
                Sign Up
            </a>
        </section>
        @endauth

        <section class="px-4 pt-4">
            <form action="{{ url('/shop') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Search products" class="w-full rounded-xl border border-gray-300/90 dark:border-gray-700/90 bg-white dark:bg-gray-800 py-2.5 pl-10 pr-3 text-sm text-gray-800 dark:text-gray-100 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-900/70">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-4.5 w-4.5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </section>

        <nav class="p-4 space-y-1.5">
            <p class="px-1 pb-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">Main Menu</p>

            <a href="{{ url('/') }}" class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium transition-colors {{ request()->is('/') ? 'bg-primary-50 text-primary-900 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <svg class="h-4.5 w-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10h16V10"></path>
                </svg>
                Home
            </a>

            <div x-data="{ open: {{ request()->is('shop*') ? 'true' : 'false' }} }" class="rounded-xl {{ request()->is('shop*') ? 'bg-primary-50/70 dark:bg-gray-800/80' : '' }}">
                <button @click="open = !open" class="flex w-full items-center justify-between rounded-xl px-3.5 py-3 text-sm font-medium transition-colors {{ request()->is('shop*') ? 'text-primary-900 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <span class="flex items-center gap-3">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M6 12h12M9 17h6"></path>
                        </svg>
                        Shop
                    </span>
                    <svg class="h-4 w-4 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" x-collapse class="space-y-1 px-2 pb-2">
                    @php
                        $categories = \App\Models\Category::where('is_active', true)
                            ->whereNull('parent_id')
                            ->orderBy('sort_order')
                            ->get();
                    @endphp
                    <a href="{{ url('/shop') }}" class="block rounded-lg px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700/80 transition-colors">
                        All Products
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ url('/shop?category=' . $category->slug) }}" class="block rounded-lg px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700/80 transition-colors">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ url('/new-arrivals') }}" class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium transition-colors {{ request()->is('new-arrivals') ? 'bg-primary-50 text-primary-900 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <svg class="h-4.5 w-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 3l2 6 6 2-6 2-2 6-2-6-6-2 6-2 2-6z"></path>
                </svg>
                New Arrivals
            </a>

            <a href="{{ url('/best-sellers') }}" class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium transition-colors {{ request()->is('best-sellers') ? 'bg-primary-50 text-primary-900 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <svg class="h-4.5 w-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.015 3.122a1 1 0 00.95.69h3.285c.969 0 1.371 1.24.588 1.81l-2.658 1.931a1 1 0 00-.364 1.118l1.015 3.122c.3.921-.755 1.688-1.54 1.118l-2.658-1.931a1 1 0 00-1.176 0l-2.658 1.931c-.784.57-1.838-.197-1.539-1.118l1.014-3.122a1 1 0 00-.363-1.118L2.21 8.549c-.783-.57-.38-1.81.588-1.81h3.285a1 1 0 00.95-.69l1.016-3.122z"></path>
                </svg>
                Best Sellers
            </a>

            @php
                $cartCount = \Darryldecode\Cart\Facades\CartFacade::getContent()->count();
            @endphp
            <a href="{{ url('/cart') }}" class="flex items-center justify-between rounded-xl px-3.5 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="flex items-center gap-3">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 2h12"></path>
                    </svg>
                    Cart
                </span>
                @if($cartCount > 0)
                <span class="inline-flex min-w-[1.5rem] items-center justify-center rounded-full bg-primary-900 px-1.5 py-0.5 text-xs font-semibold text-white">{{ $cartCount }}</span>
                @endif
            </a>

            @auth
            @php
                $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
            @endphp
            <a href="{{ url('/wishlist') }}" class="flex items-center justify-between rounded-xl px-3.5 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="flex items-center gap-3">
                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Wishlist
                </span>
                @if($wishlistCount > 0)
                <span class="inline-flex min-w-[1.5rem] items-center justify-center rounded-full bg-rose-500 px-1.5 py-0.5 text-xs font-semibold text-white">{{ $wishlistCount }}</span>
                @endif
            </a>
            @endauth

            <div class="my-3 border-t border-gray-200/80 dark:border-gray-700/80"></div>

            <p class="px-1 pb-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">Pages</p>

            <a href="{{ url('/about') }}" class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium transition-colors {{ request()->is('about') ? 'bg-primary-50 text-primary-900 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <svg class="h-4.5 w-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z"></path>
                </svg>
                About
            </a>

            <a href="{{ url('/contact') }}" class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium transition-colors {{ request()->is('contact') ? 'bg-primary-50 text-primary-900 dark:bg-gray-800 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <svg class="h-4.5 w-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Contact
            </a>

            @auth
            <div class="my-3 border-t border-gray-200/80 dark:border-gray-700/80"></div>

            <p class="px-1 pb-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">Account</p>

            <a href="{{ url('/dashboard') }}" class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="h-4.5 w-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h8V3H3v10zM13 21h8v-6h-8v6zM13 3v8h8V3h-8zM3 21h8v-4H3v4z"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ url('/orders') }}" class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="h-4.5 w-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0H4m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6"></path>
                </svg>
                My Orders
            </a>

            <a href="{{ url('/profile') }}" class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="h-4.5 w-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Profile
            </a>
            @endauth
        </nav>

        <div class="mx-4 mb-4 mt-2 border-t border-gray-200/80 pt-4 dark:border-gray-700/80">
            <button id="mobileDarkModeToggle" type="button" class="flex w-full items-center justify-between rounded-xl px-3.5 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="flex items-center gap-3">
                    <svg class="h-4.5 w-4.5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg class="h-4.5 w-4.5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <span class="dark:hidden">Dark Mode</span>
                    <span class="hidden dark:block">Light Mode</span>
                </span>
                <span class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-300 dark:bg-primary-900 transition-colors">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-all duration-200 translate-x-1 dark:translate-x-6"></span>
                </span>
            </button>
        </div>

        @auth
        <div class="px-4 pb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-red-500 px-4 py-3 text-sm font-semibold text-white hover:bg-red-600 transition-colors">
                    Logout
                </button>
            </form>
        </div>
        @endauth

        <footer class="border-t border-gray-200/80 px-4 py-4 text-center text-xs text-gray-500 dark:border-gray-700/80 dark:text-gray-400">
            <p>&copy; {{ date('Y') }} Neonman. All rights reserved.</p>
        </footer>
    </aside>
</div>
