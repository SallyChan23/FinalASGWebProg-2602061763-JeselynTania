<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/payment', [AuthController::class, 'payment'])->name('payment');
Route::post('/payment', [AuthController::class, 'processPayment'])->name('payment.submit');

Route::get('/payment/confirmation', [AuthController::class, 'showPaymentConfirmation'])->name('payment.confirmation');
Route::post('/payment/confirmation', [AuthController::class, 'confirmPayment'])->name('payment.confirmation.submit');

Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');