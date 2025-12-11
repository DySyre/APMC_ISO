<?php
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;


Route::get('/', function () {
    return view('landing');
})->name('landing');

// Route::post('/logout', function () {
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();

//     return redirect()->route('landing'); // or '/'
// })->name('logout');


Route::post('/enter', [VisitorController::class, 'storeVisitor'])->name('visitor.enter');

Route::get('/index', function () {
    return view('documents.index');
})->name('index');

    // user management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::post('/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');



// Middleware protected routes based on roles
// USER (role = 3)
Route::get('/documents', [DocumentController::class, 'index'])
    ->middleware(RoleMiddleware::class . ':3')
    ->name('documents.index');

// LEADER (role = 2)
Route::get('/leader', [LeaderController::class, 'index'])
    ->middleware(RoleMiddleware::class . ':2')
    ->name('leader.dashboard');

// ADMIN (role = 1)
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(RoleMiddleware::class . ':1')
    ->name('admin.dashboard');

// Storage route

// main portal
Route::get('/documents', [DocumentController::class, 'index'])
    ->middleware(RoleMiddleware::class . ':3')
    ->name('documents.index');

// folder/category view
Route::get('/documents/category/{category}', [DocumentController::class, 'category'])
    ->middleware(RoleMiddleware::class . ':3')
    ->name('documents.category');

// IlovePDF edit view

Route::get('/documents/{category}', [DocumentController::class, 'category'])
    ->name('documents.category');

Route::post('/documents/{category}/{filename}/edit', [DocumentController::class, 'edit'])
    ->name('documents.edit');
    
