<?php

namespace App\Http\Controllers;

use App\Models\User;

class DocumentController extends Controller
{
    public function index()
    {
        $user = User::find(session('visitor_user_id'));

        // later: fetch documents by division/permissions from a Document model
        $documents = []; // placeholder

        return view('documents.index', compact('user', 'documents'));
    }
}
