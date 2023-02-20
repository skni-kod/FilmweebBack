<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediumImage extends Model
{
    use HasFactory;

    protected $fillable = ['medium_id', 'image_path'];

    /**
     * Get the medium that owns the image.
     */
    public function medium()
    {
        return $this->belongsTo(Medium::class);
    }
}
