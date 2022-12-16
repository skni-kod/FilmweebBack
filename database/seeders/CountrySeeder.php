<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = file_get_contents(__DIR__.'/data/countries.json');
        $data = json_decode($jsonFile);
        foreach ($data->countries as $value){
            Country::create([
                'name' => $value->name,
                'code' => $value->code
            ]);
        }
    }
}
