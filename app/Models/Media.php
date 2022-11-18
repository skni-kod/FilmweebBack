<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'original_title', 'release_date', 'overview', ' duration', 'type'];

    public function mediaGenre(){
        return $this->hasMany(MediaGenre::class);
    }

    public function season(){
        return $this->hasMany(Season::class);
    }
}
