<?php

namespace App\Services;

use App\Models\SchoolYear;
use App\DataTables\SchoolYearDataTable;
use Exception;

class SchoolYearService
{
    /**
     * Get DataTable data
     */
    public function getDataTable()
    {
        return new SchoolYearDataTable();
    }

    /**
     * Get all school years with optional filters
     */
    public function all($filters = [])
    {
        $query = SchoolYear::query();

        if (isset($filters['school_institution_id'])) {
            $query->where('school_institution_id', $filters['school_institution_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('name', 'asc')->get();
    }

    /**
     * Get school year by ID
     */
    public function find($id)
    {
        return SchoolYear::find($id);
    }

    /**
     * Get school year by ID or throw exception
     */
    public function findOrFail($id)
    {
        return SchoolYear::findOrFail($id);
    }

    public function filterBySchoolLevel($school_level_id) 
    {
        return SchoolYear::where('school_level_id', $school_level_id)->get();
    }

    /**
     * Create new school year
     */
    public function create(array $data)
    {
        // Handle checkbox yang tidak terkirim (unchecked) menjadi false
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        try {
            return SchoolYear::create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create school year: ' . $e->getMessage());
        }
    }

    /**
     * Update school year
     */
    public function update(SchoolYear $schoolYear, array $data)
    {
        try {
            $schoolYear->update($data);
            return $schoolYear;
        } catch (Exception $e) {
            throw new Exception('Failed to update school year: ' . $e->getMessage());
        }
    }

    /**
     * Delete school year
     */
    public function delete(SchoolYear $schoolYear)
    {
        try {
            return $schoolYear->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete school year: ' . $e->getMessage());
        }
    }

    /**
     * Get school years for a specific institution
     */
    public function getByInstitution($institutionId)
    {
        return SchoolYear::where('school_institution_id', $institutionId)
            ->orderBy('name', 'desc')
            ->get();
    }

    /**
     * Get active school years
     */
    public function getActive()
    {
        return SchoolYear::where('is_active', true)
            ->orderBy('name', 'desc')
            ->get();
    }

    /**
     * Get active school year for institution
     */
    public function getActiveByInstitution($institutionId)
    {
        return SchoolYear::where('school_institution_id', $institutionId)
            ->where('is_active', true)
            ->first();
    }
}
