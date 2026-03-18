<?php

namespace App\Services;

use App\Models\User;
use App\Models\Application;
use App\Models\Role;
use App\Models\Menu;
use App\Models\SchoolLevel;
use Illuminate\Support\Collection;

class RbacService
{
    /**
     * Check if user has access to a menu
     */
    public function userCanAccessMenu(User $user, Menu $menu): bool
    {
        // Get user's roles
        $userRoles = $user->roles()->pluck('id')->toArray();

        if (empty($userRoles)) {
            return false;
        }

        // Check if any of user's roles have permission to this menu
        return Menu::find($menu->id)
            ->permissions()
            ->whereIn('role_id', $userRoles)
            ->where('can_view', true)
            ->exists();
    }

    /**
     * Check if user can perform action on menu
     */
    public function userCanPerformAction(User $user, Menu $menu, string $action = 'view'): bool
    {
        $userRoles = $user->roles()->pluck('id')->toArray();

        if (empty($userRoles)) {
            return false;
        }

        $menuPermissions = Menu::find($menu->id)
            ->permissions()
            ->whereIn('role_id', $userRoles)
            ->first();

        if (!$menuPermissions) {
            return false;
        }

        switch($action) {
            case 'view':
                return $menuPermissions->can_view;
            case 'create':
                return $menuPermissions->can_create;
            case 'edit':
                return $menuPermissions->can_edit;
            case 'delete':
                return $menuPermissions->can_delete;
            case 'export':
                return $menuPermissions->can_export ?? false;
            case 'import':
                return $menuPermissions->can_import ?? false;
            default:
                return false;
        }
    }

    /**
     * Get all accessible menus for user
     */
    public function getUserAccessibleMenus(User $user): Collection
    {
        $userRoles = $user->roles()->pluck('id')->toArray();

        if (empty($userRoles)) {
            return collect();
        }

        return Menu::whereHas('permissions', function ($query) use ($userRoles) {
            $query->whereIn('role_id', $userRoles)
                  ->where('can_view', true);
        })
        ->where('is_sidebar_menu', true)
        ->where('is_active', true)
        ->orderBy('order_no')
        ->get();
    }

    /**
     * Get menu tree with user access (for sidebar)
     */
    public function getMenuTreeForUser(User $user): Collection
    {
        $userRoles = $user->roles()->pluck('id')->toArray();

        if (empty($userRoles)) {
            return collect();
        }

        // Get all accessible menus
        $menus = Menu::whereHas('permissions', function ($query) use ($userRoles) {
            $query->whereIn('role_id', $userRoles)
                  ->where('can_view', true);
        })
        ->where('is_sidebar_menu', true)
        ->where('is_active', true)
        ->orderBy('order_no')
        ->get()
        ->groupBy('parent_id');

        // Build tree structure
        return $this->buildMenuTree($menus, null);
    }

    /**
     * Build hierarchical menu tree
     */
    private function buildMenuTree(array $menus, ?string $parentId = null): Collection
    {
        $tree = collect();

        if (!isset($menus[$parentId])) {
            return $tree;
        }

        foreach ($menus[$parentId] as $menu) {
            $menu->children = $this->buildMenuTree($menus, $menu->id);
            $tree->push($menu);
        }

        return $tree;
    }

    /**
     * Check if user has role
     */
    public function userHasRole(User $user, string $roleSlug, ?Application $application = null): bool
    {
        $query = $user->roles()->where('slug', $roleSlug);

        if ($application) {
            $query->where('application_id', $application->id);
        }

        return $query->exists();
    }

    /**
     * Check if user has any of the roles
     */
    public function userHasAnyRole(User $user, array $roleSlugs, ?Application $application = null): bool
    {
        $query = $user->roles()->whereIn('slug', $roleSlugs);

        if ($application) {
            $query->where('application_id', $application->id);
        }

        return $query->exists();
    }

    /**
     * Check if user is super admin (global admin role)
     */
    public function isSuperAdmin(User $user): bool
    {
        return $user->roles()
            ->where('scope', 'global')
            ->where('is_system', true)
            ->exists();
    }

    /**
     * Get user permission level for application
     */
    public function getUserPermissionLevel(User $user, Application $application): ?int
    {
        return $user->roles()
            ->where('application_id', $application->id)
            ->max('priority');
    }

    /**
     * Check if user can access school level
     */
    public function userCanAccessSchoolLevel(User $user, SchoolLevel $schoolLevel): bool
    {
        $userRoles = $user->roles()->get();

        foreach ($userRoles as $role) {
            if ($this->checkRoleScope($role, $schoolLevel)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check role scope compatibility with school level
     */
    private function checkRoleScope(Role $role, ?SchoolLevel $schoolLevel = null): bool
    {
        switch($role->scope) {
            case 'global':
                return true;
            case 'institution':
                return !$schoolLevel || $schoolLevel->school_institution_id === $role->school_institution_id;
            case 'school':
                return $schoolLevel && $schoolLevel->id === $role->school_level_id;
            default:
                return false;
        }
    }

    /**
     * Get user accessible school levels
     */
    public function getUserAccessibleSchoolLevels(User $user): Collection
    {
        $userRoles = $user->roles()->get();
        $schoolLevels = collect();

        foreach ($userRoles as $role) {
            if ($role->scope === 'global') {
                // Global role: can access all school levels
                return SchoolLevel::all();
            } elseif ($role->scope === 'institution' && $role->school_institution_id) {
                // Institution role: can access school levels in this institution
                SchoolLevel::where('school_institution_id', $role->school_institution_id)
                    ->each(function ($level) use ($schoolLevels) {
                        $schoolLevels->push($level);
                    });
            } elseif ($role->scope === 'school' && $role->school_level_id) {
                // School role: can access only this school level
                $schoolLevels->push(SchoolLevel::find($role->school_level_id));
            }
        }

        return $schoolLevels->unique('id');
    }
}
