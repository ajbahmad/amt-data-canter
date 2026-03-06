<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\SchoolInstitution;
use App\Models\Teacher;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $schoolInstitutions = SchoolInstitution::all();
        
        if ($schoolInstitutions->isEmpty()) {
            $this->command->info('No school institutions found. Skipping TeacherSeeder.');
            return;
        }
        
        // Ambil 50 persons sebagai guru
        $persons = Person::inRandomOrder()->limit(50)->get();
        
        $specializations = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'Seni Rupa', 'Musik', 'Olahraga', 'TIK', 'Agama'];
        $employmentTypes = ['permanent', 'contract', 'honorary'];
        
        foreach ($persons as $index => $person) {
            Teacher::create([
                'person_id' => $person->id,
                'school_institution_id' => $schoolInstitutions->random()->id,
                'teacher_id' => 'GRU' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'specialization' => $faker->randomElement($specializations),
                'employment_type' => $faker->randomElement($employmentTypes),
                'hire_date' => $faker->dateTimeBetween('-15 years', 'now')->format('Y-m-d'),
                'is_active' => true,
            ]);
        }
    }
}
