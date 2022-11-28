<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['medium_id', 'value', 'title'];

    public function media(){
        return $this->belongsTo(Medium::class);
    }

    public function episodes(){
        return $this->hasMany(Episode::class);
    }
}
