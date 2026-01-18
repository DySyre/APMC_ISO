<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class VisitorController extends Controller
{
    public function enter(Request $request)
    {
        $credentials = $request->validate([
            'badge_number' => ['required', 'string'],
            'password'     => ['required', 'string'],
        ]);

        $user = User::where('badge_number', $credentials['badge_number'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['badge_number' => 'Invalid badge number or password'])
                ->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role !== User::ROLE_ADMIN && empty($user->division)) {
            Auth::logout();
            return redirect()
                ->route('landing')
                ->withErrors(['badge_number' => 'Your account is not yet assigned to a division.']);
        }

        return match ((int) $user->role) {
            User::ROLE_ADMIN  => redirect()->route('admin.dashboard'),
            User::ROLE_LEADER => redirect()->route('leader.dashboard'),
            User::ROLE_USER   => redirect()->route('documents.index'),
            default           => abort(403),
        };
    }
}
