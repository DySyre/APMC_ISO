@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-semibold mb-2">Documents Portal</h1>
    <p class="text-sm text-slate-400 mb-6">
        Welcome, {{ $user->first_name }} {{ $user->last_name }} • Division: {{ $user->division }}
    </p>

    <div class="bg-[#0D0F0A]/90 border border-slate-700 rounded-lg p-4">
        <div class="mt-2">

            <!-- GRID TITLE -->
            <h4 class="text-lg font-semibold text-slate-200 mb-4">Document Categories</h4>

            <!-- 3x3 GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <!-- CATEGORY 1 -->
                <a href="{{ route('documents.category', 'admin') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition"
                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7h4l2 3h10v9H3V7z" />
                    </svg>
                    <p class="mt-3 font-medium text-slate-200">Admin</p>
                </a>

                <!-- CATEGORY 2 -->
                <a href="{{ route('documents.category', 'personnel-services') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition"
                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7h4l2 3h10v9H3V7z" />
                    </svg>
                    <p class="mt-3 font-medium text-slate-200">Personnel Services</p>
                </a>

                <!-- CATEGORY 3 -->
                <a href="{{ route('documents.category', 'recruitment-division') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition"
                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7h4l2 3h10v9H3V7z" />
                    </svg>
                    <p class="mt-3 font-medium text-slate-200">Recruitment Division</p>
                </a>

                <!-- CATEGORY 4 -->
                <a href="{{ route('documents.category', 'career-management') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition"
                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7h4l2 3h10v9H3V7z" />
                    </svg>
                    <p class="mt-3 font-medium text-slate-200">Career Management</p>
                </a>

                <!-- CATEGORY 5 -->
                <a href="{{ route('documents.category', 'enlisted-personnel-class-advisory') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition"
                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7h4l2 3h10v9H3V7z" />
                    </svg>
                    <p class="mt-3 font-medium text-slate-200">Enlisted Personnel Class Advisory</p>
                </a>

                <!-- CATEGORY 6 -->
                <a href="{{ route('documents.category', 'officer-career-advisory') }}" 
                   class="group bg-[#11140e] border border-[#3E4636] hover:border-[#C7B98E] rounded-lg p-5 flex flex-col items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-20 h-20 text-[#C7B98E] group-hover:text-white transition"
                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7h4l2 3h10v9H3V7z" />
                    </svg>
                    <p class="mt-3 font-medium text-slate-200">Officer Career Advisory</p>
                </a>

            </div>
        </div>
    </div>
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