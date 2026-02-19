<?php

use App\Http\Controllers\Frontend\UserDashboardController;
use Illuminate\Support\Facades\Route;

// User Dashboard Route
Route::middleware(['auth', 'verified'])->prefix('user')->controller(UserDashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('user.dashboard');
    Route::get('/orders', 'orders')->name('user.orders');
    Route::get('/track-orders', 'trackOrders')->name('user.track.orders');
    Route::get('/address', 'address')->name('user.address');
    Route::get('/account', 'account')->name('user.account');
    Route::get('/wishlist', 'wishlist')->name('user.wishlist');
});

Route::middleware(['auth', 'verified'])->prefix('user')->controller(UserDashboardController::class)->group(function () {
    Route::post('/edit-account', 'editAccount')->name('user.account.update');
    Route::post('/update-password', 'updatePassword')->name('user.password.update');
    Route::post('/orders', 'orders')->name('user.orders');
    Route::post('/track-orders', 'trackOrders')->name('user.track.orders');
    Route::post('/address', 'address')->name('user.address');
    Route::post('/account', 'account')->name('user.account');
    Route::post('/wishlist', 'wishlist')->name('user.wishlist');
});
