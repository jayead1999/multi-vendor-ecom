<?php


use App\Http\Controllers\VendorUser\VendorDashboardController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->as('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [VendorDashboardController::class, 'profile'])->name('profile');
});
