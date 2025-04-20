<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Auth::routes();

// Vendor
Route::get('/register-vendor', function () {
    return view('auth.register-vendor');
})->name('register.vendor');
// Admin
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Users
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Products
Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
Route::delete('admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


// Categories
Route::get('admin/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::get('admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::post('admin/categories', [CategoryController::class, 'store'])->name('categories.store');

// customer
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/products', [HomeController::class, 'view'])->name('products.view');
Route::get('/products/{slug}', [HomeController::class, 'show'])->name('products.show');
Route::get('transactions', [HomeController::class, 'transactions'])->name('transactions');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

// Cart
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::put('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');

// Trasactions
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/transactions/{id}/detail', [TransactionController::class, 'detail'])->name('transactions.detail');
Route::post('/transactions/{id}/checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');
Route::post('/transactions/{id}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
Route::get('/transactions/{transaction}/success', [TransactionController::class, 'checkoutSuccess'])->name('transactions.success');

Route::post(('/transactions/{id}/feedback'), [TransactionController::class, 'feedback'])->name('transactions.feedback');