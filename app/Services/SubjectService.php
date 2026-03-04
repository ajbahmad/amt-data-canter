<?php

namespace App\Services;

use App\Models\Subject;
use App\DataTables\SubjectDataTable;
use Exception;

class SubjectService
{
    /**
     * Get DataTable data
     */
    public function getDataTable()
    {
        return new SubjectDataTable();
    }

    /**
     * Get all subjects with optional filters
     */
    public function all($filters = [])
    {
        $query = Subject::query();

        if (isset($filters['school_level_id'])) {
            $query->where('school_level_id', $filters['school_level_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('name', 'asc')->get();
    }

    /**
     * Get subject by ID
     */
    public function find($id)
    {
        return Subject::find($id);
    }

    /**
     * Get subject by ID or throw exception
     */
    public function findOrFail($id)
    {
        return Subject::findOrFail($id);
    }

    /**
     * Create new subject
     */
    public function create(array $data)
    {
        // Handle checkbox yang tidak terkirim (unchecked) menjadi false
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        try {
            return Subject::create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create subject: ' . $e->getMessage());
        }
    }

    /**
     * Update subject
     */
    public function update(Subject $subject, array $data)
    {
        try {
            // Handle checkbox yang tidak terkirim (unchecked) menjadi false
            if (!isset($data['is_active'])) {
                $data['is_active'] = false;
            }

            $subject->update($data);
            return $subject;
        } catch (Exception $e) {
            throw new Exception('Failed to update subject: ' . $e->getMessage());
        }
    }

    /**
     * Delete subject
     */
    public function delete(Subject $subject)
    {
        try {
            return $subject->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete subject: ' . $e->getMessage());
        }
    }
}
