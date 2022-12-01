<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['iso_code', 'name'];

    public function media()
    {
        return $this->belongsToMany(Medium::class);
    }

    public function languageRoles()
    {
        return $this->belongsToMany(Medium::class);
    }
}
