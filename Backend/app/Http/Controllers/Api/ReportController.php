<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Rating;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating_id' => 'required|exists:ratings,id',
            'reason' => 'nullable|string|max:255'
        ]);

        $report = Report::create([
            'rating_id' => $request->rating_id,
            'reported_by' => $request->user()->id,
            'reason' => $request->reason
        ]);

        return response()->json([
            'message' => 'Report elküldve',
            'report' => $report
        ]);
    }
}
