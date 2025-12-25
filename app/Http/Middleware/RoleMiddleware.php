<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class RoleMiddleware
{
    public function handle($request, \Closure $next, $roles)
{
    $user = \App\Models\User::find(session('visitor_user_id'));

    if (! $user) {
        abort(403, 'Unauthorized.');
    }

    $allowed = collect(explode(',', $roles))
        ->map(fn ($r) => (int)trim($r))
        ->filter()
        ->values();

    if (! $allowed->contains((int)$user->role)) {
        abort(403, 'Unauthorized.');
    }

    return $next($request);
}

}
