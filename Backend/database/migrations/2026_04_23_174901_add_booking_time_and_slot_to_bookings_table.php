<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('available_slot_id')
                ->nullable()
                ->after('nail_artist_id')
                ->constrained('available_slots')
                ->nullOnDelete();

            $table->time('booking_time')
                ->nullable()
                ->after('booking_date');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('available_slot_id');
            $table->dropColumn('booking_time');
        });
    }
};
