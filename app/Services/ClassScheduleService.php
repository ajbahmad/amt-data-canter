<?php

namespace App\Services;

use App\Models\ClassSchedule;
use Illuminate\Pagination\Paginator;

class ClassScheduleService
{
    /**
     * Get all schedules with eager loading
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return ClassSchedule::with([
            'schoolInstitution',
            'schoolLevel',
            'classRoom',
            'teacher',
            'teacher.person',
            'subject',
            'startTimeSlot',
            'endTimeSlot',
            'semester'
        ])->get();
    }

    /**
     * Get schedule by ID
     */
    public function getById($id): ?ClassSchedule
    {
        return ClassSchedule::with([
            'schoolInstitution',
            'schoolLevel',
            'classRoom',
            'teacher',
            'teacher.person',
            'subject',
            'startTimeSlot',
            'endTimeSlot',
            'semester'
        ])->find($id);
    }

    /**
     * Get schedules for a specific classroom and semester
     */
    public function getByClassRoomAndSemester($classRoomId, $semesterId): \Illuminate\Database\Eloquent\Collection
    {
        return ClassSchedule::with([
            'schoolInstitution',
            'schoolLevel',
            'classRoom',
            'teacher',
            'teacher.person',
            'subject',
            'startTimeSlot',
            'endTimeSlot',
            'semester'
        ])
        ->where('class_room_id', $classRoomId)
        ->where('semester_id', $semesterId)
        ->orderBy('day_of_week')
        ->orderByRaw('time_slots.start_time')
        ->get();
    }

    /**
     * Get schedules grouped by day for display
     */
    public function getSchedulesByDay($classRoomId, $semesterId): array
    {
        // If both are null, get all schedules
        if ($classRoomId === null && $semesterId === null) {
            $schedules = $this->getAll();
        } else {
            $schedules = $this->getByClassRoomAndSemester($classRoomId, $semesterId);
        }
        
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];

        $result = [];
        foreach ($days as $dayNum => $dayName) {
            $result[$dayNum] = [
                'name' => $dayName,
                'schedules' => $schedules->where('day_of_week', $dayNum)->values()
            ];
        }

        return $result;
    }

    /**
     * Create a new schedule
     */
    public function create(array $data): ClassSchedule
    {
        return ClassSchedule::create($data);
    }

    /**
     * Update a schedule
     */
    public function update($id, array $data): ClassSchedule
    {
        $schedule = $this->getById($id);
        $schedule->update($data);
        return $schedule;
    }

    /**
     * Delete a schedule
     */
    public function delete($id): bool
    {
        $schedule = ClassSchedule::find($id);
        return $schedule ? $schedule->delete() : false;
    }
}
