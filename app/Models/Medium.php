<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medium extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'original_title', 'release_date', 'overview', 'duration', 'type', 'image_path'];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class);
    }

    public function casts()
    {
        return $this->hasMany(Cast::class);
    }

    public function crews()
    {
        return $this->hasMany(Crew::class);
    }

    public function lists()
    {
        return $this->belongsToMany(Medium_list::class);
    }

    public function production_companies()
    {
        return $this->belongsToMany(ProductionCompany::class);
    }

    /**
     * Get the images for the medium.
     */
    public function images()
    {
        return $this->hasMany(MediumImage::class);
    }
}
