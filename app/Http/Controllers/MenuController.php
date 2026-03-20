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
    public function index(Request $request)
    {
        // Get aplikasi dan role untuk filter
        $applications = \App\Models\Application::all();
        $roles = \App\Models\Role::all();

        // Filter aplikasi dan role
        $applicationId = $request->get('application_id');
        $roleId = $request->get('role_id');

        // Base query - jangan load childrenRecursiveAll dulu
        $query = Menu::roots()->active();

        // Terapkan filter
        if ($applicationId) {
            $roles = $roles->where('application_id', $applicationId);
            $query->where(function ($q) use ($applicationId) {
                $q->where('is_global', true)
                  ->orWhere('application_id', $applicationId);
            });
        }

        // Get menus
        $menus = $query->orderBy('order_no')->get();

        // Jika ada role filter, build tree dengan filtered permissions
        if ($roleId) {
            $menus = $menus->map(function ($menu) use ($roleId) {
                return $this->buildMenuTreeWithFilter($menu, $roleId);
            })->filter();
        } else {
            // Jika tidak ada role filter, load dengan semua permissions
            $menus = $menus->map(function ($menu) {
                return $this->loadMenuTreeFull($menu);
            });
        }

        // return $menus;
        return view('pages.menus.index', compact('menus', 'applications', 'roles', 'applicationId', 'roleId'));
    }

    /**
     * Build menu tree dan filter permissions by specific role_id
     */
    private function buildMenuTreeWithFilter($menu, $roleId)
    {
        // Query permissions spesifik untuk role ini
        $permissions = \App\Models\MenuPermission::where('menu_id', $menu->id)
            ->where('role_id', $roleId)
            ->get();

        // Jika tidak ada permission record, buat default dengan semua false
        if ($permissions->isEmpty()) {
            $permissions = collect([
                (object)[
                    'id' => null,
                    'menu_id' => $menu->id,
                    'role_id' => $roleId,
                    'role_code' => null,
                    'can_view' => false,
                    'can_create' => false,
                    'can_edit' => false,
                    'can_delete' => false,
                ]
            ]);
        }

        $menu->permissions = $permissions;

        // Load children dan recursively filter
        $children = $menu->childrenAll()->get();
        
        if ($children->isNotEmpty()) {
            $filteredChildren = $children
                ->map(function ($child) use ($roleId) {
                    return $this->buildMenuTreeWithFilter($child, $roleId);
                })
                ->filter(function ($child) {
                    // Handle null values - skip if child is null
                    if ($child === null) {
                        return false;
                    }
                    // Always keep child - even if no permissions (default false)
                    return true;
                })
                ->values();
            
            $menu->childrenRecursiveAll = $filteredChildren;
        } else {
            $menu->childrenRecursiveAll = collect();
        }

        // Always return menu - even if no permissions
        return $menu;
    }

    /**
     * Load menu tree dengan semua permissions (tanpa filter)
     */
    private function loadMenuTreeFull($menu)
    {
        $menu->load(['childrenRecursiveAll', 'permissions']);
        return $menu;
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
            ->with(['childrenRecursive', 'permissions'])
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
            'permissions' => $menu->permissions->map(fn ($p) => [
                'id' => $p->id,
                'role_id' => $p->role_id,
                'role_code' => $p->role_code,
                'can_view' => $p->can_view,
                'can_create' => $p->can_create,
                'can_edit' => $p->can_edit,
                'can_delete' => $p->can_delete,
            ])->toArray(),
            'children' => $menu->childrenRecursive
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
