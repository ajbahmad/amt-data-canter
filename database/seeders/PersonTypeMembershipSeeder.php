<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\PersonType;
use App\Models\PersonTypeMembership;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PersonTypeMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Get all persons and person types
        $persons = Person::all();
        $personTypes = PersonType::all();
        
        if ($persons->isEmpty() || $personTypes->isEmpty()) {
            $this->command->info('No persons or person types found. Skipping PersonTypeMembershipSeeder.');
            return;
        }
        
        $createdMemberships = [];
        
        // For each person, assign 1-3 person types
        foreach ($persons as $person) {
            // Random number of person types per person (1-3)
            $numberOfTypes = $faker->numberBetween(1, 3);
            
            // Get random person types for this person
            $selectedTypes = $personTypes->random(min($numberOfTypes, $personTypes->count()));
            
            foreach ($selectedTypes as $personType) {
                // Create a unique key to prevent duplicates
                $key = "{$person->id}_{$personType->id}";
                
                // Skip if already assigned
                if (isset($createdMemberships[$key])) {
                    continue;
                }
                
                $createdMemberships[$key] = true;
                
                // Create membership
                PersonTypeMembership::create([
                    'person_id' => $person->id,
                    'person_type_id' => $personType->id,
                    'joined_date' => $faker->dateTimeBetween('-3 years', 'now'),
                    'left_date' => null,
                    'is_active' => true,
                ]);
            }
        }
        
    }
}
