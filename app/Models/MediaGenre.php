<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaGenre extends Model
{
    use HasFactory;

    public function media(){
        return $this->belongsTo(Media::class);
    }

    public function genre(){
        $this->belongsTo(Genre::class);
    }
}
