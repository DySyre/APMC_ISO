@extends('layouts.app')

@section('content')
<main class="max-w-5xl mx-auto px-6 py-10">

    {{-- SUMMARY CARDS --}}
    <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-slate-900/60 border border-slate-700 rounded-lg p-4">
            <div class="text-xs text-slate-400 mb-1">Total Personnel</div>
            <div class="text-2xl font-bold">{{ $totalUsers }}</div>
        </div>
        <div class="bg-slate-900/60 border border-slate-700 rounded-lg p-4">
            <div class="text-xs text-slate-400 mb-1">Leaders</div>
            <div class="text-2xl font-bold">{{ $totalLeaders }}</div>
        </div>
        <div class="bg-slate-900/60 border border-slate-700 rounded-lg p-4">
            <div class="text-xs text-slate-400 mb-1">Admins</div>
            <div class="text-2xl font-bold">{{ $totalAdmins }}</div>
        </div>
    </div>

    <div class="mt-8 mb-6">
        <a href="{{ route('admin.users.index') }}"
           class="inline-block px-4 py-2 text-sm rounded-md bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B]">
            Manage Users & Roles
        </a>
    </div>

    @include('partials.adminfolder')

</main>
@endsection
