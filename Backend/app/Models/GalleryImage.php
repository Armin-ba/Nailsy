<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'nail_artist_id',
        'image_url'
    ];

    public function nailArtist() {
        return $this->belongsTo(NailArtist::class);
    }
}
