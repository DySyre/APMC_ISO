@extends('layouts.app')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-semibold mb-4">User Management</h1>

    @if(session('status'))
        <div class="mb-4 text-sm text-green-500">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-[#0D0F0A]/90 border border-slate-700 rounded-lg">
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
                        <td class="px-4 py-2">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="px-4 py-2">{{ $user->division }}</td>
                        <td class="px-4 py-2">
                            @if($user->role === 1) Admin
                            @elseif($user->role === 2) Leader
                            @else User @endif
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-400">
                            {{ $user->last_login_at ?? '—' }}
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <select name="role"
                                        class="bg-slate-900 border border-slate-700 text-slate-100 text-xs rounded px-2 py-1">
                                    <option value="1" @selected($user->role === 1)>Admin</option>
                                    <option value="2" @selected($user->role === 2)>Leader</option>
                                    <option value="3" @selected($user->role === 3)>User</option>
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
</main>
@endsection
