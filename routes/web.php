<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/books', 'books')->name('books');

// Free call booking
Route::get('/call', [BookingController::class, 'create'])->name('call');
Route::post('/call', [BookingController::class, 'store'])->middleware('throttle:6,1')->name('call.book');
Route::middleware('signed')->group(function () {
    Route::get('/call/booked/{booking}', [BookingController::class, 'show'])->name('call.booked');
    Route::get('/call/booked/{booking}/calendar', [BookingController::class, 'calendar'])->name('call.calendar');
    Route::post('/call/booked/{booking}/cancel', [BookingController::class, 'cancel'])->name('call.cancel');
});

// Legal pages
Route::view('/privacy-policy', 'legal.privacy')->name('privacy');
Route::view('/terms-and-conditions', 'legal.terms')->name('terms');
Route::view('/refund-policy', 'legal.refund')->name('refund');

// Admin: bookings and availability (create the login with `php artisan admin:create`)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [Admin\LoginController::class, 'create'])->name('login');
    Route::post('/admin/login', [Admin\LoginController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [Admin\LoginController::class, 'destroy'])->name('logout');
    Route::get('/', [Admin\BookingController::class, 'index'])->name('bookings');
    Route::post('/bookings/{booking}/cancel', [Admin\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/availability', [Admin\AvailabilityController::class, 'edit'])->name('availability');
    Route::put('/availability', [Admin\AvailabilityController::class, 'update'])->name('availability.update');
    Route::post('/blocked-dates', [Admin\AvailabilityController::class, 'blockDate'])->name('blocked-dates.store');
    Route::delete('/blocked-dates/{blockedDate}', [Admin\AvailabilityController::class, 'unblockDate'])->name('blocked-dates.destroy');
    Route::get('/app', [Admin\PhoneAppController::class, 'show'])->name('app');
    Route::get('/app/android', [Admin\PhoneAppController::class, 'downloadApk'])->name('app.apk');
    Route::post('/push-subscriptions', [Admin\PhoneAppController::class, 'subscribe'])->name('push.subscribe');
    Route::delete('/push-subscriptions', [Admin\PhoneAppController::class, 'unsubscribe'])->name('push.unsubscribe');
    Route::post('/push/test', [Admin\PhoneAppController::class, 'test'])->name('push.test');
    Route::get('/google/connect', [Admin\GoogleCalendarController::class, 'connect'])->name('google.connect');
    Route::get('/google/callback', [Admin\GoogleCalendarController::class, 'callback'])->name('google.callback');
    Route::post('/google/disconnect', [Admin\GoogleCalendarController::class, 'disconnect'])->name('google.disconnect');
});
