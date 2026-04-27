<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAvailableSlotRequest;
use App\Models\AvailableSlot;
use App\Models\NailArtist;
use Illuminate\Http\Request;

class AvailableSlotController extends Controller
{
    public function indexByArtist($artistId)
    {
        $slots = AvailableSlot::where('nail_artist_id', $artistId)
            ->where('is_booked', false)
            ->orderBy('slot_date')
            ->orderBy('start_time')
            ->get();

        return response()->json($slots);
    }

    public function mySlots(Request $request)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $slots = AvailableSlot::where('nail_artist_id', $artist->id)
            ->orderBy('slot_date')
            ->orderBy('start_time')
            ->get();

        return response()->json($slots);
    }

    public function store(StoreAvailableSlotRequest $request)
    {
        $validated = $request->validated();

        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $overlap = AvailableSlot::where('nail_artist_id', $artist->id)
            ->whereDate('slot_date', $validated['slot_date'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                        ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->exists();

        if ($overlap) {
            return response()->json([
                'message' => 'Ez az időintervallum ütközik egy meglévő időponttal.',
            ], 422);
        }

        $slot = AvailableSlot::create([
            'nail_artist_id' => $artist->id,
            'slot_date' => $validated['slot_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_booked' => false,
        ]);

        return response()->json([
            'message' => 'Szabad időpont sikeresen létrehozva.',
            'slot' => $slot,
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $slot = AvailableSlot::where('nail_artist_id', $artist->id)
            ->findOrFail($id);

        if ($slot->is_booked) {
            return response()->json([
                'message' => 'Foglalt időpont nem törölhető.',
            ], 422);
        }

        $slot->delete();

        return response()->json([
            'message' => 'Szabad időpont törölve.',
        ]);
    }
}
