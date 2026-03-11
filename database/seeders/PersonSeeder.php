<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\SchoolInstitution;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolInstitutionIds = SchoolInstitution::pluck('id')->toArray();

        foreach ($schoolInstitutionIds as $key => $value) {
            $faker = Faker::create('id_ID');
            for ($i = 0; $i < 200; $i++) {
                Person::create([
                    'school_institution_id' => $value,
                    'first_name' => $faker->firstName(),
                    'last_name' => $faker->lastName(),
                    'email' => $faker->unique()->safeEmail(),
                    'phone' => $faker->phoneNumber(),
                    'gender' => $faker->randomElement(['male', 'female']),
                    'birth_date' => $faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
                    'birth_place' => $faker->city(),
                    'address' => $faker->address(),
                    'city' => $faker->city(),
                    'province' => $faker->state(),
                    'postal_code' => $faker->postcode(),
                    'identity_number' => $faker->unique()->numerify('################'),
                ]);
            }
        }
    }
}
