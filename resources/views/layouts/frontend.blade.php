<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', config('app.site_description', 'Neonman - Bangladesh\'s funniest streetwear brand'))">
    <meta name="keywords" content="@yield('meta_keywords', 'streetwear bangladesh, funny tshirts, hoodies dhaka, neonman')">

    <title>@yield('title', config('app.name', 'Neonman E-commerce'))</title>

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
<body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200 overflow-x-hidden">
    
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

        // Close mobile menu when clicking outside (on backdrop)
        const mobileMenuBackdrop = document.getElementById('mobileMenuBackdrop');
        if (mobileMenuBackdrop && mobileMenu) {
            mobileMenuBackdrop.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
                document.body.style.overflow = 'auto';
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

        // Show toast notification
        window.showToast = function(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            }`;
            toast.innerHTML = `
                <div class="flex items-center gap-3">
                    ${type === 'success' 
                        ? '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>'
                        : '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>'
                    }
                    <span class="font-medium">${message}</span>
                </div>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };

        // Update cart badge count
        window.updateCartBadge = function(count) {
            const cartBadge = document.getElementById('cartBadge');
            if (cartBadge) {
                cartBadge.textContent = count;
                if (count > 0) {
                    cartBadge.classList.remove('hidden');
                } else {
                    cartBadge.classList.add('hidden');
                }
            }
        };

        // Update wishlist badge count
        window.updateWishlistBadge = function(count) {
            const wishlistBadge = document.getElementById('wishlistBadge');
            if (wishlistBadge) {
                wishlistBadge.textContent = count;
                if (count > 0) {
                    wishlistBadge.classList.remove('hidden');
                } else {
                    wishlistBadge.classList.add('hidden');
                }
            }
        };

        // Quick add to cart function
        window.quickAddToCart = function(productId, quantity = 1, size = null, color = null) {
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            if (size) formData.append('size', size);
            if (color) formData.append('color', color);

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    updateCartBadge(data.cart_count);
                    animateCartIcon();
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
            });
        };

        // Toggle wishlist function
        window.toggleWishlist = function(productId, button = null) {
            const formData = new FormData();
            formData.append('product_id', productId);

            fetch('{{ route("wishlist.toggle") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    updateWishlistBadge(data.wishlist_count);
                    
                    // Update button visual state if button is provided
                    if (button) {
                        const heartIcon = button.querySelector('svg path, svg');
                        if (heartIcon) {
                            if (data.in_wishlist) {
                                button.classList.add('text-red-600');
                                button.classList.remove('text-gray-400');
                            } else {
                                button.classList.remove('text-red-600');
                                button.classList.add('text-gray-400');
                            }
                        }
                    }
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
            });
        };
    </script>

    @stack('scripts')
</body>
</html>
