<?php

namespace Database\Seeders;

use App\Models\SchedulePattern;
use App\Models\SchoolDaySchedule;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SchedulePatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first active school institution and level
        $institution = SchoolInstitution::where('is_active', true)->first();
        $level = SchoolLevel::where('is_active', true)->first();

        if (!$institution || !$level) {
            $this->command->warn('Tidak ada institusi atau level sekolah yang aktif. Lewati seeder SchedulePattern.');
            return;
        }

        $patterns = [
            [
                'name' => 'Jam Belajar Normal',
                'description' => 'Pola jadwal belajar normal pada hari-hari biasa',
                'default_start_time' => '07:00',
                'default_end_time' => '11:15',
            ],
            [
                'name' => 'Jam Belajar Ramadhan',
                'description' => 'Pola jadwal belajar selama bulan Ramadhan',
                'default_start_time' => '08:00',
                'default_end_time' => '11:00',
            ],
            [
                'name' => 'Jam Belajar Ujian',
                'description' => 'Pola jadwal belajar selama periode ujian',
                'default_start_time' => '07:30',
                'default_end_time' => '12:00',
            ],
        ];

        foreach ($patterns as $patternData) {
            $schedulePattern = SchedulePattern::create([
                'id' => Str::uuid(),
                'school_institution_id' => $institution->id,
                'school_level_id' => $level->id,
                'name' => $patternData['name'],
                'description' => $patternData['description'],
            ]);

            // Create default school day schedules (Monday - Saturday)
            $schedules = [];
            for ($day = 0; $day <= 6; $day++) {
                $isFriday = $day === 4;

                $schedules[] = [
                    'id' => Str::uuid(),
                    'schedule_pattern_id' => $schedulePattern->id,
                    'school_institution_id' => $institution->id,
                    'school_level_id' => $level->id,
                    'day_of_week' => $day,
                    'start_time' => $isFriday ? null : $patternData['default_start_time'],
                    'end_time' => $isFriday ? null : $patternData['default_end_time'],
                    'is_holiday' => $isFriday,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            SchoolDaySchedule::insert($schedules);
        }

        $this->command->info('Schedule Patterns berhasil di-seed dengan ' . count($patterns) . ' data.');
    }
}