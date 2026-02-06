@extends('layouts.app')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-semibold mb-4">User Management</h1>

    <a href="{{ route('admin.dashboard') }}" class="text-xs text-[#C7B98E] hover:underline">
        ← Back to Admin Dashboard
    </a>

    @if(session('status'))
        <div class="mt-3 mb-4 text-sm text-green-500">
            {{ session('status') }}
        </div>
    @endif

    @php
        $divisionOptions = [
            'Infantry',
            'Scout Ranger',
            'AirForce',
            'Management',
            'Radio',
            'Intel',
        ];
    @endphp

    <div class="mt-4 overflow-x-auto bg-[#0D0F0A]/90 border border-slate-700 rounded-lg">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-900 border-b border-slate-700">
                <tr>
                    <th class="px-4 py-2 text-left">Badge</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Division</th>
                    <th class="px-4 py-2 text-left">Role</th>
                    <th class="px-4 py-2 text-left">Last Login</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr class="border-b border-slate-800">
                        <td class="px-4 py-2 font-mono">{{ $user->badge_number }}</td>

                        <td class="px-4 py-2">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </td>

                        {{-- SHOW CURRENT DIVISION TEXT (optional, remove if you only want dropdown) --}}
                        <td class="px-4 py-2">
                            {{ $user->division ?? '—' }}
                        </td>

                        <td class="px-4 py-2">
                            @if((int)$user->role === 1) Admin
                            @elseif((int)$user->role === 2) Leader
                            @else User
                            @endif
                        </td>

                        <td class="px-4 py-2 text-xs text-slate-400">
                            {{ $user->last_login_at ?? '—' }}
                        </td>
                        
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.users.updateRole', $user) }}"
                                  method="POST"
                                  class="flex flex-col sm:flex-row sm:items-center gap-2">
                                @csrf

                                {{-- ROLE --}}
                                <select name="role"
                                        class="bg-slate-900 border border-slate-700 text-slate-100 text-xs rounded px-2 py-1">
                                    <option value="1" @selected((int)$user->role === 1)>Admin</option>
                                    <option value="2" @selected((int)$user->role === 2)>Leader</option>
                                    <option value="3" @selected((int)$user->role === 3)>User</option>
                                </select>

                                {{-- DIVISION (for all users) --}}
                                <select name="division"
                                        class="bg-slate-900 border border-slate-700 text-slate-100 text-xs rounded px-2 py-1">
                                    <option value="" @selected(blank($user->division))>— None —</option>
                                    @foreach($divisionOptions as $division)
                                        <option value="{{ $division }}" @selected($user->division === $division)>
                                            {{ $division }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit"
                                        class="text-xs px-3 py-1 rounded bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B]">
                                    Save
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- This is for the leader_category --}}

    @php
    $categories = [
        'admin' => 'Admin',
        'personnel-services' => 'Personnel Services',
        'recruitment-division' => 'Recruitment Division',
        'career-management' => 'Career Management',
        'enlisted-personnel-class-advisory' => 'Enlisted Personnel Class Advisory',
        'officer-career-advisory' => 'Officer Career Advisory',
    ];

    $leaders = $users->filter(fn($u) => (int)$u->role === 2);
@endphp

@if($leaders->count())
    <div class="mt-6 bg-[#0D0F0A]/90 border border-slate-700 rounded-lg p-4">
        <h2 class="text-lg font-semibold text-slate-200 mb-3">
            Leader Category Assignment
        </h2>

        <p class="text-xs text-slate-400 mb-4">
            Assign each leader to exactly one category (one leader per category).
        </p>

        <div class="space-y-3">
            @foreach($leaders as $leader)
                <form method="POST"
                      action="{{ route('admin.users.updateLeaderCategory', $leader) }}"
                      class="flex flex-col md:flex-row md:items-center gap-2 border border-slate-800 rounded-lg p-3 bg-slate-900/40">
                    @csrf

                    <div class="flex-1">
                        <div class="text-sm text-slate-100 font-medium">
                            {{ $leader->first_name }} {{ $leader->last_name }}
                            <span class="text-xs text-slate-400 font-normal">({{ $leader->badge_number }})</span>
                        </div>
                        <div class="text-xs text-slate-400">
                            Division: {{ $leader->division }}
                        </div>
                    </div>

                    <select name="leader_category"
                            class="bg-slate-900 border border-slate-700 text-slate-100 text-xs rounded px-2 py-2 w-full md:w-72">
                        <option value="" disabled @selected(!$leader->leader_category)>-- Select Category --</option>
                        @foreach($categories as $slug => $label)
                            <option value="{{ $slug }}" @selected($leader->leader_category === $slug)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                            class="text-xs px-4 py-2 rounded bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B]">
                        Save
                    </button>
                </form>
            @endforeach
        </div>
    </div>
@endif
</main>
@endsection
</main>





{{-- This is for Division Management of Leader --}}
{{-- @php
$divisionOptions = [
    'Infantry',
    'Scout Ranger',
    'AirForce',
    'Management',
    'Radio',
    'Intel',
    'Artillery',
    'Medical Corps',
];
@endphp

@if($leaders->count())
    <div class="mt-6 bg-[#0D0F0A]/90 border border-slate-700 rounded-lg p-4">
        <h2 class="text-lg font-semibold text-slate-200 mb-3">
            Leader Division Assignment
        </h2>

        <p class="text-xs text-slate-400 mb-4">
            Assign which division a leader supervises.
        </p>

        <div class="space-y-3">
            @foreach($leaders as $leader)
                <form method="POST"
                      action="{{ route('admin.users.updateDivision', $leader) }}"
                      class="flex flex-col md:flex-row md:items-center gap-3 border border-slate-800 rounded-lg p-3 bg-slate-900/40">
                    @csrf

                    <div class="flex-1">
                        <div class="text-sm text-slate-100 font-medium">
                            {{ $leader->first_name }} {{ $leader->last_name }}
                            <span class="text-xs text-slate-400 font-normal">
                                ({{ $leader->badge_number }})
                            </span>
                        </div>
                        <div class="text-xs text-slate-400">
                            Current Division: {{ $leader->division ?? '—' }}
                        </div>
                    </div>

                    <select name="division"
                            class="bg-slate-900 border border-slate-700 text-slate-100 text-xs rounded px-2 py-2 w-full md:w-72">
                        @foreach($divisionOptions as $division)
                            <option value="{{ $division }}"
                                @selected($leader->division === $division)>
                                {{ $division }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                            class="text-xs px-4 py-2 rounded bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B]">
                        Save
                    </button>
                </form>
            @endforeach
        </div>
    </div>
@endif --}}
