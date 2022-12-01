<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//lists table
class Medium_list extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','name'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function media(){
        return $this->belongsToMany(Medium::class);
    }

    public function genders(){
        return $this->hasMany(Gender::class);
    }
}
