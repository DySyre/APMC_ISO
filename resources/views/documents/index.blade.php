@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-semibold mb-2">Documents Portal</h1>
    <p class="text-sm text-slate-400 mb-6">
        Welcome, {{ $user->first_name }} {{ $user->last_name }} • Division: {{ $user->division }}
    </p>

    @include('partials.folder')
</main>
@endsection


        <!-- EMPTY SLOT TEMPLATE (will repeat for unused spaces) -->
        {{-- @for ($i = 0; $i < 7; $i++)
            <div class="bg-[#0D0F0A]/50 border border-slate-700 rounded-lg p-5 flex flex-col items-center justify-center opacity-40">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-8 h-8 text-slate-600"
                     fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 7h4l2 3h10v9H3V7z" />
                </svg>
                <p class="mt-2 text-xs text-slate-600">Coming Soon</p>
            </div>
        @endfor --}}

        {{-- <p class="text-slate-300 text-sm">
            This is where you’ll later see the list of PDF documents available to you based on your division and approvals.
        </p>
        @if(empty($documents))
            <p class="mt-3 text-xs text-slate-500">
                No documents configured yet. Admin can upload and assign documents from the admin panel.
            </p>
        @endif --}}