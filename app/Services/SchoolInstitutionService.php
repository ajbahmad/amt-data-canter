<?php

namespace App\Services;

use App\Models\SchoolInstitution;
use Illuminate\Pagination\Paginator;

class SchoolInstitutionService
{
    /**
     * Get all school institutions with pagination
     */
    public function getAll($page = 1, $perPage = 10, $search = null)
    {
        $query = SchoolInstitution::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('npsn', 'like', "%{$search}%");
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Get all school institutions for DataTable
     */
    public function getDataTable()
    {
        return SchoolInstitution::all();
    }

    /**
     * Create new school institution
     */
    public function create(array $data)
    {
        // Handle checkbox yang tidak terkirim (unchecked) menjadi false
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        return SchoolInstitution::create($data);
    }

    /**
     * Get school institution by id
     */
    public function getById($id)
    {
        return SchoolInstitution::findOrFail($id);
    }

    /**
     * Update school institution
     */
    public function update($id, array $data)
    {
        // Handle checkbox yang tidak terkirim (unchecked) menjadi false
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }

        $schoolInstitution = SchoolInstitution::findOrFail($id);
        $schoolInstitution->update($data);
        return $schoolInstitution;
    }

    /**
     * Delete school institution
     */
    public function delete($id)
    {
        $schoolInstitution = SchoolInstitution::findOrFail($id);
        return $schoolInstitution->delete();
    }
}
