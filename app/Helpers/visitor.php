<?php

use App\Models\User;

function currentVisitor()
{
    return session()->has('visitor_id')
        ? User::find(session('visitor_id'))
        : null;
}
