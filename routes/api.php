<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

// Authenticated user info (requires Sanctum token)
Route::middleware('auth:sanctum')->get('/user', [ProfileController::class, 'show']);
Route::middleware('auth:sanctum')->put('/user', [ProfileController::class, 'update']);

// Guest routes
Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Email verification
Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth:sanctum', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->name('verification.send');

// Logout (revoke token)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('logout');


Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::get('/categories-latest', [CategoryController::class, 'latest']);
Route::get('/categories-featured', [CategoryController::class, 'latest']); //TODO - implement featured flag


Route::apiResource('merchants', MerchantController::class)->only(['index', 'show']);
Route::get('/merchants-latest', [MerchantController::class, 'latest']);
Route::get('/merchants-featured', [MerchantController::class, 'latest']); //TODO - implement featured flag

Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::get('/products-latest', [ProductController::class, 'latest']);
Route::get('/products-featured', [ProductController::class, 'latest']); //TODO - implement featured flag


//TODO
/**
 * Get homepage top categories
 * Get homepage featured categories
 * Get homepage merchants
 * Get homepage products
 *
 * Get all categories
 * Get all merchants
 * Get all products
 *
 * Get merchants by category
 * Get products by category
 * Get products by merchant
 *
 * Get product details
 * Get merchant details
 */
