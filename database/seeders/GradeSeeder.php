<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolLevels = SchoolLevel::all();

        $gradesByLevel = [
            'MI' => ['I', 'II', 'III', 'IV', 'V', 'VI'],
            'SD' => ['I', 'II', 'III', 'IV', 'V', 'VI'],
            'Mts' => ['VII', 'VIII', 'IX'],
            'SMP' => ['I', 'II', 'III'],
            'MA' => ['X', 'XI', 'XII'],
            'SMA' => ['X', 'XI', 'XII'],
            'SMK' => ['X', 'XI', 'XII'],
        ];

        foreach ($schoolLevels as $schoolLevel) {
            $grades = $gradesByLevel[$schoolLevel->code] ?? ['I', 'II', 'III', 'IV', 'V', 'VI'];
            
            foreach ($grades as $grade) {
                Grade::updateOrCreate(
                    [
                        'school_level_id' => $schoolLevel->id,
                        'name' => $grade,
                    ],
                    [
                        'school_institution_id' => $schoolLevel->school_institution_id,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
