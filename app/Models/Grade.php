<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['medium_id', 'user_id', 'content'];

    public function medium(){
        return $this->belongsTo(Medium::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
