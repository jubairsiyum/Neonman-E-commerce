<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CustomerPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('home');

// Shop & Product Routes
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [FrontendController::class, 'product'])->name('product.show');

// Cart Routes
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/data', [CartController::class, 'data'])->name('data');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::delete('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
});

// Wishlist Routes
Route::get('/wishlist', [CustomerPortalController::class, 'wishlist'])->name('wishlist');

Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');
    Route::delete('/remove/{productId}', [WishlistController::class, 'remove'])->name('remove');
    Route::delete('/clear', [WishlistController::class, 'clear'])->name('clear');
    Route::post('/move-to-cart/{productId}', [WishlistController::class, 'moveToCart'])->name('moveToCart');
});

// Checkout & Order Routes
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/payment-pending/{orderNumber}', [CheckoutController::class, 'paymentPending'])->name('checkout.payment-pending');
Route::get('/checkout/retry-bkash/{orderNumber}', [CheckoutController::class, 'retryBkashPayment'])->name('checkout.retry-bkash');

// Payment Callback Routes
Route::get('/payment/bkash/callback/{orderNumber}', [PaymentCallbackController::class, 'bkashCallback'])->name('bkash.callback');
Route::get('/payment/success/{orderNumber}', [PaymentCallbackController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentCallbackController::class, 'failed'])->name('payment.failed');

// Static Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/new-arrivals', [FrontendController::class, 'newArrivals'])->name('new-arrivals');
Route::get('/best-sellers', [FrontendController::class, 'bestSellers'])->name('best-sellers');

Route::get('/track-order', [CustomerPortalController::class, 'trackOrder'])->name('track-order');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-orders', [CustomerPortalController::class, 'orders'])->name('my-orders');
    Route::get('/my-orders/{order}', [CustomerPortalController::class, 'showOrder'])->name('order.detail');
    Route::post('/my-orders/{order}/cancel', [CustomerPortalController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/profile', [CustomerPortalController::class, 'profile'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Order Print Routes
Route::middleware(['auth', 'verified'])->prefix('admin/orders')->name('admin.orders.')->group(function () {
    Route::get('/{order}/print', function (\App\Models\Order $order) {
        abort_unless(auth()->user()->role === 'admin' || auth()->user()->role === 'moderator', 403);
        return view('orders.print-invoice', ['order' => $order->load('items')]);
    })->name('print');

    Route::get('/{order}/print-slip', function (\App\Models\Order $order) {
        abort_unless(auth()->user()->role === 'admin' || auth()->user()->role === 'moderator', 403);
        return view('orders.print-slip', ['order' => $order->load('items')]);
    })->name('print-slip');
});

require __DIR__.'/auth.php';
