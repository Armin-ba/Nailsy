<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\NailArtist;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ADMIN
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // ARTIST USER
        $artistUser = User::create([
            'name' => 'Artist User',
            'email' => 'artist@test.com',
            'password' => bcrypt('password'),
            'role' => 'artist'
        ]);

        // USER
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        // ARTIST PROFIL
        NailArtist::create([
            'user_id' => $artistUser->id,
            'name' => 'Pro Körmös',
            'city' => 'Budapest',
            'description' => 'Gél lakkozás specialista',
            'approved' => true
        ]);
    }
}
