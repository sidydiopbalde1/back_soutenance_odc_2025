<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permissions)
    {
        $user = Auth::user();

        // Diviser les permissions par virgule et vérifier si l'utilisateur en a au moins une
        $permissionsArray = explode(',', $permissions);
        $hasPermission = $user && $user->role->permissions->pluck('libelle')->intersect($permissionsArray)->isNotEmpty();
        if (!$hasPermission) {
            return response()->json(
                [
                    'message'=>'Vous n\'avez pas les permissions nécessaires.'
                ],
                403);
        }

        return $next($request);
    }
}

