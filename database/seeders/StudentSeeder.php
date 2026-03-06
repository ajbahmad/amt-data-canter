<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\SchoolInstitution;
use App\Models\Student;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get all school institutions
        $schoolInstitutions = SchoolInstitution::all();
        
        if ($schoolInstitutions->isEmpty()) {
            $this->command->info('No school institutions found. Skipping StudentSeeder.');
            return;
        }
        
        // Ambil sisa persons sebagai siswa (min 80 persons)
        $persons = Person::inRandomOrder()->skip(80)->get();
        
        foreach ($persons as $index => $person) {
            Student::create([
                'person_id' => $person->id,
                'school_institution_id' => $schoolInstitutions->random()->id,
                'student_id' => 'SIS' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'enrollment_date' => $faker->dateTimeBetween('-6 years', 'now')->format('Y-m-d'),
                'is_active' => true,
            ]);
        }
    }
}
