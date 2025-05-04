<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CreateController as ControllersCreateController;
use App\Http\Controllers\CustomerController;
use GuzzleHttp\Promise\Create;
use App\Http\Controllers\Customer\CreateController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Halaman depan

Route::get('/', function () {
    return view('guest.home');
})->name('guest.home');


// Daftar produk publik
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

/*
|--------------------------------------------------------------------------
| Authentication & Dashboard
|--------------------------------------------------------------------------
*/

// Route auth dari Laravel UI
Auth::routes();

// Dashboard
Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

// Settings (Livewire Volt)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

/*
|--------------------------------------------------------------------------
| customer Routes (login wajib)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (login + role admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    // Approval User
    Route::get('/admin/users', [UserApprovalController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/approve', [UserApprovalController::class, 'approve'])->name('admin.users.approve');

    // Approval Produk
    Route::get('/admin/products/pending', [ProductController::class, 'pending'])->name('admin.products.pending');
    Route::post('/admin/products/{product}/approve', [ProductController::class, 'approve'])->name('admin.products.approve');
    Route::post('/admin/products/{product}/reject', [ProductController::class, 'reject'])->name('admin.products.reject');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
Route::middleware(['auth', CheckRole::class . ':customer'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('customer/products/create', [ProductController::class, 'create'])->name('customer.products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('customer/products/my-product', [ProductController::class, 'myProduct'])->name('customer.products.my-product');

});

