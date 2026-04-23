<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'nail_artist_id',
        'service_id',
        'available_slot_id',
        'booking_date',
        'booking_time',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nailArtist()
    {
        return $this->belongsTo(NailArtist::class);
    }

    public function availableSlot()
    {
        return $this->belongsTo(AvailableSlot::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
