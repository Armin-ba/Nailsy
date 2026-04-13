<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'nail_artist_id',
        'name',
        'price',
        'duration'
    ];

    public function nailArtist() {
        return $this->belongsTo(NailArtist::class);
    }
}
