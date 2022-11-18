<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['media_id', 'value', 'title'];

    public function media(){
        return $this->belongsTo(Media::class);
    }

    public function episode(){
        return $this->hasMany(Episode::class);
    }
}
