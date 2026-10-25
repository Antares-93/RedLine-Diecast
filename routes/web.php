<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use App\Models\Category;

Route::get('/', function () {
    $categories = \App\Models\Category::all();
    $suppliers = \App\Models\Supplier::withCount('purchases')->get();
    
    // Foto Hero Banner
    $featured = \App\Models\Product::whereNotNull('image')->latest()->first() 
                ?? \App\Models\Product::latest()->first();

    // Mengambil produk khusus Red Line Club / Chase untuk kotak sorotan spesial
    $rlcSpecial = \App\Models\Product::whereHas('category', function($q) {
        $q->where('name', 'like', '%Red Line Club%');
    })->latest()->first();

    $scales = \App\Models\Product::select('scale')->distinct()->pluck('scale');
    $products = \App\Models\Product::with('category')->latest()->paginate(10);

    return view('welcome', compact('categories', 'suppliers', 'featured', 'rlcSpecial', 'scales', 'products'));
})->name('home');

// 2. Autentikasi (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 3. Halaman Wajib Login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/sales/{sale}/payment', [App\Http\Controllers\SaleController::class, 'payment'])->name('sales.payment');
    Route::get('/sales/{sale}/success', [App\Http\Controllers\SaleController::class, 'paymentSuccess'])->name('sales.success');

    // Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('suppliers', SupplierController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['show']);
    });

    // Admin & Staff (Operasional Gudang)
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('products', ProductController::class)->except(['index', 'show']);
        Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show']);
        
        Route::post('/hero-banner', [ProductController::class, 'updateBanner'])->name('banner.update');
    });

    // Semua Role (Katalog Lengkap & Transaksi)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
});