<?php

use App\Livewire\Cart;
use App\Livewire\Home;
use App\Livewire\Product;
use App\Models\Product as AllProducts;
use App\Livewire\Products;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductTagController;
use App\Http\Controllers\TrackingController;
use App\Livewire\Brands;
use App\Livewire\Categories;

Route::get('/', Home::class)->name('home');
Route::get('/products', Products::class)->name('products');
Route::get('/products/category/{category:slug}', Categories::class)->name('products.category');
Route::get('/products/brand/{brand:slug}', Brands::class)->name('products.brand');
Route::get('/product/{product:slug}', Product::class)->name('product');
Route::get('/cart', Cart::class)->name('cart');

// Order payment status routes
Route::get('/complete/{order:order_id}', [OrderController::class, 'complete'])->name('completed');
Route::get('/cancel/{order:order_id}', [OrderController::class, 'cancel'])->name('canceled');

// Newsletter Subscription
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.create');

// Policy routes
Route::get('/terms-of-service', [PolicyController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [PolicyController::class, 'privacy'])->name('privacy');
Route::get('/return-policy', [PolicyController::class, 'return'])->name('return');

// Contact routes
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store']);

// Track Order routes
Route::get('/track-order', [TrackingController::class, 'index'])->name('track.order');

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
        Route::patch('/product/featured/{product:slug}', [ProductController::class, 'feature'])->name('product.feature');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::post('/category/create', [CategoryController::class, 'store'])->name('category.create');
        Route::patch('/category/update/{category:slug}', [CategoryController::class, 'update'])->name('category.update');
        Route::patch('/category/status/{category:slug}', [CategoryController::class, 'status'])->name('category.status');

        Route::get('/brands', [BrandController::class, 'index'])->name('brands');
        Route::post('/brand/create', [BrandController::class, 'store'])->name('brand.create');
        Route::patch('/brand/update/{brand:slug}', [BrandController::class, 'update'])->name('brand.update');
        Route::patch('/brand/status/{brand:slug}', [BrandController::class, 'status'])->name('brand.status');

        Route::get('/images', [ImageController::class, 'index'])->name('images');
        Route::post('/image/upload/', [ImageController::class, 'upload'])->name('image.upload');
        Route::post('/image/store/', [ImageController::class, 'store'])->name('image.store');
        Route::delete('/image/delete/{image:slug}', [ImageController::class, 'delete'])->name('image.delete');

        Route::get('/tags', [TagController::class, 'index'])->name('tags');
        Route::post('/tag/store/', [TagController::class, 'store'])->name('tag.store');
        Route::delete('/tag/delete/{tag:slug}', [TagController::class, 'delete'])->name('tag.delete');
        
        Route::get('/product-tags', [ProductTagController::class, 'index'])->name('product.tags');
        Route::post('/product-tag/store/', [ProductTagController::class, 'store'])->name('product.tags.store');
        Route::delete('/product-tag/delete/{tag:slug}', [ProductTagController::class, 'delete'])->name('product.tags.delete');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::patch('/order/status/{order:order_id}', [OrderController::class, 'status'])->name('order.status');

        Route::get('/gallery/images', [GalleryController::class, 'index'])->name('gallery');
        Route::post('/gallery/store/', [GalleryController::class, 'store'])->name('gallery.store');
        Route::patch('/gallery/store/{gallery:slug}', [GalleryController::class, 'status'])->name('gallery.status');
        Route::delete('/gallery/delete/{gallery:slug}', [GalleryController::class, 'delete'])->name('gallery.delete');

        Route::get('/product-discounts', [DiscountController::class, 'index'])->name('product.discount');
        Route::post('/product-discount/store/', [DiscountController::class, 'store'])->name('product.discount.store');
        Route::delete('/product-discount/delete/{discount:slug}', [DiscountController::class, 'delete'])->name('product.discount.delete');

        Route::get('/newsletters', [NewsletterController::class, 'index'])->name('newsletters');

        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
    });
});

Route::get('/sitemap.xml', function(){
    return response()->view('sitemap', [
        'products' => AllProducts::all(),
    ])->header('Content-Type', 'text/xml');
});

require __DIR__.'/auth.php';