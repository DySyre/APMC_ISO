<?php
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});


Route::post('/enter', [VisitorController::class, 'storeVisitor'])->name('visitor.enter');
