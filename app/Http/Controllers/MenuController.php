<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use App\Models\MenuPermission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    /**
     * Menampilkan list menu dengan hierarchy dan filter
     */
    public function index(Request $request): View
    {
        // Get aplikasi dan role untuk filter
        $applications = \App\Models\Application::all();
        $roles = \App\Models\Role::all();

        // Filter aplikasi dan role
        $applicationId = $request->get('application_id');
        $roleId = $request->get('role_id');

        // Base query
        $query = Menu::roots()->active()->with('childrenRecursiveAll');

        // Terapkan filter
        if ($applicationId) {
            $roles = $roles->where('application_id', $applicationId);
            $query->where(function ($q) use ($applicationId) {
                $q->where('is_global', true)
                  ->orWhere('application_id', $applicationId);
            });
        }

        // Get menus dengan permissions
        $menus = $query->orderBy('order_no')->get();

        // Load menu_permissions jika ada role filter
        if ($roleId) {
            $menus->each(function ($menu) use ($roleId) {
                $menu->permissions = $menu->permissions()
                    ->where('role_id', $roleId)
                    ->get();
            });
        }
        return view('pages.menus.index', compact('menus', 'applications', 'roles', 'applicationId', 'roleId'));
    }

    /**
     * Simpan perubahan permissions untuk menu dan role
     */
    public function updatePermissions(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'permissions' => 'required|array',
                'permissions.*.menu_id' => 'required|uuid|exists:menus,id',
                'permissions.*.role_id' => 'required|uuid|exists:roles,id',
                'permissions.*.can_view' => 'boolean',
                'permissions.*.can_create' => 'boolean',
                'permissions.*.can_edit' => 'boolean',
                'permissions.*.can_delete' => 'boolean',
            ]);
            $role = \App\Models\Role::find($data['permissions'][0]['role_id'] ?? null)->toArray();

            foreach ($data['permissions'] as $permission) {
                MenuPermission::updateOrCreate(
                    [
                        'menu_id' => $permission['menu_id'],
                        'role_id' => $permission['role_id'],
                    ],
                    [
                        'role_code' => $role['slug'] ?? 'unknown',
                        'can_view' => $permission['can_view'] ?? false,
                        'can_create' => $permission['can_create'] ?? false,
                        'can_edit' => $permission['can_edit'] ?? false,
                        'can_delete' => $permission['can_delete'] ?? false,
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Permissions berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan permissions: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Form create menu baru
     */
    public function create(): View
    {
        // Get parent menu candidates (hanya dropdown dan items tanpa parent)
        $parentMenus = Menu::where(function ($query) {
            $query->where('type', 'dropdown')
                  ->orWhereNull('parent_id');
        })
        ->active()
        ->orderBy('order_no')
        ->pluck('title', 'id');

        // Daftar role untuk permission
        $availableRoles = [
            'super-admin' => 'Super Admin',
            'admin' => 'Admin',
            'teacher' => 'Guru',
            'student' => 'Siswa',
            'parent' => 'Orang Tua',
            'staff' => 'Staff',
        ];

        return view('pages.menus.create', compact('parentMenus', 'availableRoles'));
    }

    /**
     * Store menu baru
     */
    public function store(StoreMenuRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Create menu
        $menu = Menu::create($data);

        // Create permissions jika ada
        if ($request->has('permissions')) {
            $permissions = [];
            foreach ($request->input('permissions') as $permission) {
                if (!empty($permission['role_code'])) {
                    $permissions[] = [
                        'menu_id' => $menu->id,
                        'role_code' => $permission['role_code'],
                        'can_view' => $permission['can_view'] ?? true,
                        'can_create' => $permission['can_create'] ?? false,
                        'can_edit' => $permission['can_edit'] ?? false,
                        'can_delete' => $permission['can_delete'] ?? false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($permissions)) {
                MenuPermission::insert($permissions);
            }
        }

        return redirect()
            ->route('menus.index')
            ->with('success', "Menu '{$menu->title}' berhasil dibuat");
    }

    /**
     * Form edit menu
     */
    public function edit(Menu $menu): View
    {
        // Get parent menu candidates
        $parentMenus = Menu::where(function ($query) use ($menu) {
            $query->where('type', 'dropdown')
                  ->orWhereNull('parent_id');
        })
        ->where('id', '!=', $menu->id) // Exclude menu itu sendiri
        ->active()
        ->orderBy('order_no')
        ->pluck('title', 'id');

        // Daftar role
        $availableRoles = [
            'super-admin' => 'Super Admin',
            'admin' => 'Admin',
            'teacher' => 'Guru',
            'student' => 'Siswa',
            'parent' => 'Orang Tua',
            'staff' => 'Staff',
        ];

        // Get existing permissions
        $permissions = $menu->permissions()->get();

        return view('pages.menus.edit', compact('menu', 'parentMenus', 'availableRoles', 'permissions'));
    }

    /**
     * Update menu
     */
    public function update(UpdateMenuRequest $request, Menu $menu): RedirectResponse
    {
        $data = $request->validated();

        // Update menu
        $menu->update($data);

        // Update permissions
        // Hapus existing permissions
        $menu->permissions()->delete();

        // Create new permissions jika ada
        if ($request->has('permissions')) {
            $permissions = [];
            foreach ($request->input('permissions') as $permission) {
                if (!empty($permission['role_code'])) {
                    $permissions[] = [
                        'menu_id' => $menu->id,
                        'role_code' => $permission['role_code'],
                        'can_view' => $permission['can_view'] ?? true,
                        'can_create' => $permission['can_create'] ?? false,
                        'can_edit' => $permission['can_edit'] ?? false,
                        'can_delete' => $permission['can_delete'] ?? false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($permissions)) {
                MenuPermission::insert($permissions);
            }
        }

        return redirect()
            ->route('menus.index')
            ->with('success', "Menu '{$menu->title}' berhasil diupdate");
    }

    /**
     * Delete menu
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        // Check apakah menu punya children
        if ($menu->children()->exists()) {
            return redirect()
                ->route('menus.index')
                ->with('error', "Menu '{$menu->title}' tidak bisa dihapus karena memiliki submenu");
        }

        $title = $menu->title;
        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with('success', "Menu '{$title}' berhasil dihapus");
    }

    /**
     * Get menu tree untuk dropdown selection (JSON)
     * Used untuk form parent_id selection
     */
    public function getMenuTree(): JsonResponse
    {
        $menus = Menu::roots()
            ->active()
            ->with('childrenRecursive')
            ->orderBy('order_no')
            ->get()
            ->map(fn ($menu) => $this->formatMenuForTree($menu))
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => $menus,
        ]);
    }

    /**
     * Get menu structure untuk frontend sidebar (JSON)
     * Support role filtering
     */
    public function getMenuStructure(Request $request): JsonResponse
    {
        $roleCode = $request->input('role', 'super-admin');

        $menus = Menu::getMenuTreeForRole($roleCode)
            ->map(fn ($menu) => $this->formatMenuForFrontend($menu))
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => $menus,
        ]);
    }

    /**
     * Reorder menu (drag-drop)
     */
    public function reorder(Request $request): JsonResponse
    {
        try {
            $items = $request->input('items', []);

            foreach ($items as $item) {
                Menu::where('id', $item['id'])
                    ->update([
                        'parent_id' => $item['parent_id'] ?? null,
                        'order_no' => $item['order_no'] ?? 0,
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diurutkan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate urutan menu: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Format menu untuk tree structure (form selection)
     */
    private function formatMenuForTree($menu): array
    {
        return [
            'id' => $menu->id,
            'text' => $menu->title,
            'type' => $menu->type,
            'children' => $menu->children
                ->map(fn ($child) => $this->formatMenuForTree($child))
                ->toArray(),
        ];
    }

    /**
     * Format menu untuk frontend sidebar
     */
    private function formatMenuForFrontend($menu): array
    {
        $formatted = [
            'id' => $menu->id,
            'title' => $menu->title,
            'icon' => $menu->icon,
            'color' => $menu->color,
            'type' => $menu->type,
        ];

        // Add route atau url
        if ($menu->type === 'item') {
            if ($menu->route) {
                $formatted['route'] = $menu->route;
                $formatted['url'] = route($menu->route);
            } else {
                $formatted['url'] = $menu->url;
            }
        }

        // Add badge jika ada
        if ($menu->badge) {
            $formatted['badge'] = [
                'text' => $menu->badge,
                'color' => $menu->badge_color ?? 'blue',
            ];
        }

        // Add children jika dropdown
        if ($menu->children->isNotEmpty()) {
            $formatted['children'] = $menu->children
                ->map(fn ($child) => $this->formatMenuForFrontend($child))
                ->toArray();
        }

        return $formatted;
    }
}
