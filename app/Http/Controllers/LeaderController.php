<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderController extends Controller
{
    public function index()
    {
        $leader = $this->currentUser();
        if (! $leader || (int)$leader->role !== 2) abort(403);

        $categories = [
            'admin' => 'Admin',
            'personnel-services' => 'Personnel Services',
            'recruitment-division' => 'Recruitment Division',
            'career-management' => 'Career Management',
            'enlisted-personnel-class-advisory' => 'Enlisted Personnel Class Advisory',
            'officer-career-advisory' => 'Officer Career Advisory',
        ];

        $allowed = DB::table('division_category_access')
            ->where('division', $leader->division)
            ->pluck('category')
            ->toArray();

        $divisionUsers = User::where('division', $leader->division)
            ->orderBy('last_name')
            ->get();

        return view('leader.dashboard', compact('leader', 'divisionUsers', 'categories', 'allowed'));
    }

    public function updateAccess(Request $request)
    {
        $leader = $this->currentUser();
        if (! $leader || (int)$leader->role !== 2) abort(403);

        $valid = [
            'admin',
            'personnel-services',
            'recruitment-division',
            'career-management',
            'enlisted-personnel-class-advisory',
            'officer-career-advisory',
        ];

        // ✅ allow empty submit (no checkbox selected)
        $data = $request->validate([
            'categories'   => ['sometimes', 'array'],
            'categories.*' => ['in:' . implode(',', $valid)],
        ]);

        $selected = $data['categories'] ?? [];

        DB::transaction(function () use ($leader, $selected) {
            DB::table('division_category_access')
                ->where('division', $leader->division)
                ->delete();

            foreach ($selected as $cat) {
                DB::table('division_category_access')->insert([
                    'division'   => $leader->division,
                    'category'   => $cat,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return back()->with('status', 'Access updated for your division.');
    }

    // ✅ ADD THIS (this is what you were missing)
    protected function currentUser(): ?User
    {
        $id = session('visitor_user_id');
        if (! $id) return null;

        return User::find($id);
    }
}
