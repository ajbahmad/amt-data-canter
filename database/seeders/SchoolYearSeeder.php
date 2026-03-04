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
        // Get first school level for each institution
        foreach (SchoolLevel::all() as $ksl => $vsl) {
            SchoolYear::updateOrCreate([
                'school_institution_id' => $vsl->school_institution_id,
                'school_level_id' => $vsl->id,
                'name' => '2026',
            ],[
                'id' => Str::uuid(),
                'school_institution_id' => $vsl->school_institution_id,
                'school_level_id' => $vsl->id,
                'name' => '2026',
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-12',
                'is_active' => true,
            ]);
        }
    }
}
