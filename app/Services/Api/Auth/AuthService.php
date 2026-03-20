<?php

namespace App\Services\Api\Auth;

use App\Models\User;
use App\Models\Application;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Handle user login
     */
    public function login(string $email, string $password)
    {
        // Find user by email
        $user = User::where('email', $email)->first();

        $clientId = request()->header('X-API-Client-ID');
        // Validate client
        $application = Application::where('api_client_id', $clientId)
            ->where('is_active', true)
            ->first();

        if (!$application) {
            return [
                'success' => false,
                'message' => 'Invalid API client.',
                'errors' => ['client' => 'API client not found or inactive.']
            ];
        }

        $applicationId = $application->id;

        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Email atau password salah.',
                'errors' => ['credentials' => 'Email atau password salah.']
            ];
        }

        // Check if user is active
        if (!$user->is_active) {
            return [
                'success' => false,
                'message' => 'User tidak aktif.',
                'errors' => ['user' => 'User tidak aktif.']
            ];
        }

        // Get user roles for this application
        $userRoles = $user->userRoles()
            ->whereHas('role', function ($query) use ($applicationId) {
                $query->where('roles.application_id', $applicationId);
            })
            ->with('role.application')
            ->get();

        if ($userRoles->isEmpty()) {
            return [
                'success' => false,
                'message' => 'User tidak memiliki role di aplikasi ini.',
                'errors' => ['authorization' => 'User tidak memiliki role di aplikasi ini.']
            ];
        }

        // Extract role IDs
        $roleIds = $userRoles->pluck('role_id')->toArray();

        // Get menus for this application that user has access to
        $menus = $this->getUserMenus($user, $application, $roleIds);

        // Get menu permissions for user roles
        $menuPermissions = $this->getUserMenuPermissions($roleIds);

        // Generate API token (using user ID + application ID)
        $token = $this->generateToken($user, $application);

        // Update last login
        $user->updateLastLogin();

        return [
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active,
                ],
                'application' => [
                    'id' => $application->id,
                    'name' => $application->name,
                    'slug' => $application->slug,
                    'logo_url' => $application->logo_url,
                ],
                'roles' => $userRoles->map(function ($ur) {
                    return [
                        'id' => $ur->role->id,
                        'name' => $ur->role->name,
                        'slug' => $ur->role->slug,
                    ];
                })->values(),
                'menus' => $menus,
                'permissions' => $menuPermissions,
            ]
        ];
    }

    /**
     * Get user accessible menus for application
     */
    private function getUserMenus($user, $application, $roleIds)
    {
        return Menu::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->where(function ($query) use ($application) {
                $query->where('is_global', true)
                    ->orWhere('application_id', $application->id);
            })
            ->orderBy('order_no')
            ->get()
            ->map(function ($menu) use ($roleIds) {
                return $this->buildMenuTree($menu, $roleIds);
            })
            ->filter()
            ->values();
    }

    /**
     * Recursively build menu tree with permissions check
     */
    private function buildMenuTree($menu, $roleIds)
    {
        // Get children recursively
        $children = $menu->children()
            ->where('is_active', true)
            ->orderBy('order_no')
            ->get()
            ->map(function ($child) use ($roleIds) {
                return $this->buildMenuTree($child, $roleIds);
            })
            ->filter()
            ->values();

        // Check if menu has explicit permission or children have permissions
        $hasPermission = $menu->permissions()
            ->whereIn('role_id', $roleIds)
            ->exists();

        if ($hasPermission || $children->isNotEmpty()) {
            return [
                'id' => $menu->id,
                'title' => $menu->title,
                'icon' => $menu->icon,
                'route' => $menu->route,
                'parent_id' => $menu->parent_id,
                'resource' => $menu->resource,
                'type' => $menu->type,
                'url' => $menu->url,
                'order_no' => $menu->order_no,
                'children' => $children,
            ];
        }

        return null;
    }

    /**
     * Get menu permissions for user roles
     */
    private function getUserMenuPermissions($roleIds)
    {
        return \App\Models\MenuPermission::whereIn('role_id', $roleIds)
            ->with(['menu', 'role'])
            ->get()
            ->map(function ($permission) {
                return [
                    'menu_id' => $permission->menu_id,
                    'menu_title' => $permission->menu->title ?? null,
                    'role_id' => $permission->role_id,
                    'role_name' => $permission->role->name ?? null,
                    'can_view' => $permission->can_view,
                    'can_create' => $permission->can_create,
                    'can_edit' => $permission->can_edit,
                    'can_delete' => $permission->can_delete,
                ];
            })
            ->values();
    }

    /**
     * Generate API token
     */
    private function generateToken($user, $application)
    {
        // Generate JWT-like token (user_id:application_id:timestamp:hash)
        $timestamp = now()->timestamp;
        $hash = hash('sha256', "{$user->id}:{$application->id}:{$timestamp}:" . config('app.key'));

        return base64_encode("{$user->id}:{$application->id}:{$timestamp}:{$hash}");
    }

    /**
     * Verify and decode token
     */
    public function verifyToken(string $token)
    {
        try {
            $decoded = base64_decode($token, true);
            if (!$decoded) {
                return null;
            }

            $parts = explode(':', $decoded);
            if (count($parts) !== 4) {
                return null;
            }

            [$userId, $applicationId, $timestamp, $hash] = $parts;

            // Verify hash
            $expectedHash = hash('sha256', "{$userId}:{$applicationId}:{$timestamp}:" . config('app.key'));
            if (!hash_equals($hash, $expectedHash)) {
                return null;
            }

            // Check token expiry (24 hours)
            if (now()->timestamp - $timestamp > 86400) {
                return null;
            }

            return [
                'user_id' => $userId,
                'application_id' => $applicationId,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
