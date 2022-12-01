<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = ['name','list_id'];

    public function list(){
        return $this->belongsTo(List::class);
    }
    
    public function casts(){
        return $this->hasMany(Cast::class);
    }
}

