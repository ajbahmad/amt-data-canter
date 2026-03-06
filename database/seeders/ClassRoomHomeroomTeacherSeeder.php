<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\ClassRoomHomeroomTeacher;
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

            // Hindari duplikasi
            if (!ClassRoomHomeroomTeacher::where('class_room_id', $classRoom->id)
                ->where('teacher_id', $randomTeacher->id)
                ->exists()) {
                ClassRoomHomeroomTeacher::create([
                    'class_room_id' => $classRoom->id,
                    'teacher_id' => $randomTeacher->id,
                    'assigned_at' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                    'is_active' => true,
                ]);
            }
        }
    }
}

