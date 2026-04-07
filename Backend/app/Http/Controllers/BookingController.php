<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return Booking::with('service', 'nailArtist')->get();
    }

    public function store(Request $request)
    {
        // 🔴 ÜTKÖZÉS ELLENŐRZÉS (7. pont!)
        $exists = Booking::where('nail_artist_id', $request->nail_artist_id)
            ->where('booking_datetime', $request->booking_datetime)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'Időpont foglalt'], 400);
        }

        return Booking::create([
            'user_id' => auth()->id(),
            'nail_artist_id' => $request->nail_artist_id,
            'service_id' => $request->service_id,
            'booking_datetime' => $request->booking_datetime,
            'status' => 'pending'
        ]);
    }

    public function show($id)
    {
        return Booking::with('service', 'nailArtist')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return $booking;
    }

    public function destroy($id)
    {
        Booking::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
