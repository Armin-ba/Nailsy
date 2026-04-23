<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\NailArtist;
use App\Models\Booking;
use App\Models\Service;
use App\Models\GalleryImage;
use App\Models\Rating;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // USERS (8 db)
        // =====================

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $artistUsers = [];

        for ($i = 1; $i <= 6; $i++) {
            $artistUsers[] = User::create([
                'name' => "Artist $i",
                'email' => "artist$i@test.com",
                'password' => Hash::make('password'),
                'role' => 'artist',
            ]);
        }

        // =====================
        // NAIL ARTISTS (6 db)
        // =====================

        $artists = [];

        foreach ($artistUsers as $index => $u) {
            $artists[] = NailArtist::create([
                'user_id' => $u->id,
                'name' => 'Körmös ' . ($index + 1),
                'city' => 'Budapest',
                'description' => 'Professzionális körmös',
                'rating' => rand(3, 5),
                'price_range' => '5000-15000',
                'approved' => $index < 4,
            ]);
        }

        // =====================
        // SERVICES
        // =====================

        $serviceNames = [
            'Gél lakkozás',
            'Műköröm építés',
            'Manikűr',
            'Pedikűr',
            'Francia köröm',
            'Díszítés',
            'Köröm töltés',
            'Eltávolítás',
            'Spa kezelés',
            'Expressz manikűr',
        ];

        foreach ($artists as $artist) {
            foreach ($serviceNames as $s) {
                Service::create([
                    'nail_artist_id' => $artist->id,
                    'name' => $s,
                    'price' => rand(3000, 12000),
                    'duration_min' => rand(30, 90),
                ]);
            }
        }

        // =====================
        // BOOKING
        // =====================

        Booking::create([
            'user_id' => $user->id,
            'nail_artist_id' => $artists[0]->id,
            'booking_date' => '2026-05-30',
            'status' => 'pending',
        ]);

        // =====================
        // GALLERY
        // =====================

        foreach ($artists as $artist) {
            for ($i = 1; $i <= 3; $i++) {
                GalleryImage::create([
                    'nail_artist_id' => $artist->id,
                    'image_url' => "storage/gallery/sample$i.jpg",
                ]);

            }
        }


        Rating::create([
            'user_id' => $user->id,
            'nail_artist_id' => $artists[0]->id,
            'star' => 5,
            'comment' => 'Nagyon elégedett voltam!'
        ]);

        Rating::create([
            'user_id' => $user->id,
            'nail_artist_id' => $artists[1]->id,
            'star' => 4,
            'comment' => 'Szép munka'
        ]);
    }
}
