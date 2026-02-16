@extends('layouts.frontend')

@section('title', 'Shop - Neonman')
@section('meta_description', 'Browse our collection of premium streetwear and funny t-shirts in Bangladesh')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Shop All Products</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $products->total() }} products found</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Filters Sidebar -->
        <aside class="lg:w-64 flex-shrink-0">
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6 sticky top-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Filters</h2>
                
                <form method="GET" action="{{ url('/shop') }}" id="filterForm">
                    
                    <!-- Categories -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Categories</h3>
                        <div class="space-y-2">
                            @php
                                $categories = \App\Models\Category::where('is_active', true)
                                    ->whereNull('parent_id')
                                    ->orderBy('sort_order')
                                    ->get();
                            @endphp
                            @foreach($categories as $category)
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="categories[]" value="{{ $category->slug }}" 
                                    {{ in_array($category->slug, request()->get('categories', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary-900 border-gray-300 rounded focus:ring-primary-900">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Price Range</h3>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="price" value="0-500" {{ request('price') == '0-500' ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary-900 border-gray-300 focus:ring-primary-900">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Under ৳500</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="price" value="500-1000" {{ request('price') == '500-1000' ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary-900 border-gray-300 focus:ring-primary-900">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">৳500 - ৳1000</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="price" value="1000-2000" {{ request('price') == '1000-2000' ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary-900 border-gray-300 focus:ring-primary-900">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">৳1000 - ৳2000</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="price" value="2000+" {{ request('price') == '2000+' ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary-900 border-gray-300 focus:ring-primary-900">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Above ৳2000</span>
                            </label>
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-900 border-gray-300 rounded focus:ring-primary-900">
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">In Stock Only</span>
                        </label>
                    </div>

                    <!-- Featured -->
                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-900 border-gray-300 rounded focus:ring-primary-900">
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Featured Only</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-primary-900 hover:bg-primary-950 text-white font-medium rounded-lg transition-colors">
                        Apply Filters
                    </button>
                    
                    @if(request()->hasAny(['categories', 'price', 'in_stock', 'featured']))
                    <a href="{{ url('/shop') }}" class="block w-full mt-2 px-4 py-2 text-center border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Clear Filters
                    </a>
                    @endif
                </form>
            </div>
        </aside>

        <!-- Products Grid -->
        <main class="flex-1">
            <!-- Sort & View Options -->
            <div class="flex items-center justify-between mb-6">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>
                
                <form method="GET" action="{{ url('/shop') }}" class="flex items-center gap-2">
                    <!-- Preserve existing filters -->
                    @foreach(request()->except('sort') as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    
                    <select name="sort" onchange="this.form.submit()" class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A to Z</option>
                    </select>
                </form>
            </div>

            <!-- Products -->
            @if($products->isEmpty())
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">No products found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Try adjusting your filters</p>
                    <a href="{{ url('/shop') }}" class="inline-block px-6 py-2 bg-primary-900 hover:bg-primary-950 text-white font-medium rounded-lg transition-colors">
                        Clear All Filters
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>
</div>

@endsection
