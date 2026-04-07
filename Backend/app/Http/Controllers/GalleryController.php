<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return GalleryImage::all();
    }

    public function store(Request $request)
    {
        return GalleryImage::create($request->all());
    }

    public function show($id)
    {
        return GalleryImage::findOrFail($id);
    }

    public function destroy($id)
    {
        GalleryImage::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
