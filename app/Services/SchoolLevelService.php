<?php

namespace App\Services;

use App\Models\SchoolLevel;

class SchoolLevelService
{
    /**
     * Get all school levels with pagination
     */
    public function getAll($page = 1, $perPage = 10, $search = null)
    {
        $query = SchoolLevel::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Get all school levels for DataTable
     */
    public function getDataTable()
    {
        return SchoolLevel::all();
    }

    /**
     * Create new school level
     */
    public function create(array $data)
    {
        // Handle checkbox yang tidak terkirim (unchecked) menjadi false
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        return SchoolLevel::create($data);
    }

    /**
     * Get school level by id
     */
    public function getById($id)
    {
        return SchoolLevel::findOrFail($id);
    }

    public function filter($id){
        return SchoolLevel::where('school_institution_id', $id)->get();
    }

    /**
     * Update school level
     */
    public function update($id, array $data)
    {
        $schoolLevel = $this->getById($id);
        $schoolLevel->update($data);
        return $schoolLevel;
    }

    /**
     * Delete school level
     */
    public function delete($id)
    {
        $schoolLevel = $this->getById($id);
        return $schoolLevel->delete();
    }
}
