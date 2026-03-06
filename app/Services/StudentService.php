<?php

namespace App\Services;

use App\Models\Student;

class StudentService
{
    /**
     * Get all students with filtering and pagination
     */
    public function all($filters = [], $limit = 10)
    {
        $query = Student::query()->with('person', 'schoolInstitution');

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->whereHas('person', function($q) use ($search) {
                $q->where('first_name', 'ILIKE', "%{$search}%")
                  ->orWhere('last_name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%");
            })->orWhere('student_id', 'ILIKE', "%{$search}%");
        }

        if (isset($filters['school_institution_id']) && $filters['school_institution_id']) {
            $query->where('school_institution_id', $filters['school_institution_id']);
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
     * Get student by id
     */
    public function getById($id)
    {
        return Student::with('person', 'schoolInstitution')->findOrFail($id);
    }

    /**
     * Create new student
     */
    public function create($data)
    {
        return Student::create($data);
    }

    /**
     * Update student
     */
    public function update($student, $data)
    {
        $student->update($data);
        return $student;
    }

    /**
     * Delete student
     */
    public function delete($student)
    {
        return $student->delete();
    }
}
