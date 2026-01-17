@extends('layouts.app')

@section('content')

    {{-- MAIN HERO --}}
    <main class="flex-1 flex items-center justify-center px-6 py-10">
        {{-- Visitor Identity Form --}}
        <section class="relative z-10 py-14 bg-[#0D0F0A]/90 border-t border-[#2F3426]">
            <div class="max-w-xl mx-auto px-6">

                <h2 class="text-center text-2xl font-semibold text-[#ffffff] mb-8 tracking-wide">
                    Personnel Access Verification
                </h2>

                <form action="{{ route('visitor.enter') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- First & Last Name --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- First Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">First Name</label>
                                <input type="text" name="first_name"
                                    class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] outline-none"
                                    placeholder="Juan" required>
                            </div>

                            {{-- Last Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Last Name</label>
                                <input type="text" name="last_name"
                                    class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] outline-none"
                                    placeholder="Dela Cruz" required>
                            </div>
                        </div>

                    {{-- Badge Number --}}
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Badge Number</label>
                        <input type="text" name="badge_number" id="badge_number"
                            class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] outline-none"
                            placeholder="e.g. 20231457" required>

                        {{-- Icon --}}
                        <span id="badge-icon"
                            class="absolute right-3 top-1/2 -translate-y-1/2 hidden"></span>
                    </div>


                      {{-- Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">
                                Password
                            </label>

                            <input type="password"
                                name="password"
                                id="password"
                                class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md
                                        focus:ring-2 focus:ring-[#C7B98E] outline-none"
                                placeholder="Enter your secure password"
                                required>
                        </div>
                        <p id="badge-match-message" class="text-sm mt-1"></p>

                                {{-- Icon container --}}
                                <span id="badge-icon" class="absolute right-3 top-1/2 -translate-y-1/2 hidden"></span>
                            </div>

                            <p id="badge-match-message" class="text-sm mt-1"></p>
                        </div>

                    {{-- Submit --}}
                    <div class="text-center pt-4">
                        <button type="submit" id="submit-btn"
                            class="px-8 py-3.5 bg-[#C7B98E] text-black font-semibold rounded-md shadow-md hover:bg-[#B8A67B] transition disabled:opacity-40 disabled:cursor-not-allowed"
                            disabled>
                        Login
                        </button>
                    </div>
                </form>

                <p class="mt-4 text-center text-sm text-gray-400">
                    No account yet?
                    <a href="{{ route('register') }}"
                    class="text-[#C7B98E] hover:underline font-medium">
                        Register here
                    </a>
                </p>

                <p class="mt-6 text-center text-[12px] text-gray-500 tracking-wide">
                    Unauthorized personnel are subject to monitoring and access restrictions
                </p>
            </div>
        </section>

@endsection