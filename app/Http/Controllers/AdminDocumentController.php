<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDocumentController extends Controller
{
    protected array $categories = [
        'admin'                             => ['label' => 'Admin', 'dir' => 'admin'],
        'personnel-services'                => ['label' => 'Personnel Services', 'dir' => 'personnel-services'],
        'recruitment-division'              => ['label' => 'Recruitment Division', 'dir' => 'recruitment-division'],
        'career-management'                 => ['label' => 'Career Management', 'dir' => 'career-management'],
        'enlisted-personnel-class-advisory' => ['label' => 'Enlisted Personnel Class Advisory', 'dir' => 'enlisted-personnel-class-advisory'],
        'officer-career-advisory'           => ['label' => 'Officer Career Advisory', 'dir' => 'officer-career-advisory'],
    ];

    public function category(string $category)
    {
        $user = auth()->user();  // ← FIXED

        if (! $user || $user->role !== User::ROLE_ADMIN) {
            abort(403, 'Unauthorized');
        }

        if (! isset($this->categories[$category])) {
            abort(404);
        }

        $info = $this->categories[$category];
        $search = request('search');

        $files = Storage::disk('public')->files('documents/' . $info['dir']);

        $documents = collect($files)->map(function ($path) use ($category) {
            $name = basename($path);
            return [
                'name'       => $name,
                'url'        => Storage::url($path),
                'delete_url' => route('admin.delete', [
                    'category' => $category,
                    'filename' => $name,
                ]),
            ];
        });

        if ($search) {
            $documents = $documents->filter(fn($doc) =>
                str_contains(strtolower($doc['name']), strtolower($search))
            );
        }

        // Pagination
        $perPage = 10;
        $page = request()->get('page', 1);
        $paged = $documents->values()->forPage($page, $perPage);

        $paginator = new LengthAwarePaginator(
            $paged,
            $documents->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.admincategory', [
            'user'          => $user,
            'category'      => $category,
            'categoryLabel' => $info['label'],
            'documents'     => $paginator,
            'search'        => $search,
        ]);
    }

    public function upload(Request $request, string $category)
    {
        if (! isset($this->categories[$category])) abort(404);

        $request->validate([
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ]);

        $info = $this->categories[$category];
        $folder = 'documents/' . $info['dir'];

        $originalName = $request->file('pdf')->getClientOriginalName();
        Storage::disk('public')->putFileAs($folder, $request->file('pdf'), $originalName);

        return back()->with('status', "Uploaded: {$originalName}");
    }

    public function destroy(string $category, string $filename)
    {
        if (! isset($this->categories[$category])) abort(404);

        $info = $this->categories[$category];
        $filename = basename($filename);

        $path = 'documents/' . $info['dir'] . '/' . $filename;

        if (! Storage::disk('public')->exists($path)) {
            return back()->with('status', "File not found: {$filename}");
        }

        Storage::disk('public')->delete($path);

        return back()->with('status', "Deleted: {$filename}");
    }
}
