<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AvailableSlotController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\GalleryImageController;
use App\Http\Controllers\Api\NailArtistController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ServiceController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/artists/search', [NailArtistController::class, 'search']);
Route::get('/artists', [NailArtistController::class, 'index']);
Route::get('/artists/{id}', [NailArtistController::class, 'show']);
Route::get('/artists/{artistId}/services', [ServiceController::class, 'byArtist']);
Route::get('/artists/{artistId}/gallery', [GalleryImageController::class, 'byArtist']);
Route::get('/artists/{artistId}/ratings', [RatingController::class, 'indexByArtist']);
Route::get('/artists/{artistId}/slots', [AvailableSlotController::class, 'indexByArtist']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

    Route::post('/ratings', [RatingController::class, 'store']);

    Route::middleware('role:artist')->group(function () {
        Route::get('/artist/profile', [NailArtistController::class, 'myProfile']);

        Route::get('/artist/slots', [AvailableSlotController::class, 'mySlots']);
        Route::post('/artist/slots', [AvailableSlotController::class, 'store']);
        Route::delete('/artist/slots/{id}', [AvailableSlotController::class, 'destroy']);

        Route::get('/artist/services', [ServiceController::class, 'myServices']);
        Route::post('/artist/services', [ServiceController::class, 'store']);
        Route::put('/artist/services/{id}', [ServiceController::class, 'update']);
        Route::delete('/artist/services/{id}', [ServiceController::class, 'destroy']);

        Route::get('/artist/bookings', [BookingController::class, 'artistBookings']);
        Route::patch('/artist/bookings/{id}/accept', [BookingController::class, 'accept']);
        Route::patch('/artist/bookings/{id}/reject', [BookingController::class, 'reject']);

        Route::get('/artist/gallery', [GalleryImageController::class, 'myGallery']);
        Route::post('/artist/gallery', [GalleryImageController::class, 'store']);
        Route::delete('/artist/gallery/{id}', [GalleryImageController::class, 'destroy']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);

        Route::get('/admin/users/{id}/ratings', [AdminController::class, 'userRatings']);
        Route::delete('/admin/ratings/{id}', [AdminController::class, 'deleteRating']);

        Route::get('/admin/artists', [AdminController::class, 'artists']);
        Route::patch('/admin/artists/{id}/approve', [AdminController::class, 'approveArtist']);
        Route::delete('/admin/artists/{id}', [AdminController::class, 'deleteArtist']);

        Route::get('/admin/reports', [AdminController::class, 'reports']);
        Route::patch('/admin/reports/{id}/dismiss', [AdminController::class, 'dismissReport']);
    });
});
