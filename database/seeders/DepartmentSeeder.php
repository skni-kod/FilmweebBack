<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
                'name' => 'Reżyser'
        ]);
        Department::create([
                'name' => 'Scenariusz'
        ]);
        Department::create([
                'name' => 'Zdjęcia'
        ]);
        Department::create([
                'name' => 'Muzyka'
        ]);
        Department::create([
                'name' => 'Montaż'
        ]);
        Department::create([
                'name' => 'Scenografia'
        ]);
        Department::create([
                'name' => 'Kostiumy'
        ]);
        Department::create([
                'name' => 'Produkcja'
        ]);
        Department::create([
                'name' => 'Dźwięk'
        ]);
    }
}
