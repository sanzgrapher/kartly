<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SearchController as AdminSearchController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Api\CouponController as ApiCouponController;




Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::view('/about', 'about')->name('about');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::patch('/cart-items/{cartItem}', [CartItemController::class, 'update'])->name('cart-items.update');
Route::delete('/cart-items/{cartItem}', [CartItemController::class, 'destroy'])->name('cart-items.destroy');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:6,1')->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('throttle:6,1')->name('password.update');
});


Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/payment/esewa/success', [PaymentController::class, 'esewaSuccess'])->name('payment.esewa.success');
    Route::get('/payment/esewa/failure', [PaymentController::class, 'esewaFailure'])->name('payment.esewa.failure');
});



Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')->name('verification.send');

    // Coupon validation API
    Route::get('/api/coupon/validate', [ApiCouponController::class, 'validate'])->name('api.coupon.validate');

    Route::prefix('dashboard')->middleware(['verified', 'role:customer'])->group(function () {
        Route::get('/', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

        Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
        Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
        Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('/orders/{id}/retry-payment', [OrderController::class, 'retryPayment'])->name('orders.retry-payment');
    });






    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/search', [AdminSearchController::class, 'index'])->name('search.index');
        Route::resource('users', AdminUserController::class);

        Route::resource('products', AdminProductController::class);
        Route::patch('/products/{id}/stock', [AdminProductController::class, 'updateStock'])->name('products.updateStock');


        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::patch('/orders/{id}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');

        Route::resource('categories', AdminCategoryController::class);
        Route::patch('/coupons/{id}/toggle-active', [AdminCouponController::class, 'toggleActive'])->name('coupons.toggleActive');
        Route::resource('coupons', AdminCouponController::class);
    });
});

Route::get('/status', [StatusController::class, 'index'])->name('status');
