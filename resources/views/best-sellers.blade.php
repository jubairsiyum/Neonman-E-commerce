@extends('layouts.frontend')

@section('title', 'Best Sellers - Neonman')
@section('meta_description', 'Shop Neonman\'s best selling streetwear – the styles our customers love the most.')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-8 sm:py-10">
        <div class="flex items-center gap-3 mb-2">
            <span class="px-3 py-1 bg-gray-900 dark:bg-gray-700 text-white text-xs font-bold tracking-widest uppercase rounded">🔥 Hot</span>
        </div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100">Best Sellers</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Our customers' favourites — {{ $products->total() }} top-rated products</p>
    </div>
</div>

<div class="container mx-auto px-4 py-6 sm:py-8">

    @if($products->isEmpty())
        <div class="text-center py-20">
            <div class="text-6xl mb-4">⭐</div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">No best sellers yet</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Our best sellers will appear here soon.</p>
            <a href="{{ url('/shop') }}" class="inline-block px-8 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                Browse All Products
            </a>
        </div>
    @else
        <!-- Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
