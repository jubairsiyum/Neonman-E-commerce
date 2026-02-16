<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', config('app.site_description', 'Neonman - Bangladesh\'s funniest streetwear brand'))">
    <meta name="keywords" content="@yield('meta_keywords', 'streetwear bangladesh, funny tshirts, hoodies dhaka, neonman')">

    <title>@yield('title', config('app.name', 'Neonman E-commerce'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <!-- Header -->
    @include('components.header')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
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

        // Close mobile menu when clicking outside
        if (mobileMenu) {
            mobileMenu.addEventListener('click', (e) => {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('translate-x-full');
                    document.body.style.overflow = 'auto';
                }
            });
        }

        // Cart icon animation on add to cart
        window.animateCartIcon = function() {
            const cartIcon = document.getElementById('cartIcon');
            if (cartIcon) {
                cartIcon.classList.add('animate-bounce');
                setTimeout(() => {
                    cartIcon.classList.remove('animate-bounce');
                }, 1000);
            }
        };

        // Quick add to cart function
        window.quickAddToCart = function(productId) {
            // TODO: Implement AJAX add to cart
            console.log('Adding product to cart:', productId);
            animateCartIcon();
            // Placeholder alert
            alert('Add to cart functionality coming soon!');
        };

        // Toggle wishlist function
        window.toggleWishlist = function(productId) {
            // TODO: Implement AJAX wishlist toggle
            console.log('Toggle wishlist for product:', productId);
            // Placeholder alert
            alert('Wishlist functionality coming soon!');
        };
    </script>

    @stack('scripts')
</body>
</html>
