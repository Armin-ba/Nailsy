<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NailArtist;
use App\Models\Rating;
use App\Models\Report;

class AdminController extends Controller
{
    public function users()
    {
        return User::all();
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'message' => 'User törölve'
        ]);
    }

    public function artists()
    {
        return NailArtist::with('user')->get();
    }

    public function approveArtist($id)
    {
        $artist = NailArtist::findOrFail($id);

        $artist->approved = true;
        $artist->save();

        return response()->json([
            'message' => 'Artist jóváhagyva'
        ]);
    }

    public function deleteArtist($id)
    {
        NailArtist::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Artist törölve'
        ]);
    }

    public function reports()
    {
        return Report::with('rating.user')->get();
    }

    public function deleteRating($id)
    {
        Rating::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Komment törölve'
        ]);
    }

    public function dismissReport($id)
    {
        $report = Report::findOrFail($id);

        $report->resolved = true;
        $report->save();

        return response()->json([
            'message' => 'Report elutasítva'
        ]);
    }
}
