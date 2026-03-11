<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\SchoolLevel;
use App\Models\Grade;
use App\Models\SchoolInstitution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolInstitutionIds = SchoolInstitution::all();
        foreach ($schoolInstitutionIds as $key => $schoolInstitutionId) {
            $schoolLevels = SchoolLevel::where('school_institution_id', $schoolInstitutionId->id)->get();
            foreach ($schoolLevels as $key => $schoolLevel) {
                $grades = Grade::where('school_institution_id', $schoolInstitutionId->id)
                    ->where('school_level_id', $schoolLevel->id)
                    ->get();

                $classRoomVariations = ['A', 'B', 'C'];
                foreach ($grades as $key => $grade) {
                    for ($i = 0; $i < 3; $i++) {
                        ClassRoom::updateOrCreate(
                            [
                                'school_institution_id' => $schoolInstitutionId->id,
                                'school_level_id' => $schoolLevel->id,
                                'grade_id' => $grade->id,
                                'name' => $grade->name . $classRoomVariations[$i],
                            ],
                            [
                                'capacity' => 20,
                                'is_active' => true,
                            ]
                        );
                        Log::info([
                            'school_institution_id' => $schoolInstitutionId->id,
                            'school_level_id' => $schoolLevel->id,
                            'grade_id' => $grade->id,
                            'name' => $grade->name . $classRoomVariations[$i],
                            'capacity' => 20,
                            'is_active' => true,
                        ]);
                    }
                }
            }
        }
    }
}
