<?php

namespace App\Services;

use App\Models\Calendar;
use App\Models\CalendarScope;
use Illuminate\Pagination\Paginator;

class CalendarService
{
    /**
     * Get all calendars with pagination
     */
    public function getAll(int $perPage = 15): Paginator
    {
        return Calendar::with('scopes')->paginate($perPage);
    }

    /**
     * Get calendar by ID
     */
    public function getById(string $id): Calendar
    {
        return Calendar::with('scopes')->findOrFail($id);
    }

    /**
     * Get calendar with scopes for editing
     */
    public function getForEdit(string $id): array
    {
        $calendar = $this->getById($id);

        return [
            'id' => $calendar->id,
            'title' => $calendar->title,
            'description' => $calendar->description,
            'start_date' => $calendar->start_date->format('Y-m-d'),
            'end_date' => $calendar->end_date ? $calendar->end_date->format('Y-m-d') : null,
            'type' => $calendar->type,
            'is_holiday' => $calendar->is_holiday,
            'color' => $calendar->color ?? '#3788d8',
            'school_institution_ids' => $calendar->scopes->pluck('school_institution_id')->filter()->values()->toArray(),
            'school_level_ids' => $calendar->scopes->pluck('school_level_id')->filter()->values()->toArray(),
            'class_room_ids' => $calendar->scopes->pluck('class_room_id')->filter()->values()->toArray(),
        ];
    }

    /**
     * Get calendar events for FullCalendar
     */
    public function getEvents(string $startDate = null, string $endDate = null): array
    {
        $query = Calendar::query();

        if ($startDate && $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                });
        }

        $calendars = $query->with('scopes')->get();

        return $calendars->map(function (Calendar $calendar) {
            return [
                'id' => $calendar->id,
                'title' => $calendar->title,
                'start' => $calendar->start_date->format('Y-m-d'),
                'end' => $calendar->end_date ? $calendar->end_date->addDay()->format('Y-m-d') : $calendar->start_date->addDay()->format('Y-m-d'),
                'color' => $calendar->color ?? '#3788d8',
                'extendedProps' => [
                    'description' => $calendar->description,
                    'type' => $calendar->type,
                    'is_holiday' => $calendar->is_holiday,
                    'school_institution_ids' => $calendar->scopes->pluck('school_institution_id')->filter()->values()->toArray(),
                    'school_level_ids' => $calendar->scopes->pluck('school_level_id')->filter()->values()->toArray(),
                    'class_room_ids' => $calendar->scopes->pluck('class_room_id')->filter()->values()->toArray(),
                ],
            ];
        })->toArray();
    }

    /**
     * Create calendar with scopes
     */
    public function create(array $data): Calendar
    {
        $isHoliday = $data['is_holiday'] ?? $data['type'] === 'holiday';

        $calendar = Calendar::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'type' => $data['type'],
            'is_holiday' => $isHoliday,
            'color' => $data['color'] ?? '#3788d8',
        ]);

        $this->createScopes($calendar, $data);

        return $calendar;
    }

    /**
     * Update calendar with scopes
     */
    public function update(Calendar $calendar, array $data): Calendar
    {
        $isHoliday = $data['is_holiday'] ?? $data['type'] === 'holiday';

        $calendar->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'type' => $data['type'],
            'is_holiday' => $isHoliday,
            'color' => $data['color'] ?? '#3788d8',
        ]);

        $calendar->scopes()->delete();
        $this->createScopes($calendar, $data);

        return $calendar;
    }

    /**
     * Delete calendar
     */
    public function delete(Calendar $calendar): bool
    {
        $calendar->scopes()->delete();
        return $calendar->delete();
    }

    /**
     * Create scopes for calendar
     */
    private function createScopes(Calendar $calendar, array $data): void
    {
        $institutionIds = $data['school_institution_ids'] ?? [];
        $levelIds = $data['school_level_ids'] ?? [];
        $classRoomIds = $data['class_room_ids'] ?? [];

        foreach ($institutionIds as $institutionId) {
            CalendarScope::create([
                'calendar_id' => $calendar->id,
                'school_institution_id' => $institutionId,
                'school_level_id' => null,
                'class_room_id' => null,
            ]);
        }

        foreach ($levelIds as $levelId) {
            CalendarScope::create([
                'calendar_id' => $calendar->id,
                'school_institution_id' => null,
                'school_level_id' => $levelId,
                'class_room_id' => null,
            ]);
        }

        foreach ($classRoomIds as $classRoomId) {
            CalendarScope::create([
                'calendar_id' => $calendar->id,
                'school_institution_id' => null,
                'school_level_id' => null,
                'class_room_id' => $classRoomId,
            ]);
        }
    }
}
