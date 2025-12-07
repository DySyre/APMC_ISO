<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function storeVisitor(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'badge_number' => 'required|string|max:50',
            'division'     => 'required|string|max:255',
        ]);

        // Store or update in SQL
        $visitor = Visitor::updateOrCreate(
            ['badge_number' => $data['badge_number']],
            [
                'name'          => $data['name'],
                'division'      => $data['division'],
                'last_login_at' => now(),
            ]
        );

        session(['visitor_id' => $visitor->id]);

        return redirect()->route('documents.index'); // we will build this page next
    }
}

