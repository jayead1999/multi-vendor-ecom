<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\Dashboard\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Frontend\KycController;
use Illuminate\Support\Facades\Route;

//add prefix 'admin' to all admin auth routes
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('admin.register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('admin.register.store');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('admin.password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('admin.password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('admin.password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('admin.password.store');
});

Route::prefix('admin')->as('admin.')->middleware('auth:admin')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->name('store.password.confirm');

    Route::put('password', [PasswordController::class, 'update'])->name('password.update')->name('update.password');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// Route::get('/admin/dashboard', function () {
//     return view('admin/dashboard/index');
// })->middleware(['auth:admin', 'verified'])->name('admin.dashboard');

//------Dashboard Route------
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware(['auth:admin', 'verified'])->name('admin.dashboard');

Route::prefix('admin')->as('admin.')->middleware('auth:admin')->group(function () {


    // admin Profile 
    Route::get('profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::put('profile', [ProfileController::class, 'updateProfile'])
        ->name('profile.update');

    Route::put('password', [ProfileController::class, 'updatePassword'])
        ->name('update.password');

    // kyc request
    Route::get('kyc/request', [KycController::class, 'kycRequest'])
        ->name('kyc.request');

    Route::get('kyc/request/approve/{id}', [KycController::class, 'kycRequestApprove'])
        ->name('kyc.request.approve');

    Route::post('kyc/request/reject/{id}', [KycController::class, 'kycRequestReject'])
        ->name('kyc.request.reject');

    Route::get('kyc/request/show/{id}', [KycController::class, 'kycRequestShow'])
        ->name('kyc.request.show');

    Route::delete('kyc/request/delete/{id}', [KycController::class, 'kycRequestDelete'])
        ->name('kyc.request.delete');
});
