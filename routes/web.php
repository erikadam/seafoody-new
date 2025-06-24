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
use App\Http\Controllers\Admin\AdminOrderController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\TrackOrderController;
use App\Http\Controllers\OrderItemController;

// Home (guest)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
})->middleware('verified');
Auth::routes(['verify' => true]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Guest Product Routes
Route::get('/produk', [GuestProductController::class, 'filtered'])->name('guest.products.index');
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
Route::middleware('auth')
     ->post('/checkout/process', [GuestOrderController::class, 'submitOrder'])
     ->name('guest.checkout.process');
Route::middleware('auth')->get('/checkout', [GuestOrderController::class, 'showCheckoutForm'])->name('guest.checkout.form');
Route::get('/order-status/{token}', [GuestOrderController::class, 'trackOrder'])->name('guest.track.order');
Route::post('/order/confirm/{id}', [GuestOrderController::class, 'confirmReceived'])->name('guest.order.confirm');
Route::middleware(['auth'])->group(function () {
    Route::post('/order/{id}/confirm', [GuestOrderController::class, 'confirmReceipt'])->name('order.confirm');
});
Route::post('/cart/update', [CartController::class, 'update'])->name('guest.cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('guest.cart.remove');
Route::get('/track-order/result', [TrackOrderController::class, 'searchByToken'])->name('guest.track.result');
Route::get('/nota-pdf/{token}', [TrackOrderController::class, 'downloadPdf'])->name('guest.download.pdf');
Route::get('/track-order', [TrackOrderController::class, 'index'])->middleware('auth')->name('guest.track.order');
Route::post('/order-item/{id}/cancel', [OrderItemController::class, 'cancelItem'])
    ->middleware('auth')
    ->name('order.item.cancel');
Route::get('/refund/{item}/form', [RefundController::class, 'showRefundForm'])->name('refund.form');
Route::post('/refund/{item}/submit', [RefundController::class, 'requestRefund'])->name('refund.submit');
Route::post('/order-item/{id}/receive', [TrackOrderController::class, 'receiveOrderItem'])
    ->name('buyer.order.receive');
Route::get('/order-item/{id}/print', [TrackOrderController::class, 'printReceipt'])->name('buyer.order.print');

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
    Route::get('/admin/refunds', [RefundController::class, 'listRefunds'])->name('admin.refunds');
    Route::post('/admin/refunds/{id}/approve', [RefundController::class, 'approveRefundBySeller'])->name('admin.refund.approve');
    Route::get('/admin/refunds/{id}/upload', [RefundController::class, 'showUploadProofForm'])->name('admin.refund.upload.form');
    Route::post('/admin/refunds/{id}/process', [RefundController::class, 'processRefundByAdmin'])->name('admin.refund.process');
    Route::get('/admin/refunds', [RefundController::class, 'listRefunds'])->name('admin.refunds');
    Route::post('/admin/refund/{item}/upload', [AdminTransferController::class, 'uploadProof'])->name('admin.refund.upload');
    // Admin: mulai antar barang (ubah status jadi delivering)
    Route::post('/admin/order-item/{id}/start-delivery', [\App\Http\Controllers\Admin\AdminOrderController::class, 'startDelivery'])->name('admin.order.startDelivery');
    // Admin: selesaikan pengantaran + upload bukti
    Route::post('/admin/order-item/{id}/complete-delivery', [\App\Http\Controllers\Admin\AdminOrderController::class, 'completeDelivery'])->name('admin.order.completeDelivery');
    // Untuk mulai antar
    Route::post('/admin/order-item/{id}/start-delivery', [AdminOrderController::class, 'startDelivery'])->name('admin.order.startDelivery');
    // Untuk upload bukti penyerahan ke pembeli
    Route::post('/admin/order-item/{id}/complete-delivery', [AdminOrderController::class, 'completeDelivery'])->name('admin.order.completeDelivery');




});
Route::prefix('admin')->middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('admin.reports.excel');
});


// Customer Routes
Route::prefix('customer')->middleware(['auth', CheckRole::class . ':customer'])->group(function () {
    Route::post('/order-items/{id}/refund-request', [RefundController::class, 'requestRefund'])->name('refund.request');
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::post('/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.edit');
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.update');
    Route::post('/order-items/{id}/refund-request', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/my-product', [ProductController::class, 'myProduct'])->name('products.my-product');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}', [GuestProductController::class, 'shows'])->name('guest.products.show');
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::post('/orders/{id}/status', [CustomerOrderController::class, 'updateStatus'])->name('customer.orders.updateStatus');
    Route::post('/customer/refund/{id}/approve', [OrderItemController::class, 'approveRefundByCustomer'])->name('customer.refund.approve');
    Route::post('/customer/refund/{id}/reject', [OrderItemController::class, 'rejectRefundByCustomer'])->name('customer.refund.reject');
    Route::post('/customer/refund/approve/{id}', [CustomerOrderController::class, 'approveRefund'])->name('customer.refund.approve');
    // Approve refund oleh penjual
Route::post('/refunds/{id}/approve', [\App\Http\Controllers\RefundController::class, 'approveRefundBySeller'])->name('refund.approve');

Route::post('/customer/refund/approve-request/{id}', [CustomerOrderController::class, 'approveRefundRequest'])->name('customer.refund.approve-request');
Route::post('/customer/refund/confirm/{id}', [CustomerOrderController::class, 'confirmRefundReceived'])->name('customer.refund.confirm');
// Route untuk aksi seller (penjual)
Route::post('/customer/order-items/{id}/prepare', [App\Http\Controllers\Customer\CustomerOrderController::class, 'prepareOrder'])->name('customer.order.prepare');
Route::post('/customer/order-items/{id}/handover', [App\Http\Controllers\Customer\CustomerOrderController::class, 'handoverToAdmin'])->name('customer.order.handover');
Route::post('customer/order-item/{id}/processing', [CustomerOrderController::class, 'processing'])->name('customer.order.processing');
Route::post('order-item/{id}/handover-buyer-cod', [CustomerOrderController::class, 'handoverBuyerCOD'])
    ->name('customer.order.handoverBuyerCOD');

});


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/profile/request-seller', [ProfileController::class, 'requestSeller'])->name('profile.request_seller')->middleware('auth');
Route::post('/profile/send-verification', [ProfileController::class, 'sendVerification'])->middleware('auth')->name('profile.send_verification');
Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->middleware('auth')->name('profile.update_password');
Route::post('/seller/order-items/{id}/approve-refund', [RefundController::class, 'approveRefundBySeller'])
    ->middleware('auth', 'checkrole:customer')
    ->name('refund.approve.seller');
Route::post('/admin/order-items/{id}/process-refund', [RefundController::class, 'processRefundByAdmin'])
    ->middleware('auth', 'checkrole:admin')
    ->name('refund.process.admin');
Route::post('/order-items/{id}/received', [\App\Http\Controllers\OrderItemController::class, 'markAsReceived'])->name('order.received');


