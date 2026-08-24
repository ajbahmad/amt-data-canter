<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\MenuPermission;
use App\Helpers\ResponseHelper;

class ValidateMenuPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $permissionLabel = null): Response
    {
        $user = auth()->user();
        // dd($user);
        // Get the permission label from route defaults if not provided
        if (!$permissionLabel) {
            $route = $request->route();
            $permissionLabel = ($route && isset($route->defaults['label'])) ? $route->defaults['label'] : null;
        }

        // dd($permissionLabel);

        // If no permission label is defined, allow access
        if (!$permissionLabel) {
            return $next($request);
        }

        // Get the authenticated user's role from API token
        $tokenData = $request->get('api_token_data');
        if (!$tokenData || !isset($tokenData['role_id'])) {
            return ResponseHelper::unauthorized('Role information not found in token.');
        }

        $roleId = $tokenData['role_id'];

        // Get the current route name to find associated menu
        $route = $request->route();
        $routeName = $route ? $route->getName() : null;

        // Map route names to menu identifiers (you may need to adjust this mapping)
        $menuMapping = [
            'school-institutions.index' => 'school-institutions',
            'school-institutions.store' => 'school-institutions',
            'school-institutions.show' => 'school-institutions',
            'school-institutions.update' => 'school-institutions',
            'school-institutions.destroy' => 'school-institutions',
        ];

        $menuIdentifier = $menuMapping[$routeName] ?? null;
        if (!$menuIdentifier) {
            // If no menu mapping found, allow access
            return $next($request);
        }

        // Check if user has permission
        $hasPermission = $this->checkPermission($roleId, $menuIdentifier, $permissionLabel);

        if (!$hasPermission) {
            return ResponseHelper::forbidden(
                "You do not have permission to {$permissionLabel} this resource."
            );
        }

        return $next($request);
    }

    /**
     * Check if user has specific permission
     */
    private function checkPermission(string $roleId, string $menuIdentifier, string $permissionLabel): bool
    {
        // Map permission labels to database columns
        $permissionMap = [
            'can_view' => 'can_view',
            'can_create' => 'can_create',
            'can_edit' => 'can_edit',
            'can_delete' => 'can_delete',
        ];

        $column = $permissionMap[$permissionLabel] ?? null;
        if (!$column) {
            return false;
        }

        // Query menu permission from database
        $permission = MenuPermission::where('role_id', $roleId)
            ->whereHas('menu', function ($query) use ($menuIdentifier) {
                $query->where('code', $menuIdentifier);
            })
            ->first();

        // If no permission record exists, default to false
        if (!$permission) {
            return false;
        }

        // Return the permission value
        return (bool) $permission->{$column};
    }
}
