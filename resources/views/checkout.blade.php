@extends('layouts.frontend')

@section('title', 'Checkout - Neonman')

@section('content')

<!-- Page Header -->
<div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 py-4 sm:py-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Checkout</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-6 sm:py-8">
    @php
        $cartItems = \Darryldecode\Cart\Facades\CartFacade::getContent();
    @endphp

    @if($cartItems->isEmpty())
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-16 text-center max-w-lg mx-auto">
            <!-- Empty Cart Icon -->
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">Your cart is empty</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Add some products to checkout!</p>
            <a href="{{ url('/shop') }}" class="inline-block px-8 py-3 bg-primary-900 hover:bg-primary-950 text-white font-semibold rounded-lg transition-colors">
                Continue Shopping
            </a>
        </div>
    @else

    <form action="{{ url('/checkout/place-order') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                
                <!-- Customer Information -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Customer Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label for="first_name" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">First Name *</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->name ?? '') }}" required class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                            @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Last Name *</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                            @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="01XXXXXXXXX" class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                            @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Shipping Address</h2>
                    
                    <div class="space-y-3 sm:space-y-4">
                        <div>
                            <label for="address" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Street Address *</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" required placeholder="House/Flat no., Street, Area" class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                            @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label for="division" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Division *</label>
                                <select id="division" name="division" required class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                                    <option value="">Select Division</option>
                                    <option value="Dhaka" {{ old('division') == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                                    <option value="Chittagong" {{ old('division') == 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                                    <option value="Khulna" {{ old('division') == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                                    <option value="Rajshahi" {{ old('division') == 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                                    <option value="Sylhet" {{ old('division') == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                                    <option value="Barisal" {{ old('division') == 'Barisal' ? 'selected' : '' }}>Barisal</option>
                                    <option value="Rangpur" {{ old('division') == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
                                    <option value="Mymensingh" {{ old('division') == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                                </select>
                                @error('division')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City/District *</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" required placeholder="e.g., Dhaka, Chittagong" class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                                @error('city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label for="area" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Area/Thana *</label>
                                <input type="text" id="area" name="area" value="{{ old('area') }}" required placeholder="e.g., Mirpur, Dhanmondi" class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                                @error('area')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="postcode" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postcode</label>
                                <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" placeholder="1200" class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3" placeholder="Additional instructions for delivery..." class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-900">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Payment Method</h2>
                    
                    <div class="space-y-2 sm:space-y-3">
                        <label class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary-900 transition-colors">
                            <input type="radio" name="payment_method" value="cod" checked class="mt-1">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-gray-100">Cash on Delivery (COD)</span>
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded text-xs font-medium text-gray-700 dark:text-gray-300">
                                        COD
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Pay with cash when your order is delivered</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary-900 transition-colors">
                            <input type="radio" name="payment_method" value="bkash" class="mt-1">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-gray-100">bKash</span>
                                    <span class="px-2 py-1 bg-pink-500 text-white rounded text-xs font-bold">
                                        bKash
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Pay securely using bKash mobile banking</p>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Order Summary -->
            <div>
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 sm:p-6 lg:sticky lg:top-4">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">Order Summary</h2>

                    <!-- Cart Items -->
                    <div class="space-y-2 sm:space-y-3 mb-3 sm:mb-4 max-h-60 overflow-y-auto">
                        @foreach($cartItems as $item)
                        <div class="flex gap-2 sm:gap-3">
                            <div class="w-16 h-16 flex-shrink-0 bg-gray-100 dark:bg-gray-800 rounded overflow-hidden">
                                @php
                                    $product = \App\Models\Product::find($item->id);
                                @endphp
                                @if($product && $product->hasMedia('images'))
                                    <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl">👕</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-sm text-gray-900 dark:text-gray-100 truncate">{{ $item->name }}</h4>
                                @if(isset($item->attributes['size']))
                                <p class="text-xs text-gray-600 dark:text-gray-400">Size: {{ $item->attributes['size'] }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }}</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($item->price * $item->quantity, 0) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pricing Summary -->
                    @php
                        $subtotal = \Darryldecode\Cart\Facades\CartFacade::getSubTotal();
                        $shippingFee = $subtotal >= 2000 ? 0 : 100;
                        $total = $subtotal + $shippingFee;
                    @endphp

                    <div class="space-y-1.5 sm:space-y-2 py-3 sm:py-4 border-y border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($subtotal, 0) }}</span>
                        </div>

                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                @if($shippingFee > 0)
                                    ৳{{ number_format($shippingFee, 0) }}
                                @else
                                    <span class="text-green-600">FREE</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-between pt-3 sm:pt-4 mb-4 sm:mb-6">
                        <span class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Total</span>
                        <span class="text-xl sm:text-2xl font-bold text-primary-900 dark:text-primary-400">
                            ৳{{ number_format($total, 0) }}
                        </span>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-primary-900 hover:bg-primary-950 text-white text-sm sm:text-base font-semibold rounded-lg transition-colors">
                        Place Order
                    </button>

                    <p class="text-xs text-center text-gray-600 dark:text-gray-400 mt-4">
                        By placing your order, you agree to our <a href="#" class="text-primary-900 dark:text-primary-400 hover:underline">Terms & Conditions</a>
                    </p>
                </div>
            </div>
        </div>
    </form>

    @endif
</div>

@endsection
