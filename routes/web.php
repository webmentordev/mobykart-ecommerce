<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Cart;
use App\Livewire\Home;
use App\Livewire\Product;
use App\Livewire\Products;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/products', Products::class)->name('products');
Route::get('/product/{product:slug}', Product::class)->name('product');
Route::get('/cart', Cart::class)->name('cart');

Route::middleware(['auth', 'verified', 'is_admin'])->prefix('admin')->group(function () {
    // Route for dashboard, admin only
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route for profile, admin only
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes with admin name for route
    Route::name('admin.')->group(function (){
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/create', [ProductController::class, 'store']);
        Route::get('/product/update/{product:slug}', [ProductController::class, 'update'])->name('product.update');
        Route::patch('/product/update/{product:slug}', [ProductController::class, 'edit']);
        Route::patch('/product/status/{product:slug}', [ProductController::class, 'status'])->name('product.status');
        Route::patch('/product/featured/{product:slug}', [ProductController::class, 'featured'])->name('product.feature');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::post('/category/create', [CategoryController::class, 'store']);
        Route::patch('/category/update/{category:slug}', [CategoryController::class, 'update'])->name('category.update');
        Route::patch('/category/status/{category:slug}', [CategoryController::class, 'status'])->name('category.status');

        Route::get('/brands', [BrandController::class, 'index'])->name('brands');
        Route::post('/brand/create', [BrandController::class, 'store']);
        Route::patch('/brand/update/{brand:slug}', [BrandController::class, 'update'])->name('brand.update');
        Route::patch('/brand/status/{brand:slug}', [BrandController::class, 'status'])->name('brand.status');
    });
});

require __DIR__.'/auth.php';