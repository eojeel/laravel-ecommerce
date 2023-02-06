<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guestOrVerified')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->name('index');

    Route::get('/product/{product:slug}', [ProductController::class, 'view'])->name('product.view');

    Route::prefix('/cart')->name('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('.index');
        Route::post('/add/{product:slug}', [CartController::class, 'store'])->name('.add');
        Route::post('/remove/{product:slug}', [CartController::class, 'destroy'])->name('.remove');
        Route::post('/update-quanity/{product:slug}', [CartController::class, 'update'])->name('.update-quanity');
    });
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('/Orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/Orders/{order}', [OrderController::class, 'view'])->name('orders.view');

    /**
     * Checkout Routes.
     */
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::get('/checkout/{order}', [CheckoutController::class, 'checkoutWithSessionId'])->name('cart.checkout-with-session-id');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');
});

/**
 * Admin Routes.
 */
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', function () {
    return Inertia::render('Products/Products');
})->middleware(['auth', 'verified']);

Route::post('/webhook/stripe', [CheckoutController::class, 'webhook'])->name('checkout.webhook');

require __DIR__.'/auth.php';
