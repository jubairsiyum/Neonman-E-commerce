@extends('layouts.frontend')

@section('title', 'About Us - Neonman')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4 sm:py-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">About Us</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8 sm:py-10 lg:py-12">
    
    <!-- Hero Section -->
    <div class="max-w-4xl mx-auto text-center mb-10 sm:mb-12 lg:mb-16">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4 sm:mb-6">
            Redefining Bangladeshi Streetwear
        </h2>
        <p class="text-sm sm:text-base md:text-lg text-gray-600 dark:text-gray-400 leading-relaxed">
            Neonman is Bangladesh's premier destination for authentic streetwear fashion. We bring you the latest trends, premium quality, and unbeatable style at prices that won't break the bank.
        </p>
    </div>

    <!-- Story Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center mb-10 sm:mb-12 lg:mb-16">
        <div>
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Our Story</h3>
            <div class="space-y-3 sm:space-y-4 text-sm sm:text-base text-gray-600 dark:text-gray-400">
                <p>
                    Founded in 2025, Neonman started with a simple vision: to make quality streetwear accessible to everyone in Bangladesh. What began as a small online store has grown into one of the most trusted fashion brands in the country.
                </p>
                <p>
                    We believe that great fashion shouldn't come with a hefty price tag. That's why we work directly with manufacturers to bring you premium quality clothing at affordable prices.
                </p>
                <p>
                    Today, we serve thousands of satisfied customers across Bangladesh, delivering style and confidence right to their doorsteps.
                </p>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-lg aspect-[4/3] flex items-center justify-center text-6xl">
            👔
        </div>
    </div>

    <!-- Values Section -->
    <div class="mb-10 sm:mb-12 lg:mb-16">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6 sm:mb-8 lg:mb-10">Our Values</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-base sm:text-lg text-gray-900 dark:text-gray-100 mb-1 sm:mb-2">Quality Guaranteed</h4>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                    Every product is carefully selected and inspected to ensure you receive only the best quality.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">Affordable Pricing</h4>
                <p class="text-gray-600 dark:text-gray-400">
                    Premium fashion at prices everyone can afford. Great style shouldn't cost a fortune.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-900 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">Fast Delivery</h4>
                <p class="text-gray-600 dark:text-gray-400">
                    Quick and reliable delivery across Bangladesh. Your style can't wait, and neither should you.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 rounded-lg p-8 md:p-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <p class="text-3xl md:text-4xl font-bold text-primary-900 dark:text-primary-400 mb-2">10K+</p>
                <p class="text-gray-600 dark:text-gray-400">Happy Customers</p>
            </div>
            <div>
                <p class="text-3xl md:text-4xl font-bold text-primary-900 dark:text-primary-400 mb-2">500+</p>
                <p class="text-gray-600 dark:text-gray-400">Products</p>
            </div>
            <div>
                <p class="text-3xl md:text-4xl font-bold text-primary-900 dark:text-primary-400 mb-2">64</p>
                <p class="text-gray-600 dark:text-gray-400">Districts Covered</p>
            </div>
            <div>
                <p class="text-3xl md:text-4xl font-bold text-primary-900 dark:text-primary-400 mb-2">99%</p>
                <p class="text-gray-600 dark:text-gray-400">Satisfaction Rate</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="text-center mt-16">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
            Join the Neonman Family
        </h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Discover your style. Express yourself. Stand out.
        </p>
        <a href="{{ url('/shop') }}" class="inline-block px-8 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
            Start Shopping
        </a>
    </div>

</div>

@endsection
