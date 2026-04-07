<?php

namespace App\Http\Controllers;

use App\Models\NailArtist;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return Review::with('user')->get();
    }

    public function store(Request $request)
    {
        $review = Review::create([
            'user_id' => auth()->id(),
            'nail_artist_id' => $request->nail_artist_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);


        $avg = Review::where('nail_artist_id', $request->nail_artist_id)
            ->avg('rating');

        NailArtist::where('id', $request->nail_artist_id)
            ->update(['rating' => $avg]);

        return $review;
    }

    public function show($id)
    {
        return Review::findOrFail($id);
    }

    public function destroy($id)
    {
        Review::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
