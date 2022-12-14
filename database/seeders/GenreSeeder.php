<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = file_get_contents(__DIR__.'/data/genres.json');
        $data = json_decode($jsonFile);
        foreach ($data->genres as $value){
            Genre::create([
                'name' => $value->name
            ]);
        }
    }
}
