<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guestOrVerified')->group(function () {

Route::get('/', [ProductsController::class, 'index'])->name('index');

Route::get('/product/{product:slug}', [ProductController::class, 'view'])->name('product.view');

Route::prefix('/cart')->name('cart')->group(function() {
    Route::get('/', [CartController::class, 'index'])->name('.index');
    Route::post('/add/{product:slug}', [CartController::class, 'store'])->name('.add');
    Route::post('/remove/{product:slug}', [CartController::class, 'destroy'])->name('.remove');
    Route::post('/update-quanity/{product:slug}', [CartController::class, 'update'])->name('.update-quanity');
    });

});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', function () {
    return Inertia::render('Products/Products');
})->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
