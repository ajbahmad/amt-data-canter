<?php

namespace Database\Seeders;

use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SchoolLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolInstitutionIds = SchoolInstitution::pluck('id')->toArray();

        $levels = [
            [
                'code' => 'SD',
                'name' => 'Sekolah Dasar',
                'description' => 'Sekolah Dasar',
            ],
            [
                'code' => 'SMP',
                'name' => 'Sekolah menengah pertama',
                'description' => 'Sekolah menengah pertama',
            ],
            [
                'code' => 'Mts',
                'name' => 'Madrasah Tsanawiyah',
                'description' => 'Madrasah Tsanawiyah',
            ],
            [
                'code' => 'MI',
                'name' => 'Madrasah Ibtidaiyah',
                'description' => 'Madrasah Ibtidaiyah',
            ],
            [
                'code' => 'MA',
                'name' => 'Madrasah Aliyah',
                'description' => 'Madrasah Aliyah',
            ],
            [
                'code' => 'SMA',
                'name' => 'Sekolah menengah atas',
                'description' => 'Sekolah menengah atas',
            ],
            [
                'code' => 'SMK',
                'name' => 'Sekolah menengah kejuruan',
                'description' => 'Sekolah menengah kejuruan',
            ],
        ];

        // Insert levels untuk setiap sekolah
        foreach ($schoolInstitutionIds as $institutionId) {
            foreach ($levels as $level) {
                SchoolLevel::updateOrCreate([
                    'code' => $level['code'],
                ],[
                    'id' => Str::uuid(),
                    'school_institution_id' => $institutionId,
                    'name' => $level['name'],
                    'description' => $level['description'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
