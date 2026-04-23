<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\GalleryImageController;
use App\Http\Controllers\Api\NailArtistController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/artists', [NailArtistController::class, 'index']);
Route::get('/artists/{id}', [NailArtistController::class, 'show']);
Route::get('/artists/{artistId}/services', [ServiceController::class, 'byArtist']);
Route::get('/artists/{artistId}/gallery', [GalleryImageController::class, 'byArtist']);
Route::get('/artists/{artistId}/ratings', [RatingController::class, 'indexByArtist']);

/*
|--------------------------------------------------------------------------
| Protected routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

    Route::post('/ratings', [RatingController::class, 'store']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/artists', [NailArtistController::class, 'all']);
        Route::patch('/admin/bookings/{id}/status', [BookingController::class, 'updateStatus']);
    });
});
