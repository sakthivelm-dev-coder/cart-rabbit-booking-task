<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('cors-fix')->withoutMiddleware(VerifyCsrfToken::class)->group(function () {
    Route::get('/availability', [AvailabilityController::class, 'index']);   // GET ?userId=&date=
    Route::post('/availability', [AvailabilityController::class, 'store']);   // Admin create window
    Route::post('/bookings', [BookingController::class, 'store']);
});
