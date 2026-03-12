<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/insights', function () {
    return view('insights');
})->name('insights');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/healing-form', function () {
    return view('healing-form');
});

Route::get('/healing-form-v2', function () {
    return view('healing-form-v2');
});

Route::get('/card-qr', function () {
    return view('card-qr');
});

Route::post('/healing-submit', [App\Http\Controllers\HealingFormController::class, 'submit']);

// Book Landing Page Routes
Route::get('/book/thisisnotlaziness', [App\Http\Controllers\BookLandingController::class, 'index'])->name('book.landing');
Route::post('/book/thisisnotlaziness/send', [App\Http\Controllers\NotificationController::class, 'submitLead'])->name('book.send');
Route::get('/book/thisisnotlaziness/thankyou', [App\Http\Controllers\BookLandingController::class, 'thankYou'])->name('book.thank-you');

// Legal Pages
Route::view('/privacy-policy', 'legal.privacy')->name('privacy');
Route::view('/terms-and-conditions', 'legal.terms')->name('terms');

Route::post('/contact-submit', [App\Http\Controllers\NotificationController::class, 'submitContact']);
Route::post('/healing-submit', [App\Http\Controllers\NotificationController::class, 'submitApplication']);
