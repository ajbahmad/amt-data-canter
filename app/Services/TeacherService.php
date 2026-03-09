<?php

namespace App\Services;

use App\Models\Teacher;

class TeacherService
{
    /**
     * Get all teachers with filtering and pagination
     */
    public function all($filters = [], $limit = 10)
    {
        $query = Teacher::query()->with('person', 'schoolInstitution');

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->whereHas('person', function($q) use ($search) {
                $q->where('first_name', 'ILIKE', "%{$search}%")
                  ->orWhere('last_name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%");
            })->orWhere('teacher_id', 'ILIKE', "%{$search}%");
        }

        if (isset($filters['school_institution_id']) && $filters['school_institution_id']) {
            $query->where('school_institution_id', $filters['school_institution_id']);
        }

        if (isset($filters['employment_type']) && $filters['employment_type']) {
            $query->where('employment_type', $filters['employment_type']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('created_at', 'DESC')->paginate($limit);
    }

    /**
     * Get teacher by id
     */
    public function getById($id)
    {
        return Teacher::with('person', 'schoolInstitution')->findOrFail($id);
    }

    public function filterBySchoolInstitution($schoolInstitutionId)
    {
        return Teacher::where('school_institution_id', $schoolInstitutionId)->with('person')->get();
    }

    /**
     * Create new teacher
     */
    public function create($data)
    {
        return Teacher::create($data);
    }

    /**
     * Update teacher
     */
    public function update($teacher, $data)
    {
        $teacher->update($data);
        return $teacher;
    }

    /**
     * Delete teacher
     */
    public function delete($teacher)
    {
        return $teacher->delete();
    }
}
