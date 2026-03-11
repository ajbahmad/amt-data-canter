<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubjectAssignment;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TeacherSubjectAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $classRooms = ClassRoom::all();
        $semesters = Semester::all();
        $schoolInstitutions = SchoolInstitution::where('is_active', true)->get();
        $schoolLevels = SchoolLevel::where('is_active', true)->get();

        if ($teachers->isEmpty() || $subjects->isEmpty() || $classRooms->isEmpty() || $semesters->isEmpty() || $schoolInstitutions->isEmpty() || $schoolLevels->isEmpty()) {
            return;
        }

        // Assign teachers to subjects per classroom per semester
        foreach ($classRooms as $classRoom) {
            foreach ($semesters as $semester) {
                // Get school institution and level from classRoom
                $schoolInstitution = $classRoom->schoolInstitution;
                $schoolLevel = $classRoom->schoolLevel;

                // Assign 3-5 subject-teacher combinations per classroom per semester
                $subjectsForClass = $subjects->random(min(4, $subjects->count()));

                foreach ($subjectsForClass as $subject) {
                    $randomTeacher = $teachers->random();

                    // Hindari duplikasi
                    if (!TeacherSubjectAssignment::where('teacher_id', $randomTeacher->id)
                        ->where('subject_id', $subject->id)
                        ->where('class_room_id', $classRoom->id)
                        ->where('semester_id', $semester->id)
                        ->exists()) {
                        TeacherSubjectAssignment::create([
                            'school_institution_id' => $schoolInstitution ? $schoolInstitution->id : null,
                            'school_level_id' => $schoolLevel ? $schoolLevel->id : null,
                            'teacher_id' => $randomTeacher->id,
                            'subject_id' => $subject->id,
                            'class_room_id' => $classRoom->id,
                            'semester_id' => $semester->id,
                            'assigned_at' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }
    }
}
