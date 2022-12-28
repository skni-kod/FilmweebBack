<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function addImage(Request $request, $id){
        $person = Person::findOrFail($id);
        $person->image_path = Storage::disk('dropbox')->put('actors', $request->file('image'));
        if($person->save()){
            return response('success', 200);
        }
        else {
            return response('false', 400);
        }
    }
    
    public function getPerson($id){
        return response(new PersonResource(Person::findOrFail($id)), 200);
    }
}
