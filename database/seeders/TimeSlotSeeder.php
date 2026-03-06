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
                    'name' => 'Jam 1 (07:00 - 07:40)',
                    'start_time' => '07:00',
                    'end_time' => '07:40',
                    'order_no' => 1,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Jam 2 (07:40 - 08:20)',
                    'start_time' => '07:40',
                    'end_time' => '08:20',
                    'order_no' => 2,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Jam 3 (08:20 - 09:00)',
                    'start_time' => '08:20',
                    'end_time' => '09:00',
                    'order_no' => 3,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Jam 4 (09:00 - 09:40)',
                    'start_time' => '09:00',
                    'end_time' => '09:40',
                    'order_no' => 4,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Istirahat 1 (09:40 - 10:00)',
                    'start_time' => '09:40',
                    'end_time' => '10:00',
                    'order_no' => 5,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Jam 5 (10:00 - 10:40)',
                    'start_time' => '10:00',
                    'end_time' => '10:40',
                    'order_no' => 6,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Jam 6 (10:40 - 11:20)',
                    'start_time' => '10:40',
                    'end_time' => '11:20',
                    'order_no' => 7,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Istirahat 2 (11:20 - 12:00)',
                    'start_time' => '11:20',
                    'end_time' => '12:00',
                    'order_no' => 8,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Jam 7 (12:00 - 12:40)',
                    'start_time' => '12:00',
                    'end_time' => '12:40',
                    'order_no' => 9,
                    'is_active' => true,
                ]);

                TimeSlot::create([
                    'school_institution_id' => $school->id,
                    'school_level_id' => $level->id,
                    'name' => 'Jam 8 (12:40 - 13:20)',
                    'start_time' => '12:40',
                    'end_time' => '13:20',
                    'order_no' => 10,
                    'is_active' => true,
                ]);
            }
        }
    }
}
