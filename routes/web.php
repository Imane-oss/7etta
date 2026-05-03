<?php
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ContactController;

// General Pages
Route::get('/', [StorefrontController::class, 'index']);
Route::get('/caps', [StorefrontController::class, 'caps']);
Route::get('/t-shirts', [StorefrontController::class, 'tshirts']);
Route::get('/hoodies', [StorefrontController::class, 'hoodies']);
Route::get('/pants', [StorefrontController::class, 'pants']);
Route::get('/shoes', [StorefrontController::class, 'shoes']);

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

// Contact Routes
Route::get('/contact', function () {
    return view('contact');
});
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Auth Routes
Route::get('/sign-up', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/sign-up', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification Routes
Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/products', function () {
        return view('admin.products.index');
    })->name('admin.products');

    Route::get('/products/create', function () {
        return view('admin.products.create');
    })->name('admin.products.create');
});