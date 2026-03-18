<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    /**
     * Get all roles with pagination
     */
    public function getAll($page = 1, $perPage = 10, $search = null)
    {
        $query = Role::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        return $query->with('application')->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Create new role
     */
    public function create(array $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        if (!isset($data['is_system'])) {
            $data['is_system'] = false;
        }
        return Role::create($data);
    }

    /**
     * Get role by id
     */
    public function getById($id)
    {
        return Role::find($id);
    }

    public function filter($applicationId){
        return Role::where('application_id', $applicationId)->get();
    }

    /**
     * Update role
     */
    public function update($id, array $data)
    {
        $role = $this->getById($id);
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        if (!isset($data['is_system'])) {
            $data['is_system'] = false;
        }
        $role->update($data);
        return $role;
    }

    /**
     * Delete role
     */
    public function delete($id)
    {
        $role = $this->getById($id);
        return $role->delete();
    }

    /**
     * Get roles for application
     */
    public function getByApplication($applicationId)
    {
        return Role::where('application_id', $applicationId)->get();
    }

    /**
     * Assign permissions to role
     */
    public function assignPermissions($roleId, array $permissionIds)
    {
        $role = $this->getById($roleId);
        return $role->permissions()->sync($permissionIds);
    }

    /**
     * Get role permissions
     */
    public function getPermissions($roleId)
    {
        $role = $this->getById($roleId);
        return $role->permissions;
    }
}
