<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers   = User::count();
        $totalLeaders = User::where('role', 2)->count();
        $totalAdmins  = User::where('role', 1)->count();

        return view('admin.dashboard', compact('totalUsers', 'totalLeaders', 'totalAdmins'));
    }

    public function users()
    {
        $users = User::orderBy('division')->orderBy('last_name')->get();

        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:1,2,3'],
        ]);

        $user->role = (int) $request->role;
        $user->save();

        return back()->with('status', 'Role updated for '.$user->first_name.' '.$user->last_name);
    }
}
