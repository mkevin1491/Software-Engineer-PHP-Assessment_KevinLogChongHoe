<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/catalogue', [ProductController::class, 'index'])->name('catalogue');

// Only authenticated users can access these routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show'); // optional


require __DIR__ . '/settings.php';
