<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\DataTables\ClassRoomDataTable;
use Exception;

class ClassRoomService
{
    /**
     * Get DataTable data
     */
    public function getDataTable()
    {
        return new ClassRoomDataTable();
    }

    /**
     * Get all class rooms with optional filters
     */
    public function all($filters = [])
    {
        $query = ClassRoom::query();

        if (isset($filters['school_institution_id'])) {
            $query->where('school_institution_id', $filters['school_institution_id']);
        }

        if (isset($filters['school_year_id'])) {
            $query->where('school_year_id', $filters['school_year_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('name', 'asc')->get();
    }

    /**
     * Get class room by ID
     */
    public function find($id)
    {
        return ClassRoom::find($id);
    }

    /**
     * Get class room by ID or throw exception
     */
    public function findOrFail($id)
    {
        return ClassRoom::findOrFail($id);
    }

    /**
     * Create new class room
     */
    public function create(array $data)
    {
        // Handle checkbox yang tidak terkirim (unchecked) menjadi false
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        try {
            return ClassRoom::create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create class room: ' . $e->getMessage());
        }
    }

    /**
     * Update class room
     */
    public function update(ClassRoom $classRoom, array $data)
    {
        try {
            // Handle checkbox yang tidak terkirim (unchecked) menjadi false
            if (!isset($data['is_active'])) {
                $data['is_active'] = false;
            }

            $classRoom->update($data);
            return $classRoom;
        } catch (Exception $e) {
            throw new Exception('Failed to update class room: ' . $e->getMessage());
        }
    }

    /**
     * Delete class room
     */
    public function delete(ClassRoom $classRoom)
    {
        try {
            return $classRoom->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete class room: ' . $e->getMessage());
        }
    }
}
