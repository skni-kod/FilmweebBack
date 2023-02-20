<?php

namespace Database\Seeders;

use App\Models\Medium;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = file_get_contents(__DIR__ . '/data/MOCK_DATA.json');
        $data = json_decode($jsonFile);
        foreach ($data as $x) {

        }
    }
}
