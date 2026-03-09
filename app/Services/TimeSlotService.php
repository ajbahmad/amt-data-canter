<?php

namespace App\Services;

use App\Models\TimeSlot;

class TimeSlotService
{
    public function all()
    {
        return TimeSlot::with('schoolInstitution', 'schoolLevel')->get();
    }

    public function getById($id)
    {
        return TimeSlot::with('schoolInstitution', 'schoolLevel')->findOrFail($id);
    }

    function filterBySchoolLevel($schoolLevelId)
    {
        return TimeSlot::where('is_active', true)->where('school_level_id', $schoolLevelId)->get();
    }

    public function create(array $data)
    {
        return TimeSlot::create($data);
    }

    public function update($id, array $data)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        $timeSlot->update($data);
        return $timeSlot;
    }

    public function delete($id)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        return $timeSlot->delete();
    }
}
