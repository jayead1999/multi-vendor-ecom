<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\Frontend\StoreController;
use App\Http\Controllers\VendorUser\VendorDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'user_role:vendor'])->prefix('vendor')->as('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [VendorDashboardController::class, 'profile'])->name('profile');
});

Route::middleware(['auth', 'user_role:vendor'])->as('vendor.')->group(function () {
    // Route::as('vendor.')->group(function () {

    // Kyc Routes
    Route::get('/kyc', [FrontendController::class, 'kycIndex'])->name('kyc.index');
    Route::post('/kyc', [FrontendController::class, 'kycStore'])->name('kyc.store');

    // Store Routes
    Route::get('/store', [StoreController::class, 'storeIndex'])->name('store.index');
    Route::post('/store', [StoreController::class, 'storeStore'])->name('store.store');
});
