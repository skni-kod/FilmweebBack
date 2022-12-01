<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable=['first_name','last_name'];
    
    public function casts(){
        return $this->hasMany(Cast::class);
    }
    
    public function crews(){
        return $this->hasMany(Crew::class);
    }
}

