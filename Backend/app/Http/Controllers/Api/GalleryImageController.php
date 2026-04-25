<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\NailArtist;
use Illuminate\Http\Request;

class GalleryImageController extends Controller
{
    public function byArtist($artistId)
    {
        $images = GalleryImage::where('nail_artist_id', $artistId)->get();

        return response()->json($images);
    }

    public function myGallery(Request $request)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $images = GalleryImage::where('nail_artist_id', $artist->id)
            ->latest()
            ->get();

        return response()->json($images);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $path = $request->file('image')->store('gallery', 'public');

        $image = GalleryImage::create([
            'nail_artist_id' => $artist->id,
            'image_url' => 'storage/' . $path,
        ]);

        return response()->json([
            'message' => 'Kép sikeresen feltöltve.',
            'image' => $image,
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $image = GalleryImage::where('nail_artist_id', $artist->id)
            ->findOrFail($id);

        $image->delete();

        return response()->json([
            'message' => 'Kép törölve.',
        ]);
    }
}
