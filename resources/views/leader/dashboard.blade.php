@extends('layouts.app')

@section('content')
<main class="max-w-5xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-semibold mb-2">Leader Dashboard</h1>
    <p class="text-sm text-slate-400 mb-6">
        Division: <span class="font-semibold">{{ $leader->division }}</span>
    </p>

    <h2 class="text-lg font-semibold mb-3">Division Personnel</h2>

    <div class="overflow-x-auto bg-[#0D0F0A]/90 border border-slate-700 rounded-lg">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-900 border-b border-slate-700">
                <tr>
                    <th class="px-4 py-2 text-left">Badge</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($divisionUsers as $user)
                    <tr class="border-b border-slate-800">
                        <td class="px-4 py-2 font-mono">{{ $user->badge_number }}</td>
                        <td class="px-4 py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="px-4 py-2">
                            @if($user->role === 1) Admin
                            @elseif($user->role === 2) Leader
                            @else User @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
