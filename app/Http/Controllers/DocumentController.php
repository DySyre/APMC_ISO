<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ilovepdf\Ilovepdf;
use Ilovepdf\Editpdf\TextElement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

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

    /**
     * -----------------------------------------
     * DOCUMENT DASHBOARD 
     * -----------------------------------------
     */
    public function index()
    {
        $user = Auth::user();

        if (! $user) {
            abort(401, 'Not authenticated.');
        }

        // Build folders for UI
        $folders = collect($this->categories)->map(function ($info, $slug) use ($user) {

            $allowed = false;
            $reason  = null;

            // ADMIN
            if ($user->role == User::ROLE_ADMIN) {
                $allowed = true;
            }

            // LEADER: only their assigned category
            elseif ($user->role == User::ROLE_LEADER) {
                $allowed = ($user->leader_category === $slug);
                if (! $allowed) {
                    $reason = 'Not assigned to your supervision category.';
                }
            }

            // USER
            else {
                if (blank($user->division)) {
                    $allowed = false;
                    $reason = 'Your division is not assigned yet.';
                } else {
                    $allowed = DB::table('division_category_access')
                        ->where('division', $user->division)
                        ->where('category', $slug)
                        ->exists();

                    if (! $allowed) {
                        $reason = 'Your division does not have access to this category.';
                    }
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

        return view('documents.index', compact('user', 'folders'));
    }

    /**
     * -----------------------------------------
     * CATEGORY VIEW
     * -----------------------------------------
     */
    public function category(string $category)
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'Please login first.');
        }

        // Division required for Users/Leaders
        if (blank($user->division)) {
            abort(403, 'Your division is not assigned yet.');
        }

        if (! isset($this->categories[$category])) {
            abort(404);
        }

        // ADMIN always allowed
        if ($user->role == User::ROLE_ADMIN) {
            return $this->renderCategory($user, $category);
        }

        // LEADER / USER → must have access
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
     * -----------------------------------------
     * RENDER FILE LIST
     * -----------------------------------------
     */
    protected function renderCategory(User $user, string $category)
    {
        $info = $this->categories[$category];
        $search = request('search');

        $files = Storage::disk('public')->files('documents/' . $info['dir']);

        $documents = collect($files)->map(function ($path) use ($category) {
            $filename = basename($path);

            $openUrl = URL::temporarySignedRoute(
                'documents.open',
                now()->addMinutes(5),
                ['category' => $category, 'filename' => $filename]
            );

            return [
                'name'     => $filename,
                'url'      => Storage::url($path),
                'open_url' => $openUrl,
                'edit_url' => route('documents.edit', [
                    'category' => $category,
                    'filename' => $filename,
                ]),
            ];
        });

        if ($search) {
            $documents = $documents->filter(fn ($doc) =>
                str_contains(strtolower($doc['name']), strtolower($search))
            );
        }

        // Manual pagination
        $perPage = 10;
        $page = request()->get('page', 1);
        $paged = $documents->forPage($page, $perPage);

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $documents->count(),
            $perPage,
            $page,
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

    /**
     * -----------------------------------------
     * OPEN FOR LOCAL HELPER APP (SIGNED URL)
     * -----------------------------------------
     */
    public function open(string $category, string $filename)
    {
        if (! isset($this->categories[$category])) {
            abort(404);
        }

        $info = $this->categories[$category];
        $relative = 'documents/' . $info['dir'] . '/' . $filename;

        if (! Storage::disk('public')->exists($relative)) {
            abort(404, 'PDF not found');
        }

        return Storage::disk('public')->download($relative, $filename);
    }

    /**
     * -----------------------------------------
     * PDF EDITING (iLovePDF)
     * -----------------------------------------
     */
    public function edit(string $category, string $filename)
    {
        $user = Auth::user();

        if (! isset($this->categories[$category])) {
            abort(404);
        }

        $info = $this->categories[$category];
        $relative = 'documents/' . $info['dir'] . '/' . $filename;

        if (! Storage::disk('public')->exists($relative)) {
            abort(404, 'PDF not found');
        }

        $localPath = Storage::disk('public')->path($relative);

        // Init iLovePDF
        $ilovepdf = new Ilovepdf(
            config('services.ilovepdf.public'),
            config('services.ilovepdf.secret')
        );

        $task = $ilovepdf->newTask('editpdf');
        $task->addFile($localPath);

        $text = new TextElement();
        $text->setText('CONFIDENTIAL')
            ->setCoordinates(100, 100)
            ->setFontSize(20)
            ->setFontColor('#FF0000')
            ->setOpacity(60)
            ->setPages(1);

        $task->addElement($text);

        $outputName = pathinfo($filename, PATHINFO_FILENAME) . '_edited';
        $task->setOutputFilename($outputName);

        $task->execute();
        $task->download(Storage::disk('public')->path('documents/' . $info['dir']));

        return redirect()
            ->route('documents.category', $category)
            ->with('status', "Edited PDF created: {$outputName}.pdf");
    }
}
