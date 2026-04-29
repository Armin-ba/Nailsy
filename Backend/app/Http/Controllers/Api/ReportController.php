<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating_id' => ['required', 'exists:ratings,id'],
            'reason' => ['required', 'string', 'min:3', 'max:255'],
        ]);

        $rating = Rating::findOrFail($validated['rating_id']);

        $alreadyReported = Report::where('rating_id', $rating->id)
            ->where('reported_by', $request->user()->id)
            ->where('resolved', false)
            ->exists();

        if ($alreadyReported) {
            return response()->json([
                'message' => 'Ezt a hozzászólást már jelentetted.',
            ], 422);
        }

        $report = Report::create([
            'rating_id' => $rating->id,
            'reported_by' => $request->user()->id,
            'reason' => $validated['reason'],
            'resolved' => false,
        ]);

        return response()->json([
            'message' => 'Jelentés sikeresen elküldve.',
            'report' => $report,
        ], 201);
    }
}
