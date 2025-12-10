<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderController extends Controller
{
    public function index()
    {
        $leader = $this->currentUser();
        $divisionUsers = User::where('division', $leader->division)->orderBy('last_name')->get();

        return view('leader.dashboard', [
            'leader'        => $leader,
            'divisionUsers' => $divisionUsers,
        ]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cr $cr)
    {
        //
    }

    //  Protected function currentUser() --- IGNORE --- LARAVEL IS AWESOME ---

    protected function currentUser()
    {
        // if you later use auth(), replace this
        return User::find(session('visitor_user_id'));
    }
}
