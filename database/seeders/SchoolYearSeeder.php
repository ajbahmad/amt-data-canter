<?php

namespace Database\Seeders;

use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\SchoolYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get school levels with their institutions
        foreach (SchoolLevel::all() as $schoolLevel) {
            SchoolYear::updateOrCreate(
                [
                    'school_institution_id' => $schoolLevel->school_institution_id,
                    'school_level_id' => $schoolLevel->id,
                    'name' => '2026',
                ],
                [
                    'start_date' => '2026-01-01',
                    'end_date' => '2026-12-31',
                    'is_active' => true,
                ]
            );
        }
    }
}
