<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class MenuHelper
{

    /**
     * Get all menu items from config and filter by user role
     */
    public static function getAllMenus(): array
    {
        $menus = config('menu', []);
        $user = Auth::user();

        if (!$user) {
            return []; // jika belum login
        }

        // Filter menu sesuai permission
        $menus = array_filter($menus, function ($menu) use ($user) {
            // Jika section, biarkan tampil (agar struktur tidak rusak)
            if ($menu['type'] === 'section') {
                return true;
            }

            // Jika menu tidak punya permission, tampilkan semua
            if (!isset($menu['permission'])) {
                return true;
            }

            // Jika permission mengandung role user, tampilkan
            return in_array($user->role, $menu['permission']);
        });

        // Untuk dropdown, filter juga children-nya
        foreach ($menus as &$menu) {
            if (isset($menu['children'])) {
                $menu['children'] = array_filter($menu['children'], function ($child) use ($user) {
                    if (!isset($child['permission'])) {
                        return true;
                    }
                    return in_array($user->role, $child['permission']);
                });
            }
        }

        return array_values($menus);
    }

    /**
     * Get sections for vertical menu
     */
    public static function getVerticalMenuSections(): array
    {
        $menus = self::getAllMenus();
        $sections = [];
        $currentSection = 'DASHBOARD';
        $currentItems = [];

        foreach ($menus as $menu) {
            if ($menu['type'] === 'section') {
                if (!empty($currentItems)) {
                    $sections[] = [
                        'title' => $currentSection,
                        'items' => $currentItems,
                    ];
                }

                $currentSection = $menu['title'];
                $currentItems = [];
            } else {
                $currentItems[] = $menu;
            }
        }

        if (!empty($currentItems)) {
            $sections[] = [
                'title' => $currentSection,
                'items' => $currentItems,
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

        return array_filter($groups, fn($group) => !empty($group['items']));
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
     */
    public static function isActive(array $menu): bool
    {
        $currentRoute = request()->route()?->getName();

        if (isset($menu['active']) && $menu['active'] === true) {
            return true;
        }

        if (isset($menu['route']) && $menu['route'] !== '#') {
            if ($currentRoute === $menu['route']) {
                return true;
            }

            $routePrefix = explode('.', $menu['route']);
            $currentPrefix = explode('.', $currentRoute);

            if (count($routePrefix) >= 2 && count($currentPrefix) >= 2) {
                if ($routePrefix[0] === $currentPrefix[0] && $routePrefix[1] === $currentPrefix[1]) {
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
