<?php

namespace Database\Seeders;

use App\Models\Medium;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = file_get_contents(__DIR__.'/data/action-media.json');
        $data = json_decode($jsonFile);
        foreach ($data as $x){
            $mediumData = get_object_vars($x->medium);
            $mediumModel = Medium::create($mediumData);
            dd($mediumModel);
        }
        // foreach ($data as $value){
        //     Gender::create([
        //         'name' => $value->gender
        //     ]);
        // }
    }
}
