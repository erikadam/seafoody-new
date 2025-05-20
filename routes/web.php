<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GuestOrderController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\Admin\AdminTransferController;
use App\Http\Controllers\Admin\ProductApprovalController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\ProfileController;

// Home (guest)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
    // This page will be accessible only by verified users
})->middleware('verified');
Auth::routes(['verify' => true]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Guest Product Routes
Route::get('/products', [GuestProductController::class, 'index'])->name('guest.products.index');

Route::get('/products/{product}', [GuestProductController::class, 'show'])->name('guest.products.show');

// Guest Cart
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('guest.cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('guest.cart.add');
    Route::post('/remove', [CartController::class, 'remove'])->name('guest.cart.remove');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/request-seller', [ProfileController::class, 'requestSeller'])->name('profile.requestSeller');
});
// Guest Checkout
Route::get('/checkout', [GuestOrderController::class, 'showCheckoutForm'])->name('guest.checkout.form');
Route::get('/order-status/{token}', [GuestOrderController::class, 'trackOrder'])->name('guest.track.order');
Route::post('/order/confirm/{id}', [GuestOrderController::class, 'confirmReceived'])->name('guest.order.confirm');
Route::post('/cart/update', [CartController::class, 'update'])->name('guest.cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('guest.cart.remove');
Route::get('/checkout', [GuestOrderController::class, 'showCheckoutForm'])->name('guest.checkout.form');



// Guest Track Order
use App\Http\Controllers\TrackOrderController;

Route::get('/track-order', [TrackOrderController::class, 'showForm'])->name('guest.track.form');
Route::get('/track-order/result', [TrackOrderController::class, 'searchByToken'])->name('guest.track.result');
Route::get('/nota-pdf/{token}', [TrackOrderController::class, 'downloadPdf'])->name('guest.download.pdf');


// Auth routes

// Admin Routes
Route::prefix('admin')->middleware(['auth', CheckRole::class . ':admin'])->group(function () {
   Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [UserApprovalController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.users.approve');
    Route::post('/transfers/{item}/approve', [AdminTransferController::class, 'approve']);
    Route::get('/transfers', [AdminTransferController::class, 'index'])->name('admin.transfers.index');
    Route::post('/transfers/{id}/approve', [AdminTransferController::class, 'approve'])->name('admin.transfers.approve');
    Route::post('/transfers/{id}/reject', [AdminTransferController::class, 'reject'])->name('admin.transfers.reject');
    Route::get('/products/pending', [ProductApprovalController::class, 'pending'])->name('admin.products.pending');
    Route::post('/products/{product}/approve', [ProductApprovalController::class, 'approve'])->name('admin.products.approve');
    Route::post('/products/{product}/reject', [ProductApprovalController::class, 'reject'])->name('admin.products.reject');
    Route::post('/users/suspend', [App\Http\Controllers\Admin\UserController::class, 'suspend'])->name('admin.users.suspend');
    Route::post('/users/unsuspend', [App\Http\Controllers\Admin\UserController::class, 'unsuspend'])->name('admin.users.unsuspend');
    Route::post('/users/delete', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('admin.users.delete');
    Route::get('/users/management', [UserController::class, 'management']);

});
Route::prefix('admin')->middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('admin.reports.excel');
});



// Customer Routes
Route::prefix('customer')->middleware(['auth', CheckRole::class . ':customer'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::post('/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/my-product', [ProductController::class, 'myProduct'])->name('products.my-product');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit'); // [GPT] Route edit produk
    Route::get('/products/show/{id}', [ProductController::class, 'show'])->name('products.show'); // [GPT] Route lihat produk

    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::post('/orders/{id}/status', [CustomerOrderController::class, 'updateStatus'])->name('customer.orders.updateStatus');
});

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// [GPT] Route untuk ajukan menjadi seller
Route::post('/profile/request-seller', [\App\Http\Controllers\ProfileController::class, 'requestSeller'])->name('profile.request_seller')->middleware('auth');


// [GPT] Route untuk kirim ulang verifikasi email
Route::post('/profile/send-verification', [\App\Http\Controllers\ProfileController::class, 'sendVerification'])->middleware('auth')->name('profile.send_verification');

// [GPT] Route untuk update password dari halaman profil
Route::put('/profile/update-password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->middleware('auth')->name('profile.update_password');
