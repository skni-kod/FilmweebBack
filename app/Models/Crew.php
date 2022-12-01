<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;

    protected $fillable=['medium_id','person_id','department_id','job'];
    public function medium(){
        return $this->belongsTo(Media::class);
    }

    public function person(){
        return $this->belongsTo(Person::class);
    }
    
    public function department(){
        return $this->belongsTo(Department::class); 
    }
}
