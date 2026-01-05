<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (! $user) {
            abort(403);
        }

        // Convert role constants or numeric strings to integers
        $allowedRoles = collect($roles)
            ->map(fn ($role) => (int) $role)
            ->values();

        if (! $allowedRoles->contains((int) $user->role)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
