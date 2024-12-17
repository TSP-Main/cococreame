<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

// Home & Static Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
Route::get('faq', [HomeController::class, 'faq'])->name('faq');
Route::get('restaurant-detail', [HomeController::class, 'restaurantDetail']);

// Menu related routes
Route::get('menu', [MenuController::class, 'menu'])->name('menu');
// Route::get('{product:slug}', [MenuController::class, 'product'])->name('product');

// Cart & Checkout
Route::get('cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('destroy', [CartController::class, 'destroy']);
Route::get('checkout', [CartController::class, 'checkoutView'])->name('checkout.view');

