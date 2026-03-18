<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService
{
    /**
     * Get all permissions with pagination
     */
    public function getAll($page = 1, $perPage = 10, $search = null)
    {
        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        return $query->with('application')->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Create new permission
     */
    public function create(array $data)
    {
        if (!isset($data['is_system'])) {
            $data['is_system'] = false;
        }
        return Permission::create($data);
    }

    /**
     * Get permission by id
     */
    public function getById($id)
    {
        return Permission::find($id);
    }

    /**
     * Update permission
     */
    public function update($id, array $data)
    {
        $permission = $this->getById($id);
        if (!isset($data['is_system'])) {
            $data['is_system'] = false;
        }
        $permission->update($data);
        return $permission;
    }

    /**
     * Delete permission
     */
    public function delete($id)
    {
        $permission = $this->getById($id);
        return $permission->delete();
    }

    /**
     * Get permissions for application
     */
    public function getByApplication($applicationId)
    {
        return Permission::where('application_id', $applicationId)->get();
    }

    /**
     * Get permission by slug
     */
    public function getBySlug($slug)
    {
        return Permission::where('slug', $slug)->first();
    }
}
