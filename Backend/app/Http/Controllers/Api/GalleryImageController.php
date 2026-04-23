<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;

class GalleryImageController extends Controller
{
    public function byArtist($artistId)
    {
        $images = GalleryImage::where('nail_artist_id', $artistId)->get();

        return response()->json($images);
    }
}
