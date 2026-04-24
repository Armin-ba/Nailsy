<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nail_artists', function (Blueprint $table) {
            $table->string('postal_code')->nullable()->after('city');
            $table->string('street')->nullable()->after('postal_code');
            $table->string('house_number')->nullable()->after('street');
            $table->string('salon_address')->nullable()->after('house_number');
        });
    }

    public function down(): void
    {
        Schema::table('nail_artists', function (Blueprint $table) {
            $table->dropColumn([
                'postal_code',
                'street',
                'house_number',
                'salon_address',
            ]);
        });
    }
};
