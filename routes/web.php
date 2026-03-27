<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/', [ProductController::class, 'index']);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products/store', [ProductController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{id}', [CartController::class, 'add']);

    Route::post('/cart/remove/{itemId}', [CartController::class, 'remove']);
    Route::delete('/cart/delete/{itemId}', [CartController::class, 'destroy']);
    Route::delete('/cart/deleteByProductId/{productId}', [CartController::class, 'removeByProductId']);
});

require __DIR__.'/auth.php';
