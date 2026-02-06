<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'badge_number'  => ['required', 'string', 'max:255', 'unique:users,badge_number'],
            'division'      => ['nullable', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'badge_number' => $request->badge_number,
            'division'     => $request->division,
            'role'         => 3, // ROLE_USER
            'name'         => $request->first_name . ' ' . $request->last_name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on user role (consistent with VisitorController)
        return match ((int) $user->role) {
            1 => redirect()->route('admin.dashboard'),
            2 => redirect()->route('leader.dashboard'),
            3 => redirect()->route('documents.index'),
            default => abort(403),
        };
    }
}
