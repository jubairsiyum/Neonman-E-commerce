<footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 transition-colors duration-200">
    <!-- Main Footer -->
    <div class="container mx-auto px-4 py-8 sm:py-10 lg:py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            
            <!-- Company Info -->
            <div>
                <div class="flex items-center space-x-2 mb-3 sm:mb-4">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary-900 rounded flex items-center justify-center">
                        <span class="text-white font-bold text-lg sm:text-xl">N</span>
                    </div>
                    <span class="text-xl sm:text-2xl font-bold text-primary-900 dark:text-white">
                        Neonman
                    </span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 text-sm">
                    Bangladesh's funniest streetwear brand. Where fashion meets humor and comfort meets chaos.
                </p>
                <div class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                    <p class="flex items-center text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 mr-2 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ config('app.shop_phone', '+880 1XXX-XXXXXX') }}
                    </p>
                    <p class="flex items-center text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 mr-2 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ config('app.shop_email', 'hello@neonman.com') }}
                    </p>
                    <p class="flex items-start text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 mr-2 mt-0.5 text-primary-900 dark:text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ config('app.shop_address', 'Dhaka, Bangladesh') }}</span>
                    </p>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Quick Links</h3>
                <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                    <li>
                        <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/shop') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            Shop All Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/new-arrivals') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            New Arrivals
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/best-sellers') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            Best Sellers
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/about') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            Contact
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/track-order') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            Track Order
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Categories -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Categories</h3>
                <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                    @php
                        $footerCategories = \App\Models\Category::where('is_active', true)
                            ->whereNull('parent_id')
                            ->orderBy('sort_order')
                            ->limit(8)
                            ->get();
                    @endphp
                    @foreach($footerCategories as $category)
                    <li>
                        <a href="{{ url('/shop?category=' . $category->slug) }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Customer Service & Newsletter -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Customer Service</h3>
                <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-sm mb-4 sm:mb-6">
                    <li>
                        <a href="{{ url('/shipping-policy') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            Shipping Policy
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/return-policy') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            Return & Refund
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/privacy-policy') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/terms-conditions') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            Terms & Conditions
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/faq') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-400 transition-colors">
                            FAQs
                        </a>
                    </li>
                </ul>

                <!-- Newsletter Signup -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-2">Newsletter</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">Get updates on new arrivals & exclusive deals!</p>
                    <form action="{{ url('/newsletter/subscribe') }}" method="POST" class="flex">
                        @csrf
                        <input type="email" name="email" placeholder="Your email" required class="flex-1 px-3 py-2 text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary-900 dark:text-gray-100">
                        <button type="submit" class="px-4 py-2 bg-primary-900 hover:bg-primary-950 text-white text-sm font-medium rounded-r-lg transition-all">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                
                <!-- Copyright -->
                <div class="text-sm text-gray-600 dark:text-gray-400 text-center md:text-left">
                    &copy; {{ date('Y') }} <span class="font-semibold text-primary-900 dark:text-primary-400">Neonman</span>. All rights reserved. Made with ❤️ in Bangladesh.
                </div>

                <!-- Social Media Links -->
                <div class="flex items-center space-x-4">
                    <a href="{{ config('app.facebook_url', '#') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-primary-900 hover:text-white dark:hover:bg-primary-900 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="{{ config('app.instagram_url', '#') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-primary-900 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="{{ config('app.twitter_url', '#') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-primary-900 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/@neonman" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-primary-900 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>

                <!-- Payment Methods -->
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-600 dark:text-gray-400">We Accept:</span>
                    <div class="flex items-center space-x-2">
                        <div class="px-2 py-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded text-xs font-medium text-gray-700 dark:text-gray-300">
                            COD
                        </div>
                        <div class="px-2 py-1 bg-pink-500 text-white rounded text-xs font-bold">
                            bKash
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
