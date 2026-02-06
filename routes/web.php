<?php

use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', [VisitorController::class, 'destroy'])
    ->name('logout');

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::post('/visitor/enter', [VisitorController::class, 'enter'])
    ->name('visitor.enter');
    
Route::get('/debug-user', function () {
    return [
        'auth_user' => auth()->user(),
        'id'        => auth()->id(),
        'role'      => auth()->user()->role ?? 'NULL',
        'division'  => auth()->user()->division ?? 'NULL',
    ];
})->middleware('auth');

Route::get('/dashboard')->middleware('redirect.role');


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

Route::middleware(['auth', RoleMiddleware::class . ':1'])->group(function () {

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

    Route::post('/admin/division-access', [AdminController::class, 'updateDivisionAccess'])
        ->name('admin.division.access.update');

    // Admin document management
    Route::get('/admin/documents/category/{category}', [AdminDocumentController::class, 'category'])
        ->name('admin.documents.category');

    Route::post('/admin/documents/category/{category}/upload', [AdminDocumentController::class, 'upload'])
        ->name('admin.documents.upload');

    Route::delete('/admin/documents/category/{category}/{filename}', [AdminDocumentController::class, 'destroy'])
        ->where('filename', '.*')
        ->name('admin.documents.delete');

    // admin view of documents (with upload/replace)
    Route::get('/admin/documents/category/{category}', [AdminDocumentController::class, 'category'])
        ->name('admin.admincategory');

    Route::post('/admin/documents/category/{category}/upload', [AdminDocumentController::class, 'upload'])
    ->name('admin.upload');

    Route::delete('/admin/documents/category/{category}/{filename}', [AdminDocumentController::class, 'destroy'])
        ->where('filename', '.*')
        ->name('admin.delete');
});


/*
|--------------------------------------------------------------------------
| LEADER ROUTES (role = 2)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', RoleMiddleware::class . ':2'])->group(function () {

    Route::get('/leader', [LeaderController::class, 'index'])
        ->name('leader.dashboard');

    Route::post('/leader/access', [LeaderController::class, 'updateAccess'])
        ->name('leader.access.update');
});




/*
|--------------------------------------------------------------------------
| DOCUMENT ACCESS (role = 2,3)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', RoleMiddleware::class . ':2,3'])->group(function () {

    Route::get('/documents', [DocumentController::class, 'index'])
        ->name('documents.index');

    Route::get('/documents/category/{category}', [DocumentController::class, 'category'])
        ->name('documents.category');

    Route::post('/documents/{category}/{filename}/edit', [DocumentController::class, 'edit'])
        ->name('documents.edit');
});

Route::get('/documents/open/{category}/{filename}', [DocumentController::class, 'open'])
    ->where('filename', '.*')
    ->middleware('signed')
    ->name('documents.open');


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
