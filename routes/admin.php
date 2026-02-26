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
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Dashboard\AdminDashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Frontend\KycController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// add prefix 'admin' to all admin auth routes
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

// ------Dashboard Route------
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

    Route::get('kyc/pending-request', [KycController::class, 'kycPendingRequest'])
        ->name('kyc.pending.request');

    Route::get('kyc/request/approve/{id}', [KycController::class, 'kycRequestApprove'])
        ->name('kyc.request.approve');

    Route::post('kyc/request/reject/{id}', [KycController::class, 'kycRequestReject'])
        ->name('kyc.request.reject');

    Route::get('kyc/request/show/{id}', [KycController::class, 'kycRequestShow'])
        ->name('kyc.request.show');

    Route::delete('kyc/request/delete/{id}', [KycController::class, 'kycRequestDelete'])
        ->name('kyc.request.delete');

    // Role
    Route::get('role', [RoleController::class, 'role'])->name('role');
    // create a role
    Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
    // store a role
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store');
    // edit a role
    Route::get('role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    // update a role
    Route::put('role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    // delete a role
    Route::delete('role/delete/{id}', [RoleController::class, 'destroy'])->name('role.delete');

    // role User
    Route::resource('role-user', RoleUserController::class)->names('role-user');

    // permission
    Route::resource('permission', PermissionController::class)->names('permission');



    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::get('settings/general', [SettingController::class, 'generalSetting'])->name('settings.general');
    Route::put('settings/general-update', [SettingController::class, 'updateGeneralSettings'])->name('settings.general.update');
    Route::put('settings/update', [SettingController::class, 'updateSettings'])->name('settings.update');
    Route::put('settings/update-password', [SettingController::class, 'updatePassword'])->name('settings.update-password');


    // category
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/update/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/delete/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    // Route::get('category/nested', [CategoryController::class, 'getNestedCategories'])->name('category.nested');

    // sub-category
    Route::get('sub-category', [App\Http\Controllers\Admin\SubCategoryController::class, 'index'])->name('sub-category.index');
    Route::get('sub-category/create', [App\Http\Controllers\Admin\SubCategoryController::class, 'create'])->name('sub-category.create');
    Route::post('sub-category/store', [App\Http\Controllers\Admin\SubCategoryController::class, 'store'])->name('sub-category.store');
    Route::get('sub-category/edit/{subCategory}', [App\Http\Controllers\Admin\SubCategoryController::class, 'edit'])->name('sub-category.edit');
    Route::put('sub-category/update/{subCategory}', [App\Http\Controllers\Admin\SubCategoryController::class, 'update'])->name('sub-category.update');
    Route::delete('sub-category/delete/{subCategory}', [App\Http\Controllers\Admin\SubCategoryController::class, 'destroy'])->name('sub-category.destroy');

    // tags
    Route::get('tags', [App\Http\Controllers\Admin\TagController::class, 'index'])->name('tags.index');
    Route::get('tags/create', [App\Http\Controllers\Admin\TagController::class, 'create'])->name('tags.create');
    Route::post('tags/store', [App\Http\Controllers\Admin\TagController::class, 'store'])->name('tags.store');
    Route::get('tags/edit/{tag}', [App\Http\Controllers\Admin\TagController::class, 'edit'])->name('tags.edit');
    Route::put('tags/update/{tag}', [App\Http\Controllers\Admin\TagController::class, 'update'])->name('tags.update');
    Route::delete('tags/delete/{tag}', [App\Http\Controllers\Admin\TagController::class, 'destroy'])->name('tags.destroy');

    // Brand 
    Route::get('brand', [App\Http\Controllers\Admin\BrandController::class, 'index'])->name('brand.index');
    Route::get('brand/create', [App\Http\Controllers\Admin\BrandController::class, 'create'])->name('brand.create');
    Route::post('brand/store', [App\Http\Controllers\Admin\BrandController::class, 'store'])->name('brand.store');
    Route::get('brand/edit/{brand}', [App\Http\Controllers\Admin\BrandController::class, 'edit'])->name('brand.edit');
    Route::put('brand/update/{brand}', [App\Http\Controllers\Admin\BrandController::class, 'update'])->name('brand.update');
    Route::delete('brand/delete/{brand}', [App\Http\Controllers\Admin\BrandController::class, 'destroy'])->name('brand.destroy');

    // Product
    Route::get('product', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('product.index');
    Route::get('product/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('product.create');
    Route::post('product/store', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('product.store');
    Route::get('product/edit/{product}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('product.edit');
    Route::put('product/update/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('product.update');
    Route::delete('product/delete/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('product/get-subcategories/{category_id}', [App\Http\Controllers\Admin\ProductController::class, 'getSubcategories'])->name('product.get-subcategories');
});
