<?php

namespace App\Services;

use App\Models\Staff;

class StaffService
{
    /**
     * Get all staff with filtering and pagination
     */
    public function all($filters = [], $limit = 10)
    {
        $query = Staff::query()->with('person', 'schoolInstitution');

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->whereHas('person', function($q) use ($search) {
                $q->where('first_name', 'ILIKE', "%{$search}%")
                  ->orWhere('last_name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%");
            })->orWhere('staff_id', 'ILIKE', "%{$search}%");
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
     * Get staff by id
     */
    public function getById($id)
    {
        return Staff::with('person', 'schoolInstitution')->findOrFail($id);
    }

    /**
     * Create new staff
     */
    public function create($data)
    {
        return Staff::create($data);
    }

    /**
     * Update staff
     */
    public function update($staff, $data)
    {
        $staff->update($data);
        return $staff;
    }

    /**
     * Delete staff
     */
    public function delete($staff)
    {
        return $staff->delete();
    }
}
