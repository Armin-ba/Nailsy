<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryImage extends Model
{
use HasFactory;

protected $fillable = [
'nail_artist_id',
'image_url',
'description',
];

public function nailArtist(): BelongsTo
{
return $this->belongsTo(NailArtist::class);
}
}
?>
