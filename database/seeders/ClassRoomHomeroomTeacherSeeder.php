<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\ClassRoomHomeroomTeacher;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\Teacher;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClassRoomHomeroomTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $classRooms = ClassRoom::all();
        $teachers = Teacher::all();

        if ($classRooms->isEmpty() || $teachers->isEmpty()) {
            return;
        }

        // Assign homeroom teacher to each classroom
        foreach ($classRooms as $classRoom) {
            $randomTeacher = $teachers->random();

            // Extract institution and level from classroom
            $schoolInstitution = $classRoom->schoolInstitution;
            $schoolLevel = $classRoom->schoolLevel;

            // Hindari duplikasi
            if (!ClassRoomHomeroomTeacher::where('class_room_id', $classRoom->id)
                ->where('teacher_id', $randomTeacher->id)
                ->exists()) {
                ClassRoomHomeroomTeacher::create([
                    'class_room_id' => $classRoom->id,
                    'teacher_id' => $randomTeacher->id,
                    'school_institution_id' => $schoolInstitution ? $schoolInstitution->id : null,
                    'school_level_id' => $schoolLevel ? $schoolLevel->id : null,
                    'assigned_at' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                    'is_active' => true,
                ]);
            }
        }
    }
}

