<?php

use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\VendorUser\VendorDashboardController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->as('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [VendorDashboardController::class, 'profile'])->name('profile');
});


Route::middleware(['auth', 'role:vendor'])->as('vendor.')->group(function () {
// Route::as('vendor.')->group(function () {

    // Kyc Routes
    Route::get('/kyc', [KycController::class, 'kycIndex'])->name('kyc.index');
    Route::post('/kyc', [KycController::class, 'kycStore'])->name('kyc.store');
});
