<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Login or Register - ' . config('app.name'))">

    <title>@yield('title', 'Authentication - ' . config('app.name', 'Neonman'))</title>

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
    <main class="min-h-screen py-12 sm:py-16 lg:py-20">
        <div class="container mx-auto px-4">
            @yield('content')
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
