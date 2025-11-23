<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleController;

// Public Routes
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // --- Checkout (View & Process) ---
    // 1. The page you see after clicking "Buy Now" or "Checkout" from cart
    Route::get('/checkout', [CartController::class, 'checkoutView'])->name('checkout.view');
    // 2. The action when you click "Place Order"
    Route::post('/checkout', [CartController::class, 'checkoutProcess'])->name('checkout.process');

    // --- Cart Custom Actions ---
    Route::post('/cart/cancel', [CartController::class, 'cancel'])->name('cart.cancel');

    // --- Standard Cart Resource ---
    Route::resource('cart', CartController::class)->except(['create', 'edit', 'show']);

    // --- Orders ---
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
});

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

require __DIR__ . '/settings.php';
