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

    public function countries(){
        return $this->belongsToMany(Country::class);
    }
    
    public function keywords(){
        return $this->belongsToMany(Country::class);
    }

    public function languages(){
        return $this->belongsToMany(Language::class);
    }

    public function languageRoles(){
        return $this->belongsToMany(LanguageRole::class);
    }
}
