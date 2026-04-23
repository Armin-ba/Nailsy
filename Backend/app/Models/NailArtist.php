<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NailArtist extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'city',
        'description',
        'rating',
        'price_range',
        'approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function availableSlots()
    {
        return $this->hasMany(AvailableSlot::class);
    }
}
