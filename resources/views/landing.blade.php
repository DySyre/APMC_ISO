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

                    {{-- Full Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                        <input type="text" name="name"
                            class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] focus:border-[#C7B98E] outline-none"
                            placeholder="Juan Dela Cruz" required>
                    </div>

                    {{-- Badge Number --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Badge Number</label>
                        <input type="text" name="badge_number"
                            class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] focus:border-[#C7B98E] outline-none"
                            placeholder="e.g. 20231457" required>
                    </div>

                    {{-- Division --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Division</label>
                        <select name="division"
                                class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] focus:border-[#C7B98E] outline-none"
                                required>
                            <option value="" disabled selected>-- Select Division --</option>
                            <option>Infantry</option>
                            <option>Artillery</option>
                            <option>Armor</option>
                            <option>Engineering</option>
                            <option>Intelligence</option>
                            <option>Communications</option>
                            <option>Logistics</option>
                            <option>Medical Corps</option>
                            <option>Others</option>
                        </select>
                    </div>

                    {{-- Submit --}}
                    <div class="text-center pt-4">
                        <button type="submit"
                                class="px-8 py-3.5 bg-[#C7B98E] text-black font-semibold rounded-md shadow-md hover:bg-[#B8A67B] transition">
                            Proceed to Portal
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-[12px] text-gray-500 tracking-wide">
                    Unauthorized personnel are subject to monitoring and access restrictions
                </p>
            </div>
        </section>

@endsection