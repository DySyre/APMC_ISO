<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class VisitorController extends Controller
{
    /**
     * Login using badge number + password.
     * Redirect based on role.
     */
    public function enter(Request $request)
{
    // Validate basic fields
    $data = $request->validate([
        'badge_number' => ['required', 'string'],
        'password'     => ['required', 'string'],
    ]);

    // Retrieve user by badge number
    $user = User::where('badge_number', $data['badge_number'])->first();

    // Bail-out: no such user OR wrong password
    if (! $user || ! Hash::check($data['password'], $user->password)) {
        return back()
            ->withErrors(['badge_number' => 'Invalid badge number or password'])
            ->withInput();
    }

    // Log in properly
    Auth::login($user);
    $request->session()->regenerate();

    // Admin bypasses division requirement
    if ($user->role !== User::ROLE_ADMIN) {
        if (empty($user->division)) {

            Auth::logout(); // clean session

            return redirect()
                ->route('landing')
                ->withErrors([
                    'badge_number' => 'Your account is not yet assigned to a division.',
                ]);
        }
    }

    // Role-based redirect
    return match ($user->role) {
        User::ROLE_ADMIN  => to_route('admin.dashboard'),
        User::ROLE_LEADER => to_route('leader.dashboard'),
        User::ROLE_USER   => to_route('documents.index'),

        default => abort(403, 'Unknown role.'),
    };
}

    /**
     * Logout (if needed)
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
