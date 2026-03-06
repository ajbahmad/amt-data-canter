<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class MenuHelper
{

    /**
     * Get all menu items from database and filter by user role
     */
    public static function getAllMenus(): array
    {
        $user = Auth::user();

        if (!$user) {
            return []; // jika belum login
        }

        // Get menus berdasarkan user role
        $roleCode = self::mapUserRoleToRoleCode($user->role);
        $menus = Menu::getMenuTreeForRole($roleCode)
            ->orderBy('order_no')
            ->get();

        $result = [];
        foreach ($menus as $menu) {
            $result[] = self::transformMenuForHelper($menu);
        }

        return $result;
    }

    /**
     * Transform menu dari model ke format untuk helper
     */
    private static function transformMenuForHelper(Menu $menu): array
    {
        $formatted = [
            'id' => $menu->id,
            'title' => $menu->title,
            'icon' => $menu->icon,
            'color' => $menu->color,
            'type' => $menu->type === 'dropdown' ? 'dropdown' : 'single',
            'route' => $menu->route,
            'url' => $menu->url,
            'active' => false,
        ];

        // Add children jika dropdown dan ada child
        if ($menu->type === 'dropdown' && $menu->children->isNotEmpty()) {
            $children = [];
            foreach ($menu->children as $child) {
                $children[] = self::transformMenuForHelper($child);
            }
            $formatted['children'] = $children;
        }

        return $formatted;
    }

    /**
     * Map user role ke role code untuk menu permissions
     */
    private static function mapUserRoleToRoleCode(?string $userRole): string
    {
        $roleMap = [
            'super_admin' => 'super-admin',
            'superadmin' => 'super-admin',
            'admin' => 'admin',
            'teacher' => 'teacher',
            'siswa' => 'student',
            'student' => 'student',
            'parent' => 'parent',
            'orang_tua' => 'parent',
            'staff' => 'staff',
        ];

        if (!$userRole) {
            return 'student';
        }

        $roleLower = strtolower(str_replace('-', '_', $userRole));
        return $roleMap[$roleLower] ?? 'student';
    }

    /**
     * Get sections for vertical menu
     */
    public static function getVerticalMenuSections(): array
    {
        $user = Auth::user();
        
        if (!$user) {
            return [];
        }

        // Get menus berdasarkan user role
        $roleCode = self::mapUserRoleToRoleCode($user->role);
        $rootMenus = Menu::roots()
            ->active()
            ->with('childrenRecursive')
            ->orderBy('order_no')
            ->get();

        $sections = [];
        $dashboardItems = [];
        $otherItems = [];

        foreach ($rootMenus as $menu) {
            $menuData = self::transformMenuForHelper($menu);

            // Pisahkan dashboard dari menu lainnya
            if (strtolower($menu->title) === 'dashboard') {
                $dashboardItems[] = $menuData;
            } else {
                $otherItems[] = $menuData;
            }
        }

        // Add dashboard section
        if (!empty($dashboardItems)) {
            $sections[] = [
                'title' => 'DASHBOARD',
                'items' => $dashboardItems,
            ];
        }

        // Add other sections
        if (!empty($otherItems)) {
            $sections[] = [
                'title' => 'MENU',
                'items' => $otherItems,
            ];
        }

        return $sections;
    }

    /**
     * Get grouped menus for horizontal menu
     */
    public static function getHorizontalMenuGroups(): array
    {
        $menus = self::getAllMenus();
        $groups = [];

        $groups['aplikasi'] = [
            'title' => 'Aplikasi',
            'icon' => 'solar:widget-line-duotone',
            'color' => 'primary',
            'items' => []
        ];

        $groups['akademik'] = [
            'title' => 'Akademik',
            'icon' => 'solar:book-bookmark-line-duotone',
            'color' => 'info',
            'items' => []
        ];

        $groups['master'] = [
            'title' => 'Master Data',
            'icon' => 'solar:database-line-duotone',
            'color' => 'success',
            'items' => []
        ];

        $groups['laporan'] = [
            'title' => 'Laporan & Lainnya',
            'icon' => 'solar:chart-2-line-duotone',
            'color' => 'warning',
            'items' => []
        ];

        $groups['pengaturan'] = [
            'title' => 'Pengaturan',
            'icon' => 'solar:settings-line-duotone',
            'color' => 'secondary',
            'items' => []
        ];

        foreach ($menus as $menu) {
            if ($menu['type'] === 'section') {
                continue;
            }

            $title = strtolower($menu['title']);

            if (str_contains($title, 'dashboard')) {
                continue;
            } elseif (str_contains($title, 'pendaftaran') || str_contains($title, 'kelas') || str_contains($title, 'jadwal')) {
                $groups['aplikasi']['items'][] = $menu;
            } elseif (str_contains($title, 'siswa') || str_contains($title, 'mentor') || str_contains($title, 'kehadiran') ||
                      str_contains($title, 'tes') || str_contains($title, 'batch') || str_contains($title, 'periode')) {
                $groups['akademik']['items'][] = $menu;
            } elseif (str_contains($title, 'biaya') || str_contains($title, 'studi') || str_contains($title, 'pekerjaan')) {
                $groups['master']['items'][] = $menu;
            } elseif (str_contains($title, 'profil') || str_contains($title, 'pengguna') || str_contains($title, 'pengaturan')) {
                $groups['pengaturan']['items'][] = $menu;
            } else {
                $groups['laporan']['items'][] = $menu;
            }
        }

        $filtered = [];
        foreach ($groups as $key => $group) {
            if (!empty($group['items'])) {
                $filtered[$key] = $group;
            }
        }

        return $filtered;
    }

    /**
     * Generate color class for menu item
     */
    public static function getColorClass(string $color, string $type = 'background'): string
    {
        $prefix = $type === 'background' ? 'before:bg-light' : 'hover:text-';
        return $prefix . $color;
    }

    /**
     * Check if menu item is active
     * Supports: index, create, store, show, edit, update, destroy routes
     */
    public static function isActive(array $menu): bool
    {
        $route = request()->route();
        $currentRoute = $route ? $route->getName() : null;

        if (isset($menu['active']) && $menu['active'] === true) {
            return true;
        }

        if (isset($menu['route']) && $menu['route'] !== '#') {
            // Exact match
            if ($currentRoute === $menu['route']) {
                return true;
            }

            // Extract the resource name from both routes
            // school-institutions.index, school-institutions.create, etc. -> school-institutions
            $routeParts = explode('.', $menu['route']);
            $currentParts = explode('.', $currentRoute ?? '');

            if (!empty($routeParts) && !empty($currentParts)) {
                // Get the first part (resource name)
                $menuResource = $routeParts[0];
                $currentResource = $currentParts[0];

                // If resource names match, menu is active
                if ($menuResource === $currentResource) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if menu dropdown has any active children
     */
    public static function hasActiveChild(array $menu): bool
    {
        if (!isset($menu['children']) || !is_array($menu['children'])) {
            return false;
        }

        foreach ($menu['children'] as $child) {
            if (self::isActive($child)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get route URL
     */
    public static function getRouteUrl(string $route): string
    {
        if ($route === '#') {
            return '#';
        }

        try {
            return route($route);
        } catch (\Exception $e) {
            return '#';
        }
    }
}
