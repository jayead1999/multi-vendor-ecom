<?php

use App\Http\Controllers\Frontend\UserDashboardController;
use Illuminate\Support\Facades\Route;




// User Dashboard Route
Route::middleware(['auth', 'verified'])->prefix('user', as: 'user.')->controller(UserDashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});

