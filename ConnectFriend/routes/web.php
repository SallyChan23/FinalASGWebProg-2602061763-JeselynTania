<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Log;
use App\Http\Middleware\SetLocale;

Route::middleware(SetLocale::class)->group(function () {

    Route::get('/set-locale/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'id'])) {
            // Simpan locale ke session
            session(['locale' => $locale]);
            // Set locale aplikasi langsung
            app()->setLocale($locale);
        }
        // Redirect ke halaman sebelumnya
        return redirect()->back();
    })->name('set-locale');

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
    Route::post('/profile/remove-friend/{friendId}', [ProfileController::class, 'removeFriend'])->name('profile.removeFriend');

    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.show');
    Route::post('/wishlist/accept/{userId}', [WishlistController::class, 'acceptRequest'])->name('wishlist.accept');

    Route::get('/mutual-friends', [WishlistController::class, 'checkMutual'])->name('wishlist.mutual');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/accept/{id}', [WishlistController::class, 'acceptRequest'])->name('notifications.accept');
    Route::get('/notifications/count', [NotificationController::class, 'getNotificationsCount'])->name('notifications.count');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{receiverId}', [ChatController::class, 'showChatDetail'])->name('chat.detail');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    Route::get('/search', [HomeController::class, 'searchByFieldOfWork'])->name('search');

    Route::get('/filter/gender', [HomeController::class, 'filterByGender'])->name('filter.gender');
   
});