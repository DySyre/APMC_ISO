@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-semibold mb-2">Documents Portal</h1>
    <p class="text-sm text-slate-400 mb-6">
        Welcome, {{ $user->first_name }} {{ $user->last_name }} • Division: {{ $user->division }}
    </p>

    <div class="bg-[#0D0F0A]/90 border border-slate-700 rounded-lg p-4">
        <p class="text-slate-300 text-sm">
            This is where you’ll later see the list of PDF documents available to you based on your division and approvals.
        </p>
        @if(empty($documents))
            <p class="mt-3 text-xs text-slate-500">
                No documents configured yet. Admin can upload and assign documents from the admin panel.
            </p>
        @endif
    </div>
</main>
@endsection
