<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/healing-form', function () {
    return view('healing-form');
});

Route::get('/healing-form-v2', function () {
    return view('healing-form-v2');
});

Route::post('/healing-submit', [App\Http\Controllers\HealingFormController::class, 'submit']);

// Book Landing Page Routes
Route::get('/book/thisisnotlaziness', [App\Http\Controllers\BookLandingController::class, 'index'])->name('book.landing');
Route::post('/book/thisisnotlaziness/send', [App\Http\Controllers\BookLandingController::class, 'send'])->name('book.send');
Route::get('/book/thank-you', [App\Http\Controllers\BookLandingController::class, 'thankYou'])->name('book.thank-you');

// Legal Pages
Route::view('/privacy-policy', 'legal.privacy')->name('privacy');
Route::view('/terms-and-conditions', 'legal.terms')->name('terms');
