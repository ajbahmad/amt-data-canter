<?php

namespace App\Services;

use App\Models\User;
use App\Models\Application;
use App\Models\Menu;
use App\Models\SchoolLevel;
use Illuminate\Support\Collection;

class MenuService
{
    public function __construct(private RbacService $rbacService)
    {}

    /**
     * Get menu tree for user in specific application
     */
    public function getMenusForUser(
        User $user,
        $application,
        SchoolLevel $schoolLevel = null
    ): Collection {
        $appId = $application instanceof Application ? $application->id : $application;

        // Get all root menus for application
        $menus = Menu::where('application_id', $appId)
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('order_no')
            ->with('children', 'children.children', 'roles')
            ->get();

        // Filter menus based on user roles
        return $this->filterMenusByRole($menus, $user, $schoolLevel);
    }

    /**
     * Filter menu tree by user roles
     */
    private function filterMenusByRole(
        Collection $menus,
        User $user,
        SchoolLevel $schoolLevel = null
    ): Collection {
        return $menus->map(function ($menu) use ($user, $schoolLevel) {
            // Check if user can view this menu
            $canView = $this->rbacService->userCanPerformMenuAction(
                $user,
                $menu->id,
                'view',
                $schoolLevel
            );

            if (!$canView) {
                return null;
            }

            // Filter children recursively
            if ($menu->children && $menu->children->isNotEmpty()) {
                $menu->children = $this->filterMenusByRole(
                    $menu->children,
                    $user,
                    $schoolLevel
                )->filter();
            }

            // Add action permissions
            $menu->actions = $this->getMenuActions($menu, $user, $schoolLevel);

            return $menu;
        })->filter();
    }

    /**
     * Get user's menu actions (create, edit, delete, etc.)
     */
    private function getMenuActions(Menu $menu, User $user, SchoolLevel $schoolLevel = null): array
    {
        return [
            'can_view' => $this->rbacService->userCanPerformMenuAction(
                $user,
                $menu->id,
                'view',
                $schoolLevel
            ),
            'can_create' => $this->rbacService->userCanPerformMenuAction(
                $user,
                $menu->id,
                'create',
                $schoolLevel
            ),
            'can_edit' => $this->rbacService->userCanPerformMenuAction(
                $user,
                $menu->id,
                'edit',
                $schoolLevel
            ),
            'can_delete' => $this->rbacService->userCanPerformMenuAction(
                $user,
                $menu->id,
                'delete',
                $schoolLevel
            ),
            'can_export' => $this->rbacService->userCanPerformMenuAction(
                $user,
                $menu->id,
                'export',
                $schoolLevel
            ),
            'can_import' => $this->rbacService->userCanPerformMenuAction(
                $user,
                $menu->id,
                'import',
                $schoolLevel
            ),
        ];
    }

    /**
     * Get flattened list of accessible menus
     */
    public function getAccessibleMenus(
        User $user,
        $application
    ): Collection {
        $appId = $application instanceof Application ? $application->id : $application;

        return Menu::where('application_id', $appId)
            ->where('is_active', true)
            ->whereHas('roles', function ($query) use ($user) {
                $query->whereIn('role_id', $user->roles()->pluck('id'));
            })
            ->orderBy('order_no')
            ->get();
    }

    /**
     * Get menu breadcrumb (parent hierarchy)
     */
    public function getMenuBreadcrumb(Menu $menu): Collection
    {
        $breadcrumb = collect([$menu]);

        $current = $menu;
        while ($current->parent_id) {
            $parent = $current->parent;
            $breadcrumb->prepend($parent);
            $current = $parent;
        }

        return $breadcrumb;
    }
}
