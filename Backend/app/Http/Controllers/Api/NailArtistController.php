<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveArtistRequest;
use App\Models\NailArtist;

class NailArtistController extends Controller
{
    public function index()
    {
        $artists = NailArtist::with(['services', 'galleryImages', 'ratings'])
            ->where('approved', true)
            ->get();

        return response()->json($artists);
    }

    public function all()
    {
        $artists = NailArtist::with(['user', 'services', 'galleryImages', 'ratings'])
            ->get();

        return response()->json($artists);
    }

    public function show($id)
    {
        $artist = NailArtist::with(['user', 'services', 'galleryImages', 'ratings.user'])
            ->findOrFail($id);

        return response()->json($artist);
    }

    public function myProfile(\Illuminate\Http\Request $request)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)
            ->with(['services', 'galleryImages', 'ratings'])
            ->firstOrFail();

        return response()->json($artist);
    }

    public function approve(ApproveArtistRequest $request, $id)
    {
        $validated = $request->validated();

        $artist = NailArtist::findOrFail($id);

        $artist->update([
            'approved' => $validated['approved'],
        ]);

        return response()->json([
            'message' => 'Artist státusz frissítve',
            'artist' => $artist,
        ]);
    }
}
