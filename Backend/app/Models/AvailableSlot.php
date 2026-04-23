<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    protected $fillable = [
        'nail_artist_id',
        'slot_date',
        'start_time',
        'end_time',
        'is_booked',
    ];

    public function nailArtist()
    {
        return $this->belongsTo(NailArtist::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
