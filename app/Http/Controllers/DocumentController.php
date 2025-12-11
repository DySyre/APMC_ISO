<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Ilovepdf\Ilovepdf;
use Ilovepdf\Editpdf\TextElement;

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

        return view('documents.index', [
            'user' => $user,
        ]);
    }

    public function category(string $category)
{
    $user = User::find(session('visitor_user_id'));

    if (! isset($this->categories[$category])) {
        abort(404);
    }

    $info = $this->categories[$category];

    // 1. Get search query
    $search = request('search');

    // 2. Fetch all files
    $files = Storage::disk('public')->files('documents/'.$info['dir']);

    // 3. Transform all files into objects
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

    // 4. If searching, filter the collection
    if ($search) {
        $documents = $documents->filter(function ($doc) use ($search) {
            return str_contains(strtolower($doc['name']), strtolower($search));
        });
    }

    // 5. Paginate (15 per page or change as needed)
    $perPage = 10;
    $currentPage = request()->get('page', 1);
    $pagedDocs = $documents->forPage($currentPage, $perPage);

    // Create manual paginator
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
        $pagedDocs,
        $documents->count(),
        $perPage,
        $currentPage,
        [
            'path' => request()->url(),
            'query' => request()->query(),
        ]
    );

    return view('documents.category', [
        'user'          => $user,
        'category'      => $category,
        'categoryLabel' => $info['label'],
        'documents'     => $paginator, // <-- paginate instead of full list
        'search'        => $search,
    ]);
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
