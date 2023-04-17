<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Medium;
use App\Models\User;
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
        $media = Medium::all();
        $randomUser = User::inRandomOrder()->first();

        foreach ($media as $medium) {
            Grade::create([
                'medium_id' => $medium->id,
                'user_id' => $randomUser->id,
                'content' => "lol",
                'rating' => rand(0, 10) / 2.0,
            ]);
        }
    }
}
