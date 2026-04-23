<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NailArtist;
use Illuminate\Http\Request;

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
        $artists = NailArtist::with(['user', 'services', 'galleryImages', 'ratings'])->get();

        return response()->json($artists);
    }

    public function show($id)
    {
        $artist = NailArtist::with(['user', 'services', 'galleryImages', 'ratings.user'])
            ->findOrFail($id);

        return response()->json($artist);
    }
}
