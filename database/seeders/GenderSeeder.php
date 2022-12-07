<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = file_get_contents(__DIR__.'/data/genders.json');
        $data = json_decode($jsonFile);
        foreach ($data as $value){
            Gender::create([
                'name' => $value->gender
            ]);
        }
    }
}
