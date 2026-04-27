<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NailArtist;
use App\Models\Rating;
use App\Models\Report;
use App\Models\User;

class AdminController extends Controller
{
    public function users()
    {
        return response()->json(
            User::orderBy('role')
                ->orderBy('name')
                ->get()
        );
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Admin felhasználó nem törölhető.',
            ], 422);
        }

        $user->delete();

        return response()->json([
            'message' => 'Felhasználó törölve.',
        ]);
    }

    public function userRatings($id)
    {
        $user = User::findOrFail($id);

        $ratings = Rating::with(['nailArtist'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'user' => $user,
            'ratings' => $ratings,
        ]);
    }

    public function deleteRating($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return response()->json([
            'message' => 'Hozzászólás törölve.',
        ]);
    }

    public function artists()
    {
        return response()->json(
            NailArtist::with(['user', 'services', 'galleryImages'])
                ->orderBy('approved')
                ->orderBy('name')
                ->get()
        );
    }

    public function approveArtist($id)
    {
        $artist = NailArtist::findOrFail($id);

        $artist->update([
            'approved' => true,
        ]);

        return response()->json([
            'message' => 'Körmös jóváhagyva.',
            'artist' => $artist->load('user'),
        ]);
    }

    public function deleteArtist($id)
    {
        $artist = NailArtist::with('user')->findOrFail($id);
        $user = $artist->user;

        $artist->delete();

        if ($user && $user->role === 'artist') {
            $user->delete();
        }

        return response()->json([
            'message' => 'Körmös és a hozzá tartozó felhasználó törölve.',
        ]);
    }

    public function reports()
    {
        return response()->json(
            Report::with(['rating.user', 'rating.nailArtist', 'reporter'])
                ->where('resolved', false)
                ->latest()
                ->get()
        );
    }

    public function dismissReport($id)
    {
        $report = Report::findOrFail($id);

        $report->update([
            'resolved' => true,
        ]);

        return response()->json([
            'message' => 'Jelentés elutasítva.',
        ]);
    }
}
