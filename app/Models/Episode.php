<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'title', 'season_id'];

    public function season(){
        return $this->belongsTo(Season::class);
    }
}
