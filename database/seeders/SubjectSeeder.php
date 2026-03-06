<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolLevels = SchoolLevel::all();

        $subjectsByLevel = [
            'MI' => [
                ['code' => 'MTK', 'name' => 'Matematika'], 
                ['code' => 'ARAB', 'name' => 'Bahasa Arab'], 
                ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam'], 
                ['code' => 'IPS', 'name' => 'Ilmu Pengetahuan Sosial'], 
                ['code' => 'INDO', 'name' => 'Bahasa Indonesia'], 
            ],
            'SD' => [
                ['code' => 'MTK', 'name' => 'Matematika'], 
                ['code' => 'INDO', 'name' => 'Bahasa Indonesia'], 
                ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam'], 
                ['code' => 'IPS', 'name' => 'Ilmu Pengetahuan Sosial'], 
                ['code' => 'ENG', 'name' => 'Bahasa Inggris'], 
            ],
            'Mts' => [
                ['code' => 'MTK', 'name' => 'Matematika'], 
                ['code' => 'ARAB', 'name' => 'Bahasa Arab'], 
                ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam'], 
                ['code' => 'BIOLOGI', 'name' => 'Biologi'], 
                ['code' => 'KIMIA', 'name' => 'Kimia'], 
                ['code' => 'FISIKA', 'name' => 'Fisika'], 
                ['code' => 'IPS', 'name' => 'Ilmu Pengetahuan Sosial'], 
                ['code' => 'INDO', 'name' => 'Bahasa Indonesia'], 
                ['code' => 'ENG', 'name' => 'Bahasa Inggris'], 
            ],
            'SMP' => [
                ['code' => 'MTK', 'name' => 'Matematika'], 
                ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam'], 
                ['code' => 'BIOLOGI', 'name' => 'Biologi'], 
                ['code' => 'KIMIA', 'name' => 'Kimia'], 
                ['code' => 'FISIKA', 'name' => 'Fisika'], 
                ['code' => 'IPS', 'name' => 'Ilmu Pengetahuan Sosial'], 
                ['code' => 'INDO', 'name' => 'Bahasa Indonesia'], 
                ['code' => 'ENG', 'name' => 'Bahasa Inggris'], 
            ],
            'MA' => [
                ['code' => 'MTK', 'name' => 'Matematika'], 
                ['code' => 'ARAB', 'name' => 'Bahasa Arab'], 
                ['code' => 'TAFSIR', 'name' => 'Tafsir'], 
                ['code' => 'HADIST', 'name' => 'Hadist'], 
                ['code' => 'FIQIH', 'name' => 'Fiqih'], 
                ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam'], 
                ['code' => 'IPS', 'name' => 'Ilmu Pengetahuan Sosial'], 
                ['code' => 'ENG', 'name' => 'Bahasa Inggris'], 
            ],
            'SMA' => [
                ['code' => 'MTK', 'name' => 'Matematika'], 
                ['code' => 'FISIKA', 'name' => 'Fisika'], 
                ['code' => 'KIMIA', 'name' => 'Kimia'], 
                ['code' => 'BIOLOGI', 'name' => 'Biologi'], 
                ['code' => 'INDO', 'name' => 'Bahasa Indonesia'], 
                ['code' => 'ENG', 'name' => 'Bahasa Inggris'], 
                ['code' => 'SEJARAH', 'name' => 'Sejarah'], 
                ['code' => 'GEOGRAFI', 'name' => 'Geografi'], 
            ],
            'SMK' => [
                ['code' => 'MTK', 'name' => 'Matematika'], 
                ['code' => 'INDO', 'name' => 'Bahasa Indonesia'], 
                ['code' => 'ENG', 'name' => 'Bahasa Inggris'], 
                ['code' => 'PKWU', 'name' => 'Prakarya dan Kewirausahaan'], 
                ['code' => 'TIK', 'name' => 'Teknologi Informasi dan Komunikasi'], 
                ['code' => 'ARAB', 'name' => 'Bahasa Arab'], 
                ['code' => 'TAFSIR', 'name' => 'Tafsir'], 
                ['code' => 'HADIST', 'name' => 'Hadist'], 
                ['code' => 'FIQIH', 'name' => 'Fiqih'], 
                ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam'], 
                ['code' => 'IPS', 'name' => 'Ilmu Pengetahuan Sosial'], 
            ],
        ];

        foreach ($schoolLevels as $schoolLevel) {
            $subjects = $subjectsByLevel[$schoolLevel->code] ?? [];
            
            foreach ($subjects as $subject) {
                Subject::updateOrCreate(
                    [
                        'code' => $subject['code'],
                        'school_level_id' => $schoolLevel->id,
                    ],
                    [
                        'school_institution_id' => $schoolLevel->school_institution_id,
                        'name' => $subject['name'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
