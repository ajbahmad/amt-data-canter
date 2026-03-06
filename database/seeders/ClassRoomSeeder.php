<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\SchoolLevel;
use App\Models\Grade;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolLevels = SchoolLevel::all();

        $classRoomVariations = ['A', 'B', 'C', 'D', 'E'];

        foreach ($schoolLevels as $schoolLevel) {
            // Get grades from the same school institution
            $grades = Grade::where('school_institution_id', $schoolLevel->school_institution_id)->get();

            foreach ($grades as $grade) {
                // Create multiple class rooms per grade
                for ($i = 0; $i < 3; $i++) {
                    $variation = $classRoomVariations[$i] ?? 'A';
                    
                    ClassRoom::updateOrCreate(
                        [
                            'grade_id' => $grade->id,
                            'school_level_id' => $schoolLevel->id,
                            'name' => $grade->name . ' - ' . $variation,
                        ],
                        [
                            'school_institution_id' => $schoolLevel->school_institution_id,
                            'capacity' => 30,
                            'is_active' => true,
                        ]
                    );
                }
            }
        }
    }
}
