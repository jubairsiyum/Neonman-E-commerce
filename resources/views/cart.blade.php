@extends('layouts.frontend')

@section('title', 'Shopping Cart - Neonman')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Shopping Cart</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            @php
                $cartItems = \Darryldecode\Cart\Facades\CartFacade::getContent();
            @endphp

            @if($cartItems->isEmpty())
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <div class="text-6xl mb-4">🛒</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Your cart is empty</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Add some products to get started!</p>
                    <a href="{{ url('/shop') }}" class="inline-block px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                        Continue Shopping
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                    @php
                        $product = \App\Models\Product::find($item->id);
                    @endphp
                    <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex gap-4">
                            <!-- Product Image -->
                            <div class="w-24 h-24 flex-shrink-0 bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden">
                                @if($product && $product->hasMedia('images'))
                                    <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-4xl">👕</div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $item->name }}</h3>
                                        @if(isset($item->attributes['size']))
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Size: {{ $item->attributes['size'] }}</p>
                                        @endif
                                    </div>
                                    <button onclick="removeFromCart({{ $item->id }})" class="text-red-500 hover:text-red-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Price & Quantity -->
                                <div class="flex justify-between items-center mt-4">
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-2">
                                        <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-8 h-8 flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <span class="w-12 text-center font-medium text-gray-900 dark:text-gray-100">{{ $item->quantity }}</span>
                                        <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-8 h-8 flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Price -->
                                    <div class="text-right">
                                        <div class="font-bold text-primary-900 dark:text-primary-400">
                                            ৳{{ number_format($item->price * $item->quantity, 0) }}
                                        </div>
                                        @if($item->quantity > 1)
                                        <div class="text-xs text-gray-500">
                                            ৳{{ number_format($item->price, 0) }} each
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Continue Shopping Button -->
                <div class="mt-4">
                    <a href="{{ url('/shop') }}" class="inline-flex items-center gap-2 text-primary-900 dark:text-primary-400 hover:underline font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>

        <!-- Order Summary -->
        @if(!$cartItems->isEmpty())
        <div>
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6 sticky top-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h2>

                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal ({{ $cartItems->count() }} items)</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">৳{{ number_format(\Darryldecode\Cart\Facades\CartFacade::getSubTotal(), 0) }}</span>
                    </div>

                    @php
                        $subtotal = \Darryldecode\Cart\Facades\CartFacade::getSubTotal();
                        $shippingFee = $subtotal >= 2000 ? 0 : 100;
                    @endphp

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                        <span class="font-medium text-gray-900 dark:text-gray-100">
                            @if($shippingFee > 0)
                                ৳{{ number_format($shippingFee, 0) }}
                            @else
                                <span class="text-green-600">FREE</span>
                            @endif
                        </span>
                    </div>

                    @if($subtotal < 2000 && $subtotal > 0)
                    <div class="text-xs text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/10 p-2 rounded">
                        Add ৳{{ number_format(2000 - $subtotal, 0) }} more for free shipping!
                    </div>
                    @endif
                </div>

                <!-- Coupon Code -->
                <div class="mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex gap-2">
                        <input type="text" id="couponCode" placeholder="Coupon code" class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                        <button onclick="applyCoupon()" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            Apply
                        </button>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between mb-4">
                        <span class="font-bold text-gray-900 dark:text-gray-100">Total</span>
                        <span class="text-2xl font-bold text-primary-900 dark:text-primary-400">
                            ৳{{ number_format($subtotal + $shippingFee, 0) }}
                        </span>
                    </div>

                    <a href="{{ url('/checkout') }}" class="block w-full px-6 py-3 bg-primary-900 hover:bg-primary-950 text-white text-center font-semibold rounded-lg transition-colors">
                        Proceed to Checkout
                    </a>
                </div>

                <!-- Payment Methods -->
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">We accept:</p>
                    <div class="flex items-center gap-2">
                        <div class="px-2 py-1 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded text-xs font-medium text-gray-700 dark:text-gray-300">
                            COD
                        </div>
                        <div class="px-2 py-1 bg-pink-500 text-white rounded text-xs font-bold">
                            bKash
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function updateQuantity(productId, quantity) {
    if (quantity < 1) return;
    
    // AJAX call to update cart quantity
    console.log('Update quantity:', productId, quantity);
    // TODO: Implement cart update AJAX
}

function removeFromCart(productId) {
    if (confirm('Remove this item from cart?')) {
        // AJAX call to remove from cart
        console.log('Remove from cart:', productId);
        // TODO: Implement cart removal AJAX
    }
}

function applyCoupon() {
    const code = document.getElementById('couponCode').value;
    if (!code) return;
    
    // AJAX call to apply coupon
    console.log('Apply coupon:', code);
    // TODO: Implement coupon validation AJAX
}
</script>

@endsection
