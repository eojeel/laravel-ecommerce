<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
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
        Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('.checkout');
        Route::get('/success', [CheckoutController::class, 'success'])->name('.success');
        Route::get('/failure', [CheckoutController::class, 'failure'])->name('.failure');
    });
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile.view');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
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

require __DIR__.'/auth.php';
