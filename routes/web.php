<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/layout', function () {
    return view('layout');
});
Route::get('/about-us', function () {
    return view('about-us');
});
Route::get('/FAQ', function () {
    return view('FAQ');
});
Route::get('/retour', function () {
    return view('retour');
});
Route::get('/politique', function () {
    return view('politique');
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/sign-up', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/sign-up', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Ensure this view exists
    })->name('admin.dashboard');

    Route::get('/products', function () {
        return view('admin.products.index'); // Ensure this view exists
    })->name('admin.products');
    
    Route::get('/products/create', function () {
        return view('admin.products.create'); // Ensure this view exists
    })->name('admin.products.create');
});