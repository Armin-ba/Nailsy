<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\NailArtist;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $bookings = Booking::with(['user', 'nailArtist'])
            ->where('user_id', $user->id)
            ->orderBy('booking_date')
            ->get();

        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nail_artist_id' => ['required', 'exists:nail_artists,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $artist = NailArtist::findOrFail($validated['nail_artist_id']);

        if (!$artist->approved) {
            return response()->json([
                'message' => 'Csak jóváhagyott körmöshöz lehet foglalni',
            ], 422);
        }

        $existingBooking = Booking::where('user_id', $request->user()->id)
            ->whereDate('booking_date', $validated['booking_date'])
            ->exists();

        if ($existingBooking) {
            return response()->json([
                'message' => 'Erre a napra már van foglalásod',
            ], 422);
        }

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'nail_artist_id' => $validated['nail_artist_id'],
            'booking_date' => $validated['booking_date'],
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Foglalás sikeresen létrehozva',
            'booking' => $booking->load(['user', 'nailArtist']),
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $booking = Booking::with(['user', 'nailArtist'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($booking);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected,cancelled'],
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Foglalás státusza frissítve',
            'booking' => $booking,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $booking = Booking::where('user_id', $request->user()->id)->findOrFail($id);
        $booking->delete();

        return response()->json([
            'message' => 'Foglalás törölve',
        ]);
    }
}
