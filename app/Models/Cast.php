<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;

    protected $fillable=['medium_id','person_id','gender_id','character','priority'];

    public function medium(){
        return $this->belongsTo(Medium::class);
    }

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function gender(){
        return $this->belongsTo(Gender::class);
    }
}
