<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get all users with pagination
     */
    public function getAll($page = 1, $perPage = 10, $search = null)
    {
        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Create new user
     */
    public function create(array $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }

        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    /**
     * Get user by id
     */
    public function getById($id)
    {
        return User::with('userRoles.role', 'userRoles.institution', 'userRoles.schoolLevel')->find($id);
    }

    /**
     * Update user
     */
    public function update($id, array $data)
    {
        $user = $this->getById($id);

        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }

        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        $user = $this->getById($id);
        return $user->delete();
    }

    /**
     * Assign role to user for specific application
     */
    public function assignRole($userId, $roleId, $applicationId, $institutionId = null, $schoolLevelId = null)
    {
        $user = $this->getById($userId);

        return $user->userRoles()->create([
            'role_id' => $roleId,
            'school_institution_id' => $institutionId,
            'school_level_id' => $schoolLevelId,
        ]);
    }

    /**
     * Remove role from user
     */
    public function removeRole($userId, $roleId)
    {
        return User::find($userId)->userRoles()
            ->where('role_id', $roleId)
            ->delete();
    }

    /**
     * Get user roles grouped by application
     */
    public function getUserRolesByApplication($userId)
    {
        $user = User::find($userId);
        $userRoles = $user->userRoles()->with('role', 'institution', 'schoolLevel')->get();

        $grouped = [];
        foreach ($userRoles as $userRole) {
            $appId = $userRole->role->application_id;
            if (!isset($grouped[$appId])) {
                $grouped[$appId] = [
                    'application' => $userRole->role->application,
                    'roles' => []
                ];
            }
            $grouped[$appId]['roles'][] = $userRole;
        }

        return $grouped;
    }
}
