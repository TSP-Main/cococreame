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

// Menu
Route::get('menu', [MenuController::class, 'index'])->name('menu');
// Route::get('{product:slug}', [MenuController::class, 'product'])->name('product');

// Cart & Checkout
Route::get('cart', [CartController::class, 'cartView'])->name('cart.view');
Route::get('checkout', [CartController::class, 'checkoutView'])->name('checkout.view');
