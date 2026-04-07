<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CustomerManagementController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DesainController;
use App\Http\Controllers\Desainer\DesainerDashboardController;
use App\Http\Controllers\Desainer\DesainerOrderController;

use App\Http\Controllers\Admin\PaymentManagementController;

// Auth
Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/', [AuthController::class, 'login']);

// Admin
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('customers/search', [CustomerManagementController::class, 'searchApi'])->name('customers.search');
    Route::resource('users',     UserManagementController::class);
    Route::resource('customers', CustomerManagementController::class);
    Route::resource('orders',    OrderManagementController::class);
    Route::post('orders/{id}/deadline', [OrderManagementController::class, 'updateDeadline'])->name('orders.updateDeadline');
    Route::post('orders/{id}/assign-designer', [OrderManagementController::class, 'assignDesigner'])->name('orders.assignDesigner');

    // Desain (draft management — admin only creates/approves)
    Route::get('desain/create/{id}',    [DesainController::class, 'create'])->name('desain.create');
    Route::post('desain/store/{id}',    [DesainController::class, 'store'])->name('desain.store');
    Route::get('desain/{id}',           [DesainController::class, 'show'])->name('desain.show');
    Route::post('desain/{id}/approve',  [DesainController::class, 'approve'])->name('desain.approve');

    // Pembayaran
    Route::post('orders/{id}/kesepakatan', [PaymentManagementController::class, 'storeKesepakatan'])->name('orders.storeKesepakatan');
    Route::get('pembayaran/create/{id}',  [PaymentManagementController::class, 'create'])->name('pembayaran.create');
    Route::post('pembayaran/store/{id}',  [PaymentManagementController::class, 'store'])->name('pembayaran.store');
});

// Desainer
Route::middleware(['auth', 'role:desainer'])->prefix('desainer')->name('desainer.')->group(function () {
    Route::get('dashboard',                             [DesainerDashboardController::class, 'index'])->name('dashboard');
    Route::get('orders/{id}',                           [DesainerOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/upload',                   [DesainerOrderController::class, 'upload'])->name('orders.upload');
    Route::get('orders/{orderId}/desain/{desainId}',    [DesainerOrderController::class, 'showDraft'])->name('desain.show');
});

use App\Http\Controllers\Akuntan\DashboardController as AkuntanDashboardController;
use App\Http\Controllers\Akuntan\PaymentValidationController as AkuntanPaymentController;

// Akuntan
Route::middleware(['auth', 'role:akuntan'])->prefix('akuntan')->name('akuntan.')->group(function () {
    Route::get('dashboard', [AkuntanDashboardController::class, 'index'])->name('dashboard');
    Route::get('pembayaran/{id}', [AkuntanPaymentController::class, 'show'])->name('pembayaran.show');
    Route::post('pembayaran/{id}/approve', [AkuntanPaymentController::class, 'approve'])->name('pembayaran.approve');
    Route::post('pembayaran/{id}/reject', [AkuntanPaymentController::class, 'reject'])->name('pembayaran.reject');
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
