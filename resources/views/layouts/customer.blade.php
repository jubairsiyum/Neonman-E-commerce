<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Customer Portal - ' . config('app.name'))">

    <title>@yield('title', 'My Account - ' . config('app.name', 'Neonman'))</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&family=sora:400,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @include('components.facebook-pixel')

    <style>
        :root {
            --brand: #E11D48;
            --brand-hover: #BE123C;
            --brand-alpha: rgba(225, 29, 72, 0.12);
        }

        /* Static Background */
        .ambient-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            overflow: hidden;
            background-color: #F8FAFC;
            transition: background-color 0.3s ease;
        }

        .dark .ambient-bg {
            background-color: #050509;
        }

        /* Static Brand Glow — top-right corner */
        .ambient-bg::before {
            content: '';
            position: absolute;
            top: -160px;
            right: -160px;
            width: 560px;
            height: 560px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.10) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Static Dot Grid */
        .ambient-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(0, 0, 0, 0.045) 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.7;
        }

        .dark .ambient-bg::after {
            background-image: radial-gradient(rgba(255, 255, 255, 0.055) 1px, transparent 1px);
            opacity: 0.8;
        }

        /* Glass Panel Styling */
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.5);
        }

        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.05);
        }

        /* Nav Link Animations */
        .nav-link {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .nav-link:hover {
            transform: translateX(4px);
        }
        .nav-link svg {
            transition: transform 0.3s ease, color 0.3s ease;
        }
        .nav-link:hover svg {
            transform: scale(1.1);
        }
        
        /* Active Link Indicator */
        .nav-link.active {
            background: linear-gradient(90deg, var(--brand-alpha) 0%, transparent 100%);
            color: var(--brand);
            border-left: 2px solid var(--brand);
        }
        .dark .nav-link.active {
            background: linear-gradient(90deg, rgba(225, 29, 72, 0.18) 0%, transparent 100%);
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased text-gray-900 dark:text-gray-100 transition-colors duration-300 relative min-h-screen font-sans">
    
    <div class="ambient-bg" id="ambient-bg"></div>

    <noscript>
        @if(config('services.facebook.pixel_id'))
        <img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ config('services.facebook.pixel_id') }}&ev=PageView&noscript=1"/>
        @endif
    </noscript>
    
    @include('components.header')

    <main class="py-8 sm:py-10 lg:py-14 relative z-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                
                <aside class="lg:col-span-3 mb-8 lg:mb-0">
                    <div class="glass-panel rounded-2xl overflow-hidden sticky top-28 transition-all duration-300 hover:shadow-xl">
                        
                        <div class="p-6 border-b border-gray-200/50 dark:border-white/10 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#E11D48] opacity-10 dark:opacity-20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
                            
                            <div class="flex items-center space-x-4 relative z-10">
                                <div class="relative flex-shrink-0 group cursor-pointer">
                                    <div class="w-16 h-16 bg-gradient-to-br from-[#E11D48] to-[#881337] rounded-full flex items-center justify-center shadow-lg shadow-[#E11D48]/30 transition-transform duration-300 group-hover:scale-105">
                                        <span class="text-2xl font-bold text-white font-['Sora']">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white dark:border-[#0F172A] rounded-full">
                                        <div class="absolute inset-0 rounded-full bg-green-500 animate-ping opacity-75"></div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-white truncate font-['Sora'] tracking-tight">{{ auth()->user()->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <nav class="p-4">
                            <ul class="space-y-1.5 font-medium text-sm">
                                <li>
                                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-colors @if(request()->routeIs('dashboard')) active @else text-gray-600 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-white/5 border-l-2 border-transparent @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 @if(request()->routeIs('dashboard')) text-[#E11D48] @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('my-orders') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-colors @if(request()->routeIs('my-orders')) active @else text-gray-600 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-white/5 border-l-2 border-transparent @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 @if(request()->routeIs('my-orders')) text-[#E11D48] @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        My Orders
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('wishlist') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-colors @if(request()->routeIs('wishlist')) active @else text-gray-600 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-white/5 border-l-2 border-transparent @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 @if(request()->routeIs('wishlist')) text-[#E11D48] @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        Wishlist
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-colors @if(request()->routeIs('profile.*')) active @else text-gray-600 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-white/5 border-l-2 border-transparent @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 @if(request()->routeIs('profile.*')) text-[#E11D48] @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('track-order') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-colors @if(request()->routeIs('track-order')) active @else text-gray-600 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-white/5 border-l-2 border-transparent @endif">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 @if(request()->routeIs('track-order')) text-[#E11D48] @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Track Order
                                    </a>
                                </li>
                                
                                <li class="py-3">
                                    <div class="h-px bg-gradient-to-r from-transparent via-gray-200 dark:via-white/10 to-transparent"></div>
                                </li>
                                
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="nav-link w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors border-l-2 border-transparent">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Sign Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside>

                <div class="lg:col-span-9">
                    @yield('content')
                </div>

            </div>
        </div>
    </main>

    @include('components.footer')

    @include('components.mobile-menu')

    <script>
        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        const mobileDarkModeToggle = document.getElementById('mobileDarkModeToggle');
        const html = document.documentElement;

        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        function toggleDarkMode() {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        if (darkModeToggle) darkModeToggle.addEventListener('click', toggleDarkMode);
        if (mobileDarkModeToggle) mobileDarkModeToggle.addEventListener('click', toggleDarkMode);

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const mobileMenuBackdrop = document.getElementById('mobileMenuBackdrop');

        function openMenu() {
            mobileMenu.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            mobileMenu.classList.add('translate-x-full');
            document.body.style.overflow = '';
        }

        if (mobileMenuBtn && mobileMenu) mobileMenuBtn.addEventListener('click', openMenu);
        if (closeMobileMenu && mobileMenu) closeMobileMenu.addEventListener('click', closeMenu);
        if (mobileMenuBackdrop && mobileMenu) mobileMenuBackdrop.addEventListener('click', closeMenu);
    </script>

    @stack('scripts')
</body>
</html>