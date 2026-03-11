<?php

namespace App\Services;

use App\Models\PersonType;

class PersonTypeService
{
    /**
     * Get all person types with filtering and pagination
     */
    public function all($filters = [], $limit = 10)
    {
        $query = PersonType::query();

        if (isset($filters['search']) && $filters['search']) {
            $query->where('name', 'ILIKE', "%{$filters['search']}%")
                  ->orWhere('description', 'ILIKE', "%{$filters['search']}%");
        }

        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->orderBy('created_at', 'DESC')->paginate($limit);
    }

    /**
     * Get person type by id
     */
    public function getById($id)
    {
        return PersonType::findOrFail($id);
    }

    /**
     * Create new person type
     */
    public function create($data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        return PersonType::create($data);
    }

    /**
     * Update person type
     */
    public function update($personType, $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        $personType->update($data);
        return $personType;
    }

    /**
     * Delete person type
     */
    public function delete($personType)
    {
        return $personType->delete();
    }

    /**
     * Get person type with all relationships
     */
    public function withRelations($personType)
    {
        return $personType->load('memberships.person');
    }
}
