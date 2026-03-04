<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class MenuBuilderHelper
{
    /**
     * Get menus for authenticated user
     */
    public static function getMenusForUser()
    {
        if (!Auth::check()) {
            return collect([]);
        }

        $user = Auth::user();
        
        if (!$user->role) {
            return collect([]);
        }

        // Get role menus
        return Menu::mainMenus()
            ->with('children')
            ->whereHas('roles', function ($query) {
                $query->where('role_id', Auth::user()->role_id);
            })
            ->get();
    }

    /**
     * Get all menus for a role
     */
    public static function getMenusForRole($roleId)
    {
        return Menu::mainMenus()
            ->with('children')
            ->whereHas('roles', function ($query) use ($roleId) {
                $query->where('role_id', $roleId);
            })
            ->get();
    }

    /**
     * Render sidebar menu HTML
     */
    public static function renderSidebar()
    {
        $menus = self::getMenusForUser();

        if ($menus->isEmpty()) {
            return '<p class="text-muted small p-3">Tidak ada menu tersedia</p>';
        }

        $html = '';
        foreach ($menus as $menu) {
            $html .= self::renderMenuItem($menu);
        }

        return $html;
    }

    /**
     * Render single menu item
     */
    private static function renderMenuItem($menu, $isSubmenu = false)
    {
        $active = request()->routeIs($menu->route);
        $hasChildren = $menu->children->count() > 0;
        $activeClass = $active ? 'active' : '';
        $expandClass = $hasChildren ? 'has-children' : '';

        $html = '<li class="nav-item ' . $expandClass . ' ' . $activeClass . '">';

        if ($hasChildren) {
            $html .= '
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#menu-' . $menu->id . '" 
                   aria-expanded="' . ($active ? 'true' : 'false') . '" aria-controls="menu-' . $menu->id . '">
                    <i class="' . $menu->icon . ' me-2"></i>
                    <span>' . $menu->label . '</span>
                    <i class="fas fa-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse ' . ($active ? 'show' : '') . '" id="menu-' . $menu->id . '">
                    <ul class="nav nav-sm flex-column">';

            foreach ($menu->children as $child) {
                $childActive = request()->routeIs($child->route);
                $childActiveClass = $childActive ? 'active' : '';
                $html .= '
                        <li class="nav-item">
                            <a class="nav-link ' . $childActiveClass . '" href="' . ($child->route ? route($child->route) : '#') . '">
                                <i class="' . $child->icon . ' me-2"></i>
                                <span>' . $child->label . '</span>
                            </a>
                        </li>';
            }

            $html .= '
                    </ul>
                </div>';
        } else {
            $html .= '
                <a class="nav-link ' . $activeClass . '" href="' . ($menu->route ? route($menu->route) : '#') . '">
                    <i class="' . $menu->icon . ' me-2"></i>
                    <span>' . $menu->label . '</span>
                </a>';
        }

        $html .= '</li>';

        return $html;
    }

    /**
     * Check if user can access menu
     */
    public static function canAccessMenu($menuId)
    {
        if (!Auth::check()) {
            return false;
        }

        return Menu::find($menuId)
            ->roles()
            ->where('role_id', Auth::user()->role_id)
            ->exists();
    }
}
