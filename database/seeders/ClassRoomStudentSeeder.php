<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\ClassRoomStudent;
use App\Models\Student;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClassRoomStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $classRooms = ClassRoom::all();
        $students = Student::all();

        if ($classRooms->isEmpty() || $students->isEmpty()) {
            return;
        }

        // Assign students to classrooms (30-40 students per classroom)
        $assignedStudents = [];
        foreach ($classRooms as $classRoom) {
            $numStudents = $faker->numberBetween(30, 40);
            $classroomStudents = $students->random(min($numStudents, $students->count()));

            foreach ($classroomStudents as $student) {
                // Hindari duplikasi
                if (!isset($assignedStudents[$student->id][$classRoom->id])) {
                    ClassRoomStudent::create([
                        'class_room_id' => $classRoom->id,
                        'student_id' => $student->id,
                        'joined_at' => $faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
                        'is_active' => true,
                    ]);
                    $assignedStudents[$student->id][$classRoom->id] = true;
                }
            }
        }
    }
}
