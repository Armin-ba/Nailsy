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
    public function search(\Illuminate\Http\Request $request)
    {
        $query = NailArtist::with(['services', 'galleryImages', 'ratings'])
            ->where('approved', true);

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('service')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->service . '%');
            });
        }

        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        return response()->json(
            $query->orderByDesc('rating')->get()
        );
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
