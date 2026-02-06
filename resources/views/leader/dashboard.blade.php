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
                            @elseif($user->role === 2) Division Chief
                            @elseif($user->role === 3) Process Owner
                            @else User @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(session('status'))
    <div class="mb-4 rounded border border-emerald-600/30 bg-emerald-500/10 px-4 py-2 text-sm text-emerald-200">
        {{ session('status') }}
    </div>
@endif

<div class="bg-[#0D0F0A]/90 border border-slate-700 rounded-lg p-4 my-6">
    <h2 class="text-lg font-semibold text-slate-200 mb-2">Division Category Access</h2>
    <p class="text-xs text-slate-400 mb-4">
        Division: <span class="text-slate-200 font-medium">{{ $leader->division }}</span>
    </p>

    <form method="POST" action="{{ route('leader.access.update') }}">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($categories as $slug => $label)
                <label class="flex items-center gap-2 bg-slate-900/40 border border-slate-800 rounded-md px-3 py-2 hover:border-[#C7B98E]">
                    <input type="checkbox"
                           name="categories[]"
                           value="{{ $slug }}"
                           @checked(in_array($slug, $allowed))
                           class="rounded border-slate-600 bg-slate-950 text-[#C7B98E] focus:ring-[#C7B98E]" />
                    <span class="text-sm text-slate-200">{{ $label }}</span>
                </label>
            @endforeach
        </div>

        <button class="mt-4 px-4 py-2 rounded bg-[#C7B98E] text-black font-semibold hover:bg-[#B8A67B]">
            Save Access
        </button>
    </form>
</div>

</main>
@endsection
