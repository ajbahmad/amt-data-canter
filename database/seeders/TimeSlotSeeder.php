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
        $levels = SchoolLevel::all();

        $timeSlots = [
            [
                'name' => '1',
                'start_time' => '08:30',
                'end_time' => '08:52',
                'order_no' => 1,
            ],
            [
                'name' => '2',
                'start_time' => '08:52',
                'end_time' => '09:14',
                'order_no' => 2,
            ],
            [
                'name' => '3',
                'start_time' => '09:14',
                'end_time' => '09:36',
                'order_no' => 3,
            ],
            [
                'name' => '4',
                'start_time' => '09:36',
                'end_time' => '09:55',
                'order_no' => 4,
            ],
            [
                'name' => '5',
                'start_time' => '10:10',
                'end_time' => '10:42',
                'order_no' => 5,
            ],
            [
                'name' => '6',
                'start_time' => '10:42',
                'end_time' => '11:15',
                'order_no' => 6,
            ],
        ];

        foreach ($schools as $school) {
            foreach ($levels as $level) {

                foreach ($timeSlots as $slot) {

                    TimeSlot::create([
                        'school_institution_id' => $school->id,
                        'school_level_id' => $level->id,
                        'name' => $slot['name'],
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'],
                        'order_no' => $slot['order_no'],
                        'is_active' => true,
                    ]);

                }

            }
        }
    }
}