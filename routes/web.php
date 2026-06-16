<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatHistoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/produk/{slug}', [CatalogController::class, 'detail'])->name('catalog.detail');
Route::get('/keranjang', [CatalogController::class, 'cart'])->name('catalog.cart');

Route::prefix('catalog-tracker')->group(function () {
    Route::post('/check', [CatalogController::class, 'checkCustomer'])->name('catalog.tracker.check');
    Route::post('/register', [CatalogController::class, 'registerCustomer'])->name('catalog.tracker.register');
    Route::post('/record-visit', [CatalogController::class, 'recordVisit'])->name('catalog.tracker.visit');
    Route::post('/record-interest', [CatalogController::class, 'recordInterest'])->name('catalog.tracker.interest');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');
    Route::resource('customers', CustomerController::class);
    Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
    Route::resource('products', ProductController::class);
    Route::get('transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
    Route::resource('transactions', TransactionController::class);
    Route::resource('chat-histories', ChatHistoryController::class)->only(['index', 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
