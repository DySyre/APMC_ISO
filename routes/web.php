<?php

use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Landing
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Visitor badge login
Route::post('/enter', [VisitorController::class, 'storeVisitor'])->name('visitor.enter');


// ============================
// ADMIN (role = 1)
// ============================
Route::middleware(RoleMiddleware::class . ':1')->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    // user management
    Route::get('/admin/users', [AdminController::class, 'users'])
        ->name('admin.users.index');

    Route::post('/admin/users/{user}/role', [AdminController::class, 'updateRole'])
        ->name('admin.users.updateRole');

    // admin view of documents (with upload/replace)
    Route::get('/admin/documents/category/{category}', [AdminDocumentController::class, 'category'])
        ->name('admin.admincategory');

    Route::post('/admin/documents/category/{category}/upload', [AdminDocumentController::class, 'upload'])
    ->name('admin.upload');

    Route::delete('/admin/documents/category/{category}/{filename}', [AdminDocumentController::class, 'destroy'])
        ->where('filename', '.*')
        ->name('admin.delete');

        


    // (optional) later: admin upload/replace routes can go here
    // Route::post('/admin/documents/{category}/upload', [...])->name('admin.documents.upload');
    // Route::post('/admin/documents/{category}/{filename}/replace', [...])->name('admin.documents.replace');
});


// ============================
// LEADER (role = 2)
// ============================
Route::get('/leader', [LeaderController::class, 'index'])
    ->middleware(RoleMiddleware::class . ':2')
    ->name('leader.dashboard');

Route::post('/admin/users/{user}/leader-category', [AdminController::class, 'updateLeaderCategory'])
    ->name('admin.users.updateLeaderCategory');

Route::post('/leader/access', [LeaderController::class, 'updateAccess'])
    ->middleware(RoleMiddleware::class . ':2')
    ->name('leader.access.update');

Route::post('/admin/users/{user}/division', [AdminController::class, 'updateDivision'])
    ->name('admin.users.updateDivision');


// ============================
// USER (role = 3)
// ============================
Route::middleware(RoleMiddleware::class . ':3')->group(function () {

    // main documents portal
    Route::get('/documents', [DocumentController::class, 'index'])
        ->name('documents.index');

    // category view for users/leaders
    Route::get('/documents/category/{category}', [DocumentController::class, 'category'])
        ->name('documents.category');

    // iLovePDF edit (if you use it)
    Route::post('/documents/{category}/{filename}/edit', [DocumentController::class, 'edit'])
        ->name('documents.edit');
});
