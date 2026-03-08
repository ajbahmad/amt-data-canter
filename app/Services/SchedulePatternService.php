<?php

namespace App\Services;

use App\Models\SchedulePattern;
use App\Models\SchoolDaySchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchedulePatternService
{
    /**
     * Create a new schedule pattern with default school day schedules
     */
    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            // Create schedule pattern
            $schedulePattern = SchedulePattern::create([
                'id' => Str::uuid(),
                'school_institution_id' => $data['school_institution_id'],
                'school_level_id' => $data['school_level_id'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            // Create default school day schedules (Monday - Saturday)
            $this->createDefaultSchedules($schedulePattern);

            DB::commit();

            return $schedulePattern;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update schedule pattern
     */
    public function update(SchedulePattern $schedulePattern, array $data)
    {
        try {
            DB::beginTransaction();

            $schedulePattern->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            DB::commit();

            return $schedulePattern;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete schedule pattern
     */
    public function delete(SchedulePattern $schedulePattern)
    {
        try {
            DB::beginTransaction();

            $schedulePattern->delete();

            DB::commit();

            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create default school day schedules for Monday-Saturday
     * Friday is holiday by default
     */
    private function createDefaultSchedules(SchedulePattern $schedulePattern)
    {
        $defaultSchedules = [];

        // Monday to Saturday (0-5)
        for ($day = 0; $day < 6; $day++) {
            $isFriday = $day === 4;

            $defaultSchedules[] = [
                'id' => Str::uuid(),
                'schedule_pattern_id' => $schedulePattern->id,
                'school_institution_id' => $schedulePattern->school_institution_id,
                'school_level_id' => $schedulePattern->school_level_id,
                'day_of_week' => $day,
                'start_time' => $isFriday ? null : '07:00',
                'end_time' => $isFriday ? null : '11:15',
                'is_holiday' => $isFriday,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SchoolDaySchedule::insert($defaultSchedules);
    }

    /**
     * Update school day schedule
     */
    public function updateDaySchedule(SchoolDaySchedule $schedule, array $data)
    {
        try {
            DB::beginTransaction();

            $schedule->update([
                'start_time' => $data['start_time'] ?? null,
                'end_time' => $data['end_time'] ?? null,
                'is_holiday' => $data['is_holiday'] ?? false,
            ]);

            DB::commit();

            return $schedule;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
