<?php

namespace App\Services;

use App\Models\Semester;
use App\DataTables\SemesterDataTable;
use Exception;

class SemesterService
{
    /**
     * Get DataTable data
     */
    public function getDataTable()
    {
        return new SemesterDataTable();
    }

    /**
     * Get all semesters with optional filters
     */
    public function all($filters = [])
    {
        $query = Semester::query();

        if (isset($filters['school_year_id'])) {
            $query->where('school_year_id', $filters['school_year_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('name', 'asc')->get();
    }

    /**
     * Get semester by ID
     */
    public function find($id)
    {
        return Semester::find($id);
    }

    /**
     * Get semester by ID or throw exception
     */
    public function findOrFail($id)
    {
        return Semester::findOrFail($id);
    }

    public function filterBySchoolLevel($schoolLevelId)
    {
        return Semester::whereHas('schoolYear', function ($query) use ($schoolLevelId) {
            $query->where('school_level_id', $schoolLevelId);
        })->where('is_active', true)->get();
    }

    /**
     * Create new semester
     */
    public function create(array $data)
    {
        // Handle checkbox yang tidak terkirim (unchecked) menjadi false
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        try {
            return Semester::create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create semester: ' . $e->getMessage());
        }
    }

    /**
     * Update semester
     */
    public function update(Semester $semester, array $data)
    {
        try {
            // Handle checkbox yang tidak terkirim (unchecked) menjadi false
            if (!isset($data['is_active'])) {
                $data['is_active'] = false;
            }

            $semester->update($data);
            return $semester;
        } catch (Exception $e) {
            throw new Exception('Failed to update semester: ' . $e->getMessage());
        }
    }

    /**
     * Delete semester
     */
    public function delete(Semester $semester)
    {
        try {
            return $semester->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete semester: ' . $e->getMessage());
        }
    }
}
