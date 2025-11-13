<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;

use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
  return view('index');
});

Route::middleware('guest')->group(function () {
  Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [LoginController::class, 'login']);
  
  Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
  Route::post('/register', [RegisterController::class, 'register']);
});



Route::middleware('auth')->group(function () {
  Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

  Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
  });
  Route::prefix('dashboard')->middleware('role:customer')->group(function () {
    Route::get('/', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
  });
});
