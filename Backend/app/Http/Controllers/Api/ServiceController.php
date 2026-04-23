<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(
            Service::with('nailArtist')->get()
        );
    }

    public function byArtist($artistId)
    {
        return response()->json(
            Service::where('nail_artist_id', $artistId)->get()
        );
    }
}
