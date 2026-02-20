<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Shop & Product Routes
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [FrontendController::class, 'product'])->name('product.show');

// Cart Routes
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::delete('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
});

// Wishlist Routes
Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

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

// User Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/my-orders', function () {
        return view('customer.orders');
    })->name('my-orders');
    
    Route::get('/order/{id}', function ($id) {
        return view('order-detail', ['orderId' => $id]);
    })->name('order.detail');
});

// Static Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/track-order', function () {
    return view('track-order');
})->name('track-order');

Route::get('/dashboard', function () {
    return view('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
