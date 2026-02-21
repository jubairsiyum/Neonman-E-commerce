<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Customer Portal - ' . config('app.name'))">

    <title>@yield('title', 'My Account - ' . config('app.name', 'Neonman'))</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Facebook Pixel -->
    @include('components.facebook-pixel')

    @stack('styles')
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
    
    <!-- Facebook Pixel noscript -->
    <noscript>
        @if(config('services.facebook.pixel_id'))
        <img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ config('services.facebook.pixel_id') }}&ev=PageView&noscript=1"/>
        @endif
    </noscript>
    
    <!-- Header -->
    @include('components.header')

    <!-- Main Content -->
    <main class="min-h-screen py-6 sm:py-8 lg:py-12">
        <div class="container mx-auto px-4">
            <div class="lg:grid lg:grid-cols-12 lg:gap-6 xl:gap-8">
                
                <!-- Sidebar Navigation -->
                <aside class="lg:col-span-3 mb-6 lg:mb-0">
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-24">
                        <!-- User Profile Header -->
                        <div class="p-5 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-3 sm:space-x-4">
                                <div class="relative flex-shrink-0">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-primary-900 to-primary-700 rounded-full flex items-center justify-center shadow-lg shadow-primary-900/30">
                                        <span class="text-xl sm:text-2xl font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-base sm:text-lg text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="p-3 sm:p-4">
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('dashboard')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900/50 @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('my-orders') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('my-orders')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900/50 @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        My Orders
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('wishlist') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('wishlist')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900/50 @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Wishlist
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('profile.*')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900/50 @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('track-order') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('track-order')) bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 @else text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900/50 @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
</svg>
                                        Track Order
                                    </a>
                                </li>
                                
                                <!-- Divider -->
                                <li class="py-2">
                                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                </li>
                                
                                <!-- Logout -->
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content Area -->
                <div class="lg:col-span-9">
                    @yield('content')
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Mobile Menu (Hidden by default) -->
    @include('components.mobile-menu')

    <!-- Dark Mode Script -->
    <script>
        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        const mobileDarkModeToggle = document.getElementById('mobileDarkModeToggle');
        const html = document.documentElement;

        // Check for saved theme preference or default to 'light'
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        // Toggle dark mode
        function toggleDarkMode() {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', toggleDarkMode);
        }
        if (mobileDarkModeToggle) {
            mobileDarkModeToggle.addEventListener('click', toggleDarkMode);
        }

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMobileMenu = document.getElementById('closeMobileMenu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';
            });
        }

        if (closeMobileMenu && mobileMenu) {
            closeMobileMenu.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
                document.body.style.overflow = 'auto';
            });
        }

        // Close mobile menu when clicking outside (on backdrop)
        const mobileMenuBackdrop = document.getElementById('mobileMenuBackdrop');
        if (mobileMenuBackdrop && mobileMenu) {
            mobileMenuBackdrop.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
                document.body.style.overflow = 'auto';
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
