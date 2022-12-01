<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['iso_code', 'name'];

    public function media()
    {
        return $this->belongsToMany(Medium::class);
    }
}
