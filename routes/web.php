<?php

use App\Models\Product;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

$databaseAvailable = function (): bool {
    if (config('database.default') !== 'mysql') {
        return true;
    }

    $host = (string) config('database.connections.mysql.host', '127.0.0.1');
    $port = (int) config('database.connections.mysql.port', 3306);

    $connection = @fsockopen($host, $port, $errorCode, $errorMessage, 0.25);

    if (! $connection) {
        return false;
    }

    fclose($connection);

    return true;
};

// General Pages
Route::get('/', function () use ($databaseAvailable) {
    if ($databaseAvailable()) {
        $featuredProducts = Product::query()->latest('created_at')->take(16)->get();
        $categories = Category::with(['products' => fn($q) => $q->latest('created_at')->take(4)])->get();
    } else {
        $featuredProducts = collect();
        $categories = collect();
    }

    return view('index', [
        'categories' => $categories,
        'featuredProducts' => $featuredProducts,
        'heroProduct' => $featuredProducts->first(),
    ]);
})->name('home');

// Product Detail Page
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

// Cart Routes
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

// Helper for category routes
$categoryView = function (string $categoryName) use ($databaseAvailable) {
    if (! $databaseAvailable()) {
        abort(503, 'Database service is unavailable.');
    }

    $category = Category::where('name', $categoryName)->first();
    $products = $category 
        ? $category->products()->latest('created_at')->paginate(12)
        : collect();

    $viewName = Str::of($categoryName)->lower()->replace(' ', '-')->toString();

    if (view()->exists($viewName)) {
        return view($viewName, [
            'category' => $category,
            'categoryName' => $categoryName,
            'products' => $products,
        ]);
    }

    return view('shop.category', [
        'category' => $category,
        'categoryName' => $categoryName,
        'products' => $products,
    ]);
};

Route::get('/caps', fn() => $categoryView('Caps'));
Route::get('/t-shirts', fn() => $categoryView('T-shirts'));
Route::get('/hoodies', fn() => $categoryView('Hoodies'));
Route::get('/pants', fn() => $categoryView('Pants'));
Route::get('/shoes', fn() => $categoryView('Shoes'));


Route::get('/layout', function () {
    return view('layout');
});
Route::get('/about-us', function () {
    return view('about-us');
})->middleware(['auth', 'verified']);
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

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.destroy');

    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.destroy');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/users/{id}/admin', [AdminController::class, 'makeAdmin'])->name('admin.users.admin');
    Route::put('/users/{id}/ban', [AdminController::class, 'toggleBan'])->name('admin.users.ban');
    
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
});
