<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission = null): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // If no specific permission is provided, try to determine from route
        if (!$permission) {
            $permission = $this->getPermissionFromRoute($request->route()->getName());
        }

        // Check if user has the required permission
        if ($permission && !$user->can($permission)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }

    /**
     * Get permission name from route name
     */
    private function getPermissionFromRoute(?string $routeName): ?string
    {
        if (!$routeName) {
            return null;
        }

        // Map route names to permissions
        $routePermissionMap = [
            'dashboard' => 'dashboard.view',
            
            // User Management
            'user-management.user' => 'user-management.user.view',
            'user-management.role' => 'user-management.role.view',
            'user-management.permission' => 'user-management.permission.view',
            
            // Settings
            'settings.general' => 'settings.general.view',
            'settings.security' => 'settings.security.view',
            'settings.notifications' => 'settings.notifications.view',
        ];

        return $routePermissionMap[$routeName] ?? null;
    }
}