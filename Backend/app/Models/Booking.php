<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'nail_artist_id',
        'booking_date',
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
}
