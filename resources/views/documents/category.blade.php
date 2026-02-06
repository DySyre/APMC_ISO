@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-semibold mb-2">
        {{ $categoryLabel }} Documents
    </h1>

    <p class="text-sm text-slate-400 mb-4">
        {{ $user->first_name }} {{ $user->last_name }} • Division: {{ $user->division }}
    </p>

    <a href="{{ route('documents.index') }}" class="text-xs text-[#C7B98E] hover:underline cursor-pointer">
        ← Back to Categories
    </a>

    <form method="GET" action="{{ route('documents.category', $category) }}" class="mb-4">
        <div class="flex gap-2">
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search documents..."
                class="w-full px-3 py-2 text-sm rounded bg-[#11140e] border border-slate-700 text-slate-200 focus:border-[#C7B98E] focus:ring-0">
            
            <button class="px-4 py-2 text-sm rounded bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B] cursor-pointer">
                Search
            </button>
        </div>
    </form>


    <div class="mt-4 bg-[#0D0F0A]/90 border border-slate-700 rounded-lg p-4">
        @if($documents->isEmpty())
            <p class="text-sm text-slate-400">
                No documents available yet in this category.
            </p>
        @else
            <ul class="divide-y divide-slate-800 text-sm">
                @foreach ($documents as $doc)
                   <li class="flex items-center justify-between py-2">
                        <div>
                            <p class="text-slate-100 font-medium">
                                {{ $doc['name'] }}
                            </p>
                            <p class="text-xs text-slate-500">
                                PDF Document
                            </p>
                        </div>

                        <div class="flex items-center gap-2">

                            {{-- EDIT PDF --}}
                            {{-- <form method="POST" action="{{ $doc['edit_url'] }}">
                                @csrf
                                <button
                                    type="submit"
                                   class="text-xs px-3 py-1 rounded bg-amber-500 text-black font-semibold hover:bg-amber-400">
                                    Edit PDF
                                </button>
                            </form> --}}

                            {{-- Open in Local App (requires helper app) --}}
                            <a href="apmc://open?url={{ urlencode($doc['open_url']) }}"
                               class="text-xs px-3 py-1 rounded bg-amber-500 text-black font-semibold hover:bg-amber-400"
                               title="Opens via the APMC helper app, then your local PDF editor.">
                                Open in App
                            </a>

                            {{-- VIEW --}}
                            <a href="{{ $doc['url'] }}"
                               target="_blank"
                               class="text-xs px-3 py-1 rounded bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B]"
                               title="View PDF">
                                <x-eye-icon />
                            </a>

                            {{-- Download PDF --}}
                            <a href="{{ $doc['url'] }}"
                               download="{{ $doc['name'] }}"
                               class="text-xs px-3 py-1 rounded bg-amber-500/80 text-black font-semibold hover:bg-amber-400"
                               title="Download PDF">
                                <x-download-icon />
                            </a>

                        </div>
                    </li>
                @endforeach
                <div class="mt-4">
                    {{ $documents->links('pagination::tailwind') }}
                </div>
            </ul>
        @endif
        
    </div>
</main>
@endsection
