<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $users   = User::orderBy('last_name')->get();
        $leaders = User::where('role', 2)->orderBy('last_name')->get();

        return view('admin.users', compact('users', 'leaders'));

    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role'     => ['required', 'in:1,2,3'],
            'division' => ['nullable', 'string', 'max:255'],
        ]);

        $user->role = (int) $data['role'];
        $user->division = $data['division'] ?: null;
        $user->save();

        return back()->with('status', "Updated {$user->first_name} {$user->last_name}.");
    }

    public function updateLeaderCategory(Request $request, User $user)
        {
            // must be leader
            if ((int)$user->role !== 2) {
                return back()->with('status', 'Only Leaders can be assigned a category.');
            }

            $allowed = [
                'admin',
                'personnel-services',
                'recruitment-division',
                'career-management',
                'enlisted-personnel-class-advisory',
                'officer-career-advisory',
            ];

            $data = $request->validate([
                'leader_category' => ['required', 'in:' . implode(',', $allowed)],
            ]);

            // ensure only ONE leader per category
            User::where('role', 2)
                ->where('leader_category', $data['leader_category'])
                ->where('id', '!=', $user->id)
                ->update(['leader_category' => null]);

            $user->leader_category = $data['leader_category'];
            $user->save();

            return back()->with('status', "Leader assigned to: {$data['leader_category']}");
            }

    public function updateDivision(Request $request, User $user)
        {
            $request->validate([
                'division' => ['required', 'string', 'max:255'],
            ]);

            $user->update([
                'division' => $request->division,
            ]);

            return back()->with('status', 'Division updated.');
        }

}