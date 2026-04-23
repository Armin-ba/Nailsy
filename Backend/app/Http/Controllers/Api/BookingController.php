<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Models\AvailableSlot;
use App\Models\Booking;
use App\Models\NailArtist;
use App\Models\Service;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $bookings = Booking::with(['user', 'nailArtist', 'availableSlot', 'service'])
            ->where('user_id', $request->user()->id)
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->get();

        return response()->json($bookings);
    }

    public function artistBookings(\Illuminate\Http\Request $request)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $bookings = Booking::with(['user', 'availableSlot', 'service'])
            ->where('nail_artist_id', $artist->id)
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->get();

        return response()->json($bookings);
    }

    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        $slot = AvailableSlot::with('nailArtist')->findOrFail($validated['available_slot_id']);
        $service = Service::findOrFail($validated['service_id']);

        if ($slot->is_booked) {
            return response()->json([
                'message' => 'Ez az időpont már foglalt',
            ], 422);
        }

        if (!$slot->nailArtist->approved) {
            return response()->json([
                'message' => 'Csak jóváhagyott körmöshöz lehet foglalni',
            ], 422);
        }

        if ($service->nail_artist_id !== $slot->nail_artist_id) {
            return response()->json([
                'message' => 'A kiválasztott szolgáltatás nem ehhez a körmöshöz tartozik',
            ], 422);
        }

        $slotStart = Carbon::createFromFormat('H:i:s', $slot->start_time);
        $slotEnd = Carbon::createFromFormat('H:i:s', $slot->end_time);
        $slotMinutes = $slotStart->diffInMinutes($slotEnd);

        if ($slotMinutes < $service->duration_min) {
            return response()->json([
                'message' => 'A kiválasztott idősáv túl rövid ehhez a szolgáltatáshoz',
            ], 422);
        }

        $userHasBookingThatDay = Booking::where('user_id', $request->user()->id)
            ->whereDate('booking_date', $slot->slot_date)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($userHasBookingThatDay) {
            return response()->json([
                'message' => 'Erre a napra már van foglalásod',
            ], 422);
        }

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'nail_artist_id' => $slot->nail_artist_id,
            'service_id' => $service->id,
            'available_slot_id' => $slot->id,
            'booking_date' => $slot->slot_date,
            'booking_time' => $slot->start_time,
            'status' => 'pending',
        ]);

        $slot->update([
            'is_booked' => true,
        ]);

        return response()->json([
            'message' => 'Foglalás sikeresen létrehozva',
            'booking' => $booking->load(['user', 'nailArtist', 'availableSlot', 'service']),
        ], 201);
    }

    public function show(\Illuminate\Http\Request $request, $id)
    {
        $booking = Booking::with(['user', 'nailArtist', 'availableSlot', 'service'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($booking);
    }

    public function accept(\Illuminate\Http\Request $request, $id)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $booking = Booking::where('nail_artist_id', $artist->id)->findOrFail($id);

        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'Csak függőben lévő foglalás fogadható el',
            ], 422);
        }

        $booking->update([
            'status' => 'accepted',
        ]);

        return response()->json([
            'message' => 'Foglalás elfogadva',
            'booking' => $booking->load(['user', 'availableSlot', 'service']),
        ]);
    }

    public function reject(\Illuminate\Http\Request $request, $id)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $booking = Booking::where('nail_artist_id', $artist->id)->findOrFail($id);

        if ($booking->status === 'rejected') {
            return response()->json([
                'message' => 'A foglalás már el lett utasítva',
            ], 422);
        }

        $booking->update([
            'status' => 'rejected',
        ]);

        if ($booking->available_slot_id) {
            $booking->availableSlot()->update([
                'is_booked' => false,
            ]);
        }

        return response()->json([
            'message' => 'Foglalás elutasítva',
            'booking' => $booking->load(['user', 'availableSlot', 'service']),
        ]);
    }

    public function updateStatus(UpdateBookingStatusRequest $request, $id)
    {
        $validated = $request->validated();

        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => $validated['status'],
        ]);

        if (in_array($validated['status'], ['rejected', 'cancelled'], true) && $booking->available_slot_id) {
            $booking->availableSlot()->update([
                'is_booked' => false,
            ]);
        }

        return response()->json([
            'message' => 'Foglalás státusza frissítve',
            'booking' => $booking->load(['user', 'nailArtist', 'availableSlot', 'service']),
        ]);
    }

    public function destroy(\Illuminate\Http\Request $request, $id)
    {
        $booking = Booking::where('user_id', $request->user()->id)->findOrFail($id);

        if ($booking->available_slot_id) {
            $booking->availableSlot()->update([
                'is_booked' => false,
            ]);
        }

        $booking->delete();

        return response()->json([
            'message' => 'Foglalás törölve',
        ]);
    }
}
