<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Split roles by | not comma
        $allowedRoles = explode('|', $roles);

        if (!in_array($user->role, $allowedRoles)) {
            return response()->json([
                'message' => 'Forbidden: insufficient role',
                'user_role' => $user->role,
                'allowed_roles' => $allowedRoles
            ], 403);
        }

        return $next($request);
    }
}
