<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = SchoolInstitution::all();
        $schoolLevels = SchoolLevel::all();

        foreach ($schools as $school) {
            foreach ($schoolLevels as $level) {
                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => '1',
                    'start_time' => '07:00',
                    'end_time' => '07:40',
                    'order_no' => 1,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => '2',
                    'start_time' => '07:40',
                    'end_time' => '08:20',
                    'order_no' => 2,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => '3',
                    'start_time' => '08:20',
                    'end_time' => '09:00',
                    'order_no' => 3,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => '4',
                    'start_time' => '09:00',
                    'end_time' => '09:40',
                    'order_no' => 4,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => '5',
                    'start_time' => '10:00',
                    'end_time' => '10:40',
                    'order_no' => 6,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => '6',
                    'start_time' => '10:40',
                    'end_time' => '11:20',
                    'order_no' => 7,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => '7',
                    'start_time' => '12:00',
                    'end_time' => '12:40',
                    'order_no' => 9,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => '8',
                    'start_time' => '12:40',
                    'end_time' => '13:20',
                    'order_no' => 10,
                    'is_active' => true,
                ]);
            }
        }
    }
}
