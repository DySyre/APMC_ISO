<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VisitorController extends Controller
{
    public function storeVisitor(Request $request)
    {
        $data = $request->validate([
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'badge_number' => ['required', 'digits_between:6,12', 'confirmed'],
            'division'     => ['required', 'string', 'max:255'],
        ]);

        // Try to find existing user by badge number
        $user = User::where('badge_number', $data['badge_number'])->first();

        if (!$user) {
            // Create new user (self-populating)
            $user = User::create([
                'first_name'   => $data['first_name'],
                'last_name'    => $data['last_name'],
                'name'         => $data['first_name'].' '.$data['last_name'], // keep default name filled
                'badge_number' => $data['badge_number'],
                'division'     => $data['division'],
                'role'         => 3, // default = User
                'email'        => $data['badge_number'].'@placeholder.local',
                'password'     => Hash::make(Str::random(16)),
                'last_login_at'=> now(),
            ]);
        } else {
            // Update existing user basic info + last login
            $user->update([
                'first_name'   => $data['first_name'],
                'last_name'    => $data['last_name'],
                'name'         => $data['first_name'].' '.$data['last_name'],
                'division'     => $data['division'],
                'last_login_at'=> now(),
            ]);
        }

        // Save in session who is currently inside
       session(['visitor_user_id' => $user->id]);

    // ROLE REDIRECTION
    switch ($user->role) {
        case 1: // Admin
            return redirect()->route('admin.dashboard');

        case 2: // Leader
            return redirect()->route('leader.dashboard');

        case 3: // User
        default:
            return redirect()->route('documents.index');
    }
    }
   
}
