<?php 

namespace App\Services;

use App\Models\Medium;

class MediumService{

    /**
     * Display the medium by id.
     */
    public function findById($mediumId){
        return Medium::findOrFail($mediumId);

    }
}