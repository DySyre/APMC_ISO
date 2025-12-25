<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Ilovepdf\Ilovepdf;
use Ilovepdf\Editpdf\TextElement;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    // map slugs to folder & label
    protected array $categories = [
        'admin'                             => ['label' => 'Admin',                             'dir' => 'admin'],
        'personnel-services'                => ['label' => 'Personnel Services',                'dir' => 'personnel-services'],
        'recruitment-division'              => ['label' => 'Recruitment Division',              'dir' => 'recruitment-division'],
        'career-management'                 => ['label' => 'Career Management',                 'dir' => 'career-management'],
        'enlisted-personnel-class-advisory' => ['label' => 'Enlisted Personnel Class Advisory', 'dir' => 'enlisted-personnel-class-advisory'],
        'officer-career-advisory'           => ['label' => 'Officer Career Advisory',           'dir' => 'officer-career-advisory'],
    ];

    public function index()
    {
        $user = User::find(session('visitor_user_id'));

        // Build folders for UI
        $folders = collect($this->categories)->map(function ($info, $slug) use ($user) {
            // find leader assigned to this category (if any)
            $leader = User::where('role', 2)
                ->where('leader_category', $slug)
                ->first();

            $allowed = false;
            $reason  = null;

            // ADMIN
            if ((int)$user->role === 1) {
                $allowed = true;
            }

            // LEADER: only their assigned category
            elseif ((int)$user->role === 2) {
                $allowed = ($user->leader_category === $slug);
                if (! $allowed) $reason = 'Not assigned to your supervision category.';
            }

            // USER
            else {
                // if no leader assigned yet, allow everyone
                if (! $leader) {
                    $allowed = true;
                } else {
                    // leader exists -> must match leader's division
                    $allowed = ($leader->division === $user->division);
                    if (! $allowed) $reason = 'Restricted to another division.';
                }
            }

            return [
                'slug'   => $slug,
                'label'  => $info['label'],
                'url'    => route('documents.category', $slug),
                'allowed'=> $allowed,
                'reason' => $reason,
            ];
        })->values();

        return view('documents.index', [
            'user'    => $user,
            'folders' => $folders,
        ]);
    }

    public function category(string $category)
{
    $user = User::find(session('visitor_user_id'));

    // ✅ If no session / user not found
    if (! $user) {
        abort(403, 'Please login first.');
    }

    // ✅ If division not assigned yet
    if (blank($user->division)) {
        abort(403, 'Your division is not assigned yet. Please ask the admin to assign your division.');
    }

    if (! isset($this->categories[$category])) {
        abort(404);
    }

    // ✅ Admin always allowed
    if ((int) $user->role === 1) {
        return $this->renderCategory($user, $category);
    }

    // ✅ Leader/User must be allowed by their division
    $allowed = DB::table('division_category_access')
        ->where('division', $user->division)
        ->where('category', $category)
        ->exists();

    if (! $allowed) {
        abort(403, 'Your division does not have access to this category.');
    }

    return $this->renderCategory($user, $category);
}

/**
 * ✅ Keeps your old listing logic clean (no changes needed elsewhere)
 */
protected function renderCategory(User $user, string $category)
{
    $info = $this->categories[$category];

    $search = request('search');

    $files = Storage::disk('public')->files('documents/'.$info['dir']);

    $documents = collect($files)->map(function ($path) use ($category) {
        return [
            'name'     => basename($path),
            'url'      => Storage::url($path),
            'edit_url' => route('documents.edit', [
                'category' => $category,
                'filename' => basename($path),
            ]),
        ];
    });

    if ($search) {
        $documents = $documents->filter(fn ($doc) =>
            str_contains(strtolower($doc['name']), strtolower($search))
        );
    }

    $perPage = 10;
    $currentPage = request()->get('page', 1);
    $pagedDocs = $documents->forPage($currentPage, $perPage);

    $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
        $pagedDocs,
        $documents->count(),
        $perPage,
        $currentPage,
        [
            'path'  => request()->url(),
            'query' => request()->query(),
        ]
    );

    return view('documents.category', [
        'user'          => $user,
        'category'      => $category,
        'categoryLabel' => $info['label'],
        'documents'     => $paginator,
        'search'        => $search,
    ]);
}

protected function authorizeCategoryAccess(User $user, string $category): void
{
    // Admin -> allow
    if ((int)$user->role === 1) return;

    // Leader -> allow if this category is enabled for their division
    // (optional: you can allow leaders to override even if not enabled, but usually no)
    if ((int)$user->role === 2) {
        $allowed = DB::table('division_category_access')
            ->where('division', $user->division)
            ->where('category', $category)
            ->exists();

        if (! $allowed) abort(403, 'Unauthorized.');
        return;
    }

    // User -> allow if category enabled for their division
    $allowed = DB::table('division_category_access')
        ->where('division', $user->division)
        ->where('category', $category)
        ->exists();

    if (! $allowed) abort(403, 'Unauthorized.');
}


    /**
     * Edit a PDF: example adds a "CONFIDENTIAL" text label and saves a new file.
     */
    public function edit(string $category, string $filename)
    {
        $user = User::find(session('visitor_user_id'));
        // $user = auth()->user(); auth


        if (! isset($this->categories[$category])) {
            abort(404);
        }

        $info = $this->categories[$category];

        // Relative path on the public disk
        $relativePath = 'documents/'.$info['dir'].'/'.$filename;

        if (! Storage::disk('public')->exists($relativePath)) {
            abort(404, 'PDF not found');
        }

        // Absolute local path for iLovePDF
        $localPath = Storage::disk('public')->path($relativePath);

        // Init iLovePDF
        $ilovepdf = new Ilovepdf(
            config('services.ilovepdf.public'),
            config('services.ilovepdf.secret')
        );

        // Create edit task
        $task = $ilovepdf->newTask('editpdf');

        // Add the file
        $task->addFile($localPath);

        $textElem = new TextElement();
        $textElem
            ->setText('CONFIDENTIAL')
            ->setCoordinates(100, 100)
            ->setFontSize(20)
            ->setFontColor('#FF0000')
            ->setOpacity(60)
            ->setPages(1);  // Apply to first page only

        // Attach element to task
        $task->addElement($textElem);

        // Optional: change output file name (without extension)
        $outputBaseName = pathinfo($filename, PATHINFO_FILENAME);
        $task->setOutputFilename($outputBaseName.'_edited');

        // Run task
        $task->execute();

        // Download back into the same documents directory
        $outputDir = Storage::disk('public')->path('documents/'.$info['dir']);
        $task->download($outputDir);

        // Build public URL for the new file
        $editedFilename = $outputBaseName.'_edited.pdf';
        $editedRelativePath = 'documents/'.$info['dir'].'/'.$editedFilename;
        $editedUrl = Storage::url($editedRelativePath);

        // You can redirect back to category view, or show a "success" page
        return redirect()
            ->route('documents.category', $category)
            ->with('status', "Edited PDF created: {$editedFilename}")
            ->with('edited_url', $editedUrl);
    }
}
