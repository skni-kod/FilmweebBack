<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageRole extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function media()
    {
        return $this->belongsToMany(Medium::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }
}
