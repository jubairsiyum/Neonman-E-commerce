@extends('layouts.customer')

@section('title', 'My Wishlist - ' . config('app.name'))

@section('content')
<div class="mb-8 flex items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">My Wishlist</h1>
        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">Saved products you can review and buy later.</p>
    </div>
    @if($products->isNotEmpty())
        <button type="button" onclick="clearWishlist()" class="px-4 py-2 rounded-lg border border-red-300 text-red-700 hover:bg-red-50 text-sm font-medium">Clear all</button>
    @endif
</div>

@if($products->isEmpty())
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-10 text-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Wishlist is empty</h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Save products to quickly find them later.</p>
        <a href="{{ route('shop') }}" class="inline-flex mt-4 px-4 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium">Browse products</a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
        @foreach($products as $product)
            <article id="wishlist-item-{{ $product->id }}" class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <a href="{{ route('product.show', $product->slug) }}" class="block aspect-[4/3] bg-gray-100 dark:bg-gray-900/40">
                    @if($product->getFirstMediaUrl('images'))
                        <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @endif
                </a>
                <div class="p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                    <h3 class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $product->name }}</h3>
                    <p class="mt-2 text-lg font-bold text-primary-600 dark:text-primary-400">Tk {{ number_format($product->effective_price, 2) }}</p>

                    <div class="mt-4 flex gap-2">
                        <button type="button" onclick="moveToCart({{ $product->id }})" class="flex-1 px-3 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium">Move to cart</button>
                        <button type="button" onclick="removeFromWishlist({{ $product->id }})" class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200">Remove</button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection

@push('scripts')
<script>
async function apiCall(url, method = 'POST') {
    const response = await fetch(url, {
        method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    });
    return response.json();
}

async function removeFromWishlist(productId) {
    const data = await apiCall(`/wishlist/remove/${productId}`, 'DELETE');
    if (data.success) {
        document.getElementById(`wishlist-item-${productId}`)?.remove();
        if (document.querySelectorAll('[id^="wishlist-item-"]').length === 0) {
            window.location.reload();
        }
    }
}

async function clearWishlist() {
    const data = await apiCall('/wishlist/clear', 'DELETE');
    if (data.success) {
        window.location.reload();
    }
}

async function moveToCart(productId) {
    const data = await apiCall(`/wishlist/move-to-cart/${productId}`, 'POST');
    if (data.success) {
        document.getElementById(`wishlist-item-${productId}`)?.remove();
        if (document.querySelectorAll('[id^="wishlist-item-"]').length === 0) {
            window.location.reload();
        }
    }
}
</script>
@endpush
