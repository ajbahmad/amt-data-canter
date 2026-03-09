<?php

namespace App\Services;

use App\Models\Grade;
use App\DataTables\GradeDataTable;
use Exception;

class GradeService
{
    /**
     * Get DataTable data
     */
    public function getDataTable()
    {
        return new GradeDataTable();
    }

    /**
     * Get all grades with optional filters
     */
    public function all($filters = [])
    {
        $query = Grade::query();

        if (isset($filters['school_level_id'])) {
            $query->where('school_level_id', $filters['school_level_id']);
        }

        return $query->orderBy('order_no', 'asc')->get();
    }

    /**
     * Get grade by ID
     */
    public function find($id)
    {
        return Grade::find($id);
    }

    /**
     * Get grade by ID or throw exception
     */
    public function findOrFail($id)
    {
        return Grade::findOrFail($id);
    }

    function filter($id) 
    {
        return Grade::where('school_level_id', $id)->get();
    }
    /**
     * Create new grade
     */
    public function create(array $data)
    {
        // Handle checkbox yang tidak terkirim (unchecked) menjadi false
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        try {
            return Grade::create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create grade: ' . $e->getMessage());
        }
    }

    /**
     * Update grade
     */
    public function update(Grade $grade, array $data)
    {
        try {
            // Handle checkbox yang tidak terkirim (unchecked) menjadi false
            if (!isset($data['is_active'])) {
                $data['is_active'] = false;
            }

            $grade->update($data);
            return $grade;
        } catch (Exception $e) {
            throw new Exception('Failed to update grade: ' . $e->getMessage());
        }
    }

    /**
     * Delete grade
     */
    public function delete(Grade $grade)
    {
        try {
            return $grade->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete grade: ' . $e->getMessage());
        }
    }
}
