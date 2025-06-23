<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create']);

    Route::post('register',[RegisteredUserController::class, 'store'])
    ->name('register'); 

    Route::get('login', [AuthenticatedSessionController::class, 'create']);

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');

    Route::post('/get-otp',[AuthenticatedSessionController::class, 'get_otp']);
    
    Route::post('/verify-otp',[AuthenticatedSessionController::class, 'verify_otp']);

    // *********************************************** GOOGLE ********************************************

    Route::get('/auth/google',[GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/callback/google',[GoogleController::class, 'handleGoogleCallback']);

});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
