<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medium extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'original_title', 'release_date', 'overview', 'duration', 'type'];

    public function seasons(){
        return $this->hasMany(Season::class);
    }

    public function genres(){
        return $this->belongsToMany(Genre::class);
    }

    public function casts(){
        return $this->hasMany(Cast::class);
    }

    public function crews(){
        return $this->hasMany(Crew::class);
    }
    public function lists(){
        return $this->belongsToMany(Medium_list::class);
    }
}
