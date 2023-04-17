<?php

namespace App\Services;

use App\Models\Person;

class PersonService
{
    /**
     * Display the person by id.
     */
    public function findById($personId)
    {
        return Person::findOrFail($personId);
    }
}
