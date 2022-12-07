<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = file_get_contents(__DIR__.'/data/languages.json');
        $data = json_decode($jsonFile);
        foreach ($data->languages as $value){
            Language::create([
                'name' => $value->name,
                'code' => $value->code
            ]);
        }
    }
}
