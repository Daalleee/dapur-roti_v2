<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [AuthController::class, 'showPublicHome'])->name('home');
Route::get('/produk/{id}', [AuthController::class, 'showProductDetail'])->name('product.detail');
Route::get('/kategori/{id}', [AuthController::class, 'showByCategory'])->name('category.show');

// Additional public routes
Route::get('/tentang-kami', function () {
    return view('pages.tentang-kami');
})->name('tentang-kami');

Route::get('/kontak', function () {
    return view('pages.kontak-kami');
})->name('kontak');

Route::get('/layanan-pelanggan', function () {
    return view('pages.layanan-kami');
})->name('layanan-pelanggan');

// Authentication routes for regular users
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User dashboard and order routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/pesananku', [AuthController::class, 'showOrderHistory'])->name('user.orders');
    Route::get('/checkout/{productId}', [AuthController::class, 'showCheckout'])->name('checkout.form');
    Route::post('/checkout', [AuthController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/upload-bukti-pembayaran', [AuthController::class, 'uploadProofOfPayment'])->name('upload.proof');
    Route::get('/upload-bukti-pembayaran/{orderId}', function ($orderId) {
        return view('checkout.upload-proof', ['orderId' => $orderId]);
    })->name('upload.proof.form');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function() {
        return redirect()->route('login');
    })->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.attempt');
    
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        Route::get('/products', [AdminController::class, 'products'])->name('products.index');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');

        Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.destroy');
        
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
        Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');

        Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.destroy');
        
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
        Route::get('/orders/{id}/edit', [AdminController::class, 'editOrder'])->name('orders.edit');
        Route::put('/orders/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');
        
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
        Route::get('/reports/excel', [AdminController::class, 'generateExcelReport'])->name('reports.excel');
        Route::get('/reports/csv', [AdminController::class, 'generateCsvReport'])->name('reports.csv');
    });
});
