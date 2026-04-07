<?php

namespace App\Http\Controllers;

use App\Models\NailArtist;
use Illuminate\Http\Request;

class NailArtistController extends Controller
{
    public function index()
    {
        return NailArtist::with('services', 'reviews')->get();
    }

    public function store(Request $request)
    {
        return NailArtist::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'city' => $request->city,
            'description' => $request->description,
        ]);
    }

    public function show($id)
    {
        return NailArtist::with('services', 'reviews', 'galleryImages')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $artist = NailArtist::findOrFail($id);
        $artist->update($request->all());
        return $artist;
    }

    public function destroy($id)
    {
        NailArtist::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
