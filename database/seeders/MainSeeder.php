<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\Country;
use App\Models\Crew;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Genre;
use App\Models\Medium;
use App\Models\Person;
use App\Models\ProductionCompany;
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
            //medium
            $mediumData = get_object_vars($x->medium);
            $mediumModel = Medium::firstOrCreate($mediumData);

            //genre and genre_medium
            $genreData = $x->genre;
            foreach ($genreData as $genre){
                $genreModel = Genre::firstOrCreate(['name' => $genre->name]);
                $mediumModel->genres()->attach($genreModel->id);
            }

            //production companies and company_medium
            $productionCompanyData = get_object_vars($x->production_companies);
            $productionCompanyModel = ProductionCompany::firstOrCreate($productionCompanyData);
            $mediumModel->porduction_companies()->attach($productionCompanyModel->id);

            //countries and country_medium
            $countriesData = $x->countries;
            foreach ($countriesData as $country){
                $countryModel = Country::firstOrCreate([
                    'code'=> $country->code,
                    'name'=> $country->name
                ]);
                $mediumModel->countries()->attach($countryModel->id);
            }

            //casts
            $castsData = $x->casts;
            foreach($castsData as $cast){
                $genderModel = Gender::where('name', $cast->gender)->first();
                $personData = get_object_vars($cast->person);
                $personModel = Person::firstOrCreate($personData);
                $castData = array(
                    'medium_id' => $mediumModel->id,
                    'gender_id' => $genderModel->id,
                    'person_id' => $personModel->id,
                    'character' => $cast->character,
                    'priority' => $cast->priority
                );
                $castModel = Cast::create($castData);
            }

            //crews
            $crewsData = $x->crews;
            foreach($crewsData as $crew){
                $personData = get_object_vars($crew->person);
                $personModel = Person::firstOrCreate($personData);
                $departmentModel = Department::firstOrCreate(['name' => $crew->department]);
                $crewData = array(
                    'medium_id' => $mediumModel->id,
                    'person_id' => $personModel->id,
                    'department_id' => $departmentModel->id,
                    'job' => $crew->job
                );
                $crewModel = Crew::create($crewData);
            }
        }
    }
}
