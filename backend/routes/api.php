<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;

Route::get('/availability', [AvailabilityController::class, 'index']);   // GET ?userId=&date=
Route::post('/availability', [AvailabilityController::class, 'store']);   // Admin create window
Route::post('/bookings', [BookingController::class, 'store']);            // Create booking
