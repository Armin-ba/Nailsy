<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NailArtist;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function indexByArtist($artistId)
    {
        $ratings = Rating::with('user')
            ->where('nail_artist_id', $artistId)
            ->latest()
            ->get();

        return response()->json($ratings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nail_artist_id' => ['required', 'exists:nail_artists,id'],
            'star' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $rating = Rating::create([
            'user_id' => $request->user()->id,
            'nail_artist_id' => $validated['nail_artist_id'],
            'star' => $validated['star'],
            'comment' => $validated['comment'] ?? null,
        ]);

        $avg = Rating::where('nail_artist_id', $validated['nail_artist_id'])->avg('star');

        NailArtist::where('id', $validated['nail_artist_id'])->update([
            'rating' => round($avg, 1),
        ]);

        return response()->json([
            'message' => 'Értékelés sikeresen létrehozva',
            'rating' => $rating->load('user'),
        ], 201);
    }
}
