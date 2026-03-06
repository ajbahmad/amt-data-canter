<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\SchoolInstitution;
use App\Models\Staff;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
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
            $this->command->info('No school institutions found. Skipping StaffSeeder.');
            return;
        }
        
        // Ambil 30 persons sebagai staff
        $persons = Person::inRandomOrder()->limit(30)->get();
        
        $staffPositions = ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru Besar', 'Staf TU', 'Petugas Keamanan', 'Petugas Kebersihan'];
        
        foreach ($persons as $index => $person) {
            Staff::create([
                'person_id' => $person->id,
                'school_institution_id' => $schoolInstitutions->random()->id,
                'staff_id' => 'STF' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'position' => $faker->randomElement($staffPositions),
                'hire_date' => $faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
                'is_active' => true,
            ]);
        }
    }
}
