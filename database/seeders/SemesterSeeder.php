<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\SchoolYear;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolYears = SchoolYear::all();

        $semesters = [
            [
                'name' => 'Ganjil',
                'semester' => 1,
                'start_date' => '2026-01-15',
                'end_date' => '2026-06-15',
                'is_active' => true,
            ],
            [
                'name' => 'Genap',
                'semester' => 2,
                'start_date' => '2026-07-01',
                'end_date' => '2026-12-15',
                'is_active' => true,
            ],
        ];

        foreach ($schoolYears as $schoolYear) {
            foreach ($semesters as $semester) {
                Semester::firstOrCreate(
                    [
                        'school_year_id' => $schoolYear->id,
                        'name' => $semester['name'],
                    ],
                    [
                        'school_institution_id' => $schoolYear->school_institution_id,
                        'semester' => $semester['semester'],
                        'start_date' => $semester['start_date'],
                        'end_date' => $semester['end_date'],
                        'is_active' => $semester['is_active'],
                    ]
                );
            }
        }
    }
}
