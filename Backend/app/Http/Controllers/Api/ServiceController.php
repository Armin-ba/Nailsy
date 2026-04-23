<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\NailArtist;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function byArtist($artistId)
    {
        $services = Service::where('nail_artist_id', $artistId)->get();

        return response()->json($services);
    }

    public function myServices(Request $request)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $services = Service::where('nail_artist_id', $artist->id)->get();

        return response()->json($services);
    }

    public function store(StoreServiceRequest $request)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $service = Service::create([
            'nail_artist_id' => $artist->id,
            'name' => $request->name,
            'price' => $request->price,
            'duration_min' => $request->duration_min,
        ]);

        return response()->json([
            'message' => 'Szolgáltatás létrehozva.',
            'service' => $service,
        ], 201);
    }

    public function update(StoreServiceRequest $request, $id)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $service = Service::where('nail_artist_id', $artist->id)
            ->findOrFail($id);

        $service->update($request->validated());

        return response()->json([
            'message' => 'Szolgáltatás frissítve.',
            'service' => $service,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $artist = NailArtist::where('user_id', $request->user()->id)->firstOrFail();

        $service = Service::where('nail_artist_id', $artist->id)
            ->findOrFail($id);

        $service->delete();

        return response()->json([
            'message' => 'Szolgáltatás törölve.',
        ]);
    }
}
