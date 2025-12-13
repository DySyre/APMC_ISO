@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-semibold mb-2">
        {{ $categoryLabel }} Documents
    </h1>

    <p class="text-sm text-slate-400 mb-4">
        {{ $user->first_name }} {{ $user->last_name }} • Division: {{ $user->division }}
    </p>

    {{-- Back to Admin Dashboard (not user documents.index) --}}
    <a href="{{ route('admin.dashboard') }}" class="text-xs text-[#C7B98E] hover:underline">
        ← Back to Admin Dashboard
    </a>

    {{-- Search (admin route) --}}
    <form method="GET" action="{{ route('admin.admincategory', $category) }}" class="my-4">
        <div class="flex gap-2">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search documents..."
                   class="w-full px-3 py-2 text-sm rounded bg-[#11140e] border border-slate-700 text-slate-200 focus:border-[#C7B98E] focus:ring-0">

            <button class="px-4 py-2 text-sm rounded bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B]">
                Search
            </button>
        </div>
    </form>

    @if (session('status'))
        <div class="mb-4 rounded-md border border-emerald-600/30 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-200">
            {{ session('status') }}
        </div>
    @endif

    {{-- Upload --}}
    <div class="mb-6 rounded-lg border border-slate-700 bg-slate-900/40 p-4">
        <h2 class="text-lg font-semibold mb-3">Upload PDF to {{ $categoryLabel }}</h2>

        <form method="POST"
              action="{{ route('admin.upload', $category) }}"
              enctype="multipart/form-data"
              class="flex flex-col sm:flex-row gap-3">
            @csrf

            <input type="file" name="pdf" accept="application/pdf"
                   class="block w-full text-sm text-slate-300
                          file:mr-4 file:rounded-md file:border-0
                          file:bg-[#C7B98E] file:px-4 file:py-2 file:text-black file:font-semibold
                          hover:file:bg-[#B8A67B]">

            <button type="submit"
                    class="rounded-md bg-[#C7B98E] px-4 py-2 text-sm font-semibold text-black hover:bg-[#B8A67B]">
                Upload
            </button>
        </form>

        @error('pdf')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Documents list --}}
    <div class="mt-4 bg-[#0D0F0A]/90 border border-slate-700 rounded-lg p-4">
        @if($documents->isEmpty())
            <p class="text-sm text-slate-400">No documents available yet in this category.</p>
        @else
            <ul class="divide-y divide-slate-800 text-sm">
                @foreach ($documents as $doc)
                    <li class="flex items-center justify-between py-2">
                        <div>
                            <p class="text-slate-100 font-medium">{{ $doc['name'] }}</p>
                            <p class="text-xs text-slate-500">PDF Document</p>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- VIEW --}}
                            <a href="{{ $doc['url'] }}"
                               class="text-xs px-3 py-1 rounded bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B]"
                               target="_blank">
                                View
                            </a>

                            {{-- DOWNLOAD --}}
                            <a href="{{ $doc['url'] }}" download="{{ $doc['name'] }}"
                               class="text-xs px-3 py-1 rounded bg-amber-500 text-black font-semibold hover:bg-amber-400">
                                Download
                            </a>

                            {{-- DELETE --}}
                            <form method="POST"
                                  action="{{ route('admin.delete', ['category' => $category, 'filename' => $doc['name']]) }}"
                                  onsubmit="return confirm('Delete {{ $doc['name'] }}? This cannot be undone.')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-xs px-3 py-1 rounded border border-red-500/40 text-red-300 hover:bg-red-600/20">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $documents->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</main>
@endsection
