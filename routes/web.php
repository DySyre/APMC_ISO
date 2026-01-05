<?php

use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');


/*
|--------------------------------------------------------------------------
| DASHBOARD (generic, optional)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (role = 1)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:' . User::ROLE_ADMIN])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    // User management
    Route::get('/admin/users', [AdminController::class, 'users'])
        ->name('admin.users.index');

    Route::post('/admin/users/{user}/role', [AdminController::class, 'updateRole'])
        ->name('admin.users.updateRole');

    Route::post('/admin/users/{user}/division', [AdminController::class, 'updateDivision'])
        ->name('admin.users.updateDivision');

    Route::post('/admin/users/{user}/leader-category', [AdminController::class, 'updateLeaderCategory'])
        ->name('admin.users.updateLeaderCategory');

    // Admin document management
    Route::get('/admin/documents/category/{category}', [AdminDocumentController::class, 'category'])
        ->name('admin.documents.category');

    Route::post('/admin/documents/category/{category}/upload', [AdminDocumentController::class, 'upload'])
        ->name('admin.documents.upload');

    Route::delete('/admin/documents/category/{category}/{filename}', [AdminDocumentController::class, 'destroy'])
        ->where('filename', '.*')
        ->name('admin.documents.delete');
});


/*
|--------------------------------------------------------------------------
| LEADER ROUTES (role = 2)
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'role:' . User::ROLE_LEADER])->group(function () {

    Route::get('/leader', [LeaderController::class, 'index'])
        ->name('leader.dashboard');

    Route::post('/leader/access', [LeaderController::class, 'updateAccess'])
        ->name('leader.access.update');
});


/*
|--------------------------------------------------------------------------
| DOCUMENT ACCESS (USERS + LEADERS)
| role = 2,3
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:' . User::ROLE_LEADER . ',' . User::ROLE_USER])->group(function () {

    Route::get('/documents', [DocumentController::class, 'index'])
        ->name('documents.index');

    Route::get('/documents/category/{category}', [DocumentController::class, 'category'])
        ->name('documents.category');

    Route::post('/documents/{category}/{filename}/edit', [DocumentController::class, 'edit'])
        ->name('documents.edit');
});


/*
|--------------------------------------------------------------------------
| PROFILE (ALL AUTHENTICATED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__.'/auth.php';
