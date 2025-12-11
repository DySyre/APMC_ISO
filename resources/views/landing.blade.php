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
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Badge Number</label>
                            <input type="text" name="badge_number" id="badge_number"
                                class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] outline-none"
                                placeholder="e.g. 20231457" required>
                        </div>

                       {{-- Confirm Badge Number --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Confirm Badge Number</label>

                            <div class="relative">
                                <input type="text" name="badge_number_confirmation" id="badge_number_confirmation"
                                    class="w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] outline-none pr-10"
                                    placeholder="Re-enter Badge Number" required>

                                {{-- Icon container --}}
                                <span id="badge-icon" class="absolute right-3 top-1/2 -translate-y-1/2 hidden"></span>
                            </div>

                            <p id="badge-match-message" class="text-sm mt-1"></p>
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
                        <button type="submit" id="submit-btn"
                            class="px-8 py-3.5 bg-[#C7B98E] text-black font-semibold rounded-md shadow-md hover:bg-[#B8A67B] transition disabled:opacity-40 disabled:cursor-not-allowed"
                            disabled>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const badge = document.getElementById('badge_number');
    const badgeConfirm = document.getElementById('badge_number_confirmation');
    const message = document.getElementById('badge-match-message');
    const icon = document.getElementById('badge-icon');
    const submitBtn = document.getElementById('submit-btn');

    function validateBadge() {
        const filled = badge.value !== '' && badgeConfirm.value !== '';
        const match = badge.value === badgeConfirm.value;

        // Reset visual state if confirm field is empty
        if (!filled) {
            message.textContent = '';
            icon.classList.add('hidden');
            submitBtn.disabled = true;
            return;
        }

        if (match) {
            message.textContent = 'Badge numbers match';
            message.classList.add('text-green-500');
            message.classList.remove('text-red-500');

            icon.innerHTML = `
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round"
                           d="M5 13l4 4L19 7" />
                </svg>`;
            icon.classList.remove('hidden');

            submitBtn.disabled = false; // enable
        } else {
            message.textContent = 'Badge numbers do not match';
            message.classList.add('text-red-500');
            message.classList.remove('text-green-500');

            icon.innerHTML = `
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round"
                           d="M6 18L18 6M6 6l12 12" />
                </svg>`;
            icon.classList.remove('hidden');

            submitBtn.disabled = true; // lock
        }
    }

    badge.addEventListener('input', validateBadge);
    badgeConfirm.addEventListener('input', validateBadge);
});
</script>