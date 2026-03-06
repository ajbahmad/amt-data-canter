<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        
        $this->call([
            UserSeeder::class,
            SchoolInstitutionSeeder::class,
            SchoolLevelSeeder::class,
            SchoolYearSeeder::class,
            SemesterSeeder::class,
            GradeSeeder::class,
            SubjectSeeder::class,
            ClassRoomSeeder::class,
            MenuSeeder::class,
            PersonTypeSeeder::class,
            PersonSeeder::class,
            PersonTypeMembershipSeeder::class,
            StudentSeeder::class,
            StaffSeeder::class,
            TeacherSeeder::class,
            TimeSlotSeeder::class,
            ClassRoomStudentSeeder::class,
            ClassRoomHomeroomTeacherSeeder::class,
            TeacherSubjectAssignmentSeeder::class,
        ]);
    }
}
