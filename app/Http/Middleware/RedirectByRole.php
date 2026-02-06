<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RedirectByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $role = auth()->user()->role;

            return match ($role) {
                1 => redirect()->route('admin.dashboard'),
                2 => redirect()->route('leader.dashboard'),
                3 => redirect()->route('documents.index'),
                default => abort(403),
            };
        }

        return $next($request);
    }

}
