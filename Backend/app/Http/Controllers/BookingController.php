<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;

class BookingController extends Controller
{
    public function index()
    {
        return Booking::with('service', 'nailArtist')->get();
    }

    public function store(StoreBookingRequest $request)
    {
        // ÜTKÖZÉS ELLENŐRZÉS
        $exists = Booking::where('nail_artist_id', $request->nail_artist_id)
            ->where('booking_datetime', $request->booking_datetime)
            ->exists();

        if ($exists) {
            return response()->json([
                'error' => 'Ez az időpont már foglalt'
            ], 400);
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'nail_artist_id' => $request->nail_artist_id,
            'service_id' => $request->service_id,
            'booking_datetime' => $request->booking_datetime,
            'status' => 'pending'
        ]);

        return response()->json($booking);
    }

    public function show($id)
    {
        return Booking::findOrFail($id);
    }

    public function destroy($id)
    {
        Booking::destroy($id);

        return response()->json([
            'message' => 'Törölve'
        ]);
    }
}
