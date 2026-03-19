<?php

namespace App\Http\Middleware;

use App\Models\Application;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Menu;
use App\Models\MenuPermission;

class CheckRoleAccess
{
    /**
     * Handle an incoming request to check role-based menu access.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();
        // return $next($request);


        if (!$user) {
            return redirect()->route('login');
        }
        // label can_view, can_create, can_edit, can_delete
        $routeLabel = $request->route()->defaults['label'] ?? 'can_view';
        
        // get menu id by route name
        $routeResource = str($request->route()->getAction('as'))->before('.')->toString();

        // if route name is null, get menu id by url
        $routeMenuId = Menu::where('resource', $routeResource)->value('id');

        // get application name in env APPLICATION_NAME
        $applicationId = Application::where('slug', env('APPLICATION_NAME'))->first();

        // Get user's roles
        $userRoleIds = $user->roles()->where('application_id', $applicationId->id)->pluck('role_id')->toArray();

        if (empty($userRoleIds)) {
            abort(403, 'Anda tidak memiliki akses pada aplikasi ini.');
        }
        // Check if user has any of the specified roles menu_permissions for the current route
        $hasAccess = false;

        foreach ($userRoleIds as $roleId) {
            $menuPermission = MenuPermission::where('role_id', $roleId)
                ->where('menu_id', $routeMenuId)
                ->where($routeLabel, true)
                ->first();
            if ($menuPermission) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
