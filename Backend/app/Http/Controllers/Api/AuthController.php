<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        if ($validated['role'] === 'artist') {
            \App\Models\NailArtist::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'street' => $validated['street'],
                'house_number' => $validated['house_number'],
                'salon_address' => $validated['salon_address'] ?? null,
                'description' => $validated['description'] ?? 'Új körmös profil jóváhagyásra vár.',
                'rating' => 0,
                'price_range' => 'Nincs megadva',
                'approved' => false,
            ]);
        }

        return response()->json([
            'message' => $validated['role'] === 'artist'
                ? 'Sikeres körmös regisztráció. A profil admin jóváhagyásra vár.'
                : 'Sikeres regisztráció.',
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Hibás email vagy jelszó',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Sikeres bejelentkezés',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function me(\Illuminate\Http\Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Sikeres kijelentkezés',
        ]);
    }
}
