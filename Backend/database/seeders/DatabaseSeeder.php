<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\NailArtist;
use App\Models\Booking;
use App\Models\Service;
use App\Models\GalleryImage;
use App\Models\Rating;
use App\Models\AvailableSlot;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // USERS
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
        // NAIL ARTISTS
        // =====================

        $artists = [];

        foreach ($artistUsers as $index => $artistUser) {
            $artists[] = NailArtist::create([
                'user_id' => $artistUser->id,
                'name' => 'Körmös ' . ($index + 1),
                'city' => 'Budapest',
                'description' => 'Professzionális körmös, több éves tapasztalattal.',
                'rating' => rand(3, 5),
                'price_range' => '5000-15000',
                'approved' => $index < 4, // 4 approved, 2 nem approved
            ]);
        }

        // =====================
        // SERVICES
        // =====================

        $serviceTemplates = [
            ['name' => 'Gél lakkozás', 'duration_min' => 60],
            ['name' => 'Műköröm építés', 'duration_min' => 120],
            ['name' => 'Manikűr', 'duration_min' => 45],
            ['name' => 'Pedikűr', 'duration_min' => 60],
            ['name' => 'Francia köröm', 'duration_min' => 90],
            ['name' => 'Díszítés', 'duration_min' => 30],
            ['name' => 'Köröm töltés', 'duration_min' => 75],
            ['name' => 'Eltávolítás', 'duration_min' => 30],
            ['name' => 'Spa kezelés', 'duration_min' => 60],
            ['name' => 'Expressz manikűr', 'duration_min' => 30],
        ];

        foreach ($artists as $artist) {
            foreach ($serviceTemplates as $serviceData) {
                Service::create([
                    'nail_artist_id' => $artist->id,
                    'name' => $serviceData['name'],
                    'price' => rand(3000, 12000),
                    'duration_min' => $serviceData['duration_min'],
                ]);
            }
        }

        // =====================
        // GALLERY IMAGES
        // =====================

        foreach ($artists as $artist) {
            for ($i = 1; $i <= 3; $i++) {
                GalleryImage::create([
                    'nail_artist_id' => $artist->id,
                    'image_url' => "storage/gallery/sample$i.jpg",
                ]);
            }
        }

        // =====================
        // RATINGS
        // =====================

        Rating::create([
            'user_id' => $user->id,
            'nail_artist_id' => $artists[0]->id,
            'star' => 5,
            'comment' => 'Nagyon elégedett voltam!',
        ]);

        Rating::create([
            'user_id' => $user->id,
            'nail_artist_id' => $artists[1]->id,
            'star' => 4,
            'comment' => 'Szép munka, kedves kiszolgálás.',
        ]);

        // =====================
        // AVAILABLE SLOTS
        // Minden körmös:
        // - 10 slot májusban
        // - 10 slot júniusban
        // hétfőtől vasárnapig engedett napokon
        // =====================

        $timeTemplates = [
            ['start' => '09:00:00', 'end' => '10:00:00'],
            ['start' => '10:30:00', 'end' => '11:30:00'],
            ['start' => '12:00:00', 'end' => '13:00:00'],
            ['start' => '14:00:00', 'end' => '15:00:00'],
            ['start' => '15:30:00', 'end' => '16:30:00'],
        ];

        foreach ($artists as $artistIndex => $artist) {
            // Májusi 10 slot
            $mayDates = $this->generateDatesForMonth(2026, 5, 10);

            foreach ($mayDates as $index => $date) {
                $time = $timeTemplates[$index % count($timeTemplates)];

                AvailableSlot::create([
                    'nail_artist_id' => $artist->id,
                    'slot_date' => $date,
                    'start_time' => $time['start'],
                    'end_time' => $time['end'],
                    'is_booked' => false,
                ]);
            }

            // Júniusi 10 slot
            $juneDates = $this->generateDatesForMonth(2026, 6, 10);

            foreach ($juneDates as $index => $date) {
                $time = $timeTemplates[($index + 2) % count($timeTemplates)];

                AvailableSlot::create([
                    'nail_artist_id' => $artist->id,
                    'slot_date' => $date,
                    'start_time' => $time['start'],
                    'end_time' => $time['end'],
                    'is_booked' => false,
                ]);
            }
        }

        // =====================
        // BOOKING
        // Seedelt user foglalása május 30-ra
        // =====================

        $bookingSlot = AvailableSlot::create([
            'nail_artist_id' => $artists[0]->id,
            'slot_date' => '2026-05-30',
            'start_time' => '11:00:00',
            'end_time' => '12:00:00',
            'is_booked' => true,
        ]);

        $serviceForBooking = Service::where('nail_artist_id', $artists[0]->id)->first();

        Booking::create([
            'user_id' => $user->id,
            'nail_artist_id' => $artists[0]->id,
            'service_id' => $serviceForBooking?->id,
            'available_slot_id' => $bookingSlot->id,
            'booking_date' => '2026-05-30',
            'booking_time' => '11:00:00',
            'status' => 'pending',
        ]);
    }

    private function generateDatesForMonth(int $year, int $month, int $count): array
    {
        $dates = [];
        $current = Carbon::create($year, $month, 1);

        while (count($dates) < $count && $current->month === $month) {
            $dates[] = $current->toDateString();
            $current->addDays(3);
        }

        return $dates;
    }
}
