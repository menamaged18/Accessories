<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Cart Operations
    Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add/{product}', 'add')->name('add');

        Route::post('/remove/{item}', 'remove')->name('remove');
        Route::delete('/{item}', 'destroy')->name('destroy');
        Route::delete('/product/{product}', 'removeByProductId')->name('remove-by-product');
    });

    // Checkout & User Orders
    Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function () {
        Route::get('/', 'showUserOrders')->name('userOrders');
        Route::get('/{order}', 'show')->name('show');
    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/checkout', 'index')->name('checkout.index');
        Route::post('/checkout', 'store')->name('checkout.store');
    });
});

// ----------------------------------------------------------------
// Admin Only Routes
// ----------------------------------------------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Product Management
    Route::resource('products', ProductController::class);

    // Order Management
    Route::get('/orders', [OrderController::class, 'allOrders'])->name('orders.index');
    // Admin bypassing ownership to see order.
    Route::get('/orders/{order}', [OrderController::class, 'showAdminOrder'])->name('orders.show');

    // admin actions like updating status
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
});
