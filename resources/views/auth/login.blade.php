@extends('layouts.app')

@section('content')

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<main class="flex-1 flex items-center justify-center px-6 py-10">
        {{-- Visitor Identity Form --}}
        <section class="relative z-10 py-14 bg-[#0D0F0A]/90 border-t border-[#2F3426]">
            <div class="max-w-xl mx-auto px-6">

                <h2 class="text-center text-2xl font-semibold text-[#ffffff] mb-8 tracking-wide">
                    Personnel Access Verification
                </h2>

             <form method="POST" action="{{ route('visitor.enter') }}" class="space-y-6">
                @csrf

                {{-- Badge Number --}}
                <div class="relative">
                    <x-input-label for="badge_number" :value="__('Badge Number')" />
                    <x-text-input
                        id="badge_number"
                        class="block mt-1 w-full bg-[#1A1D17] border border-[#3E4636]
                               text-gray-100 px-4 py-2.5 rounded-md focus:ring-2
                               focus:ring-[#C7B98E] outline-none"
                        type="text"
                        name="badge_number"
                        :value="old('badge_number')"
                        required />
                    <x-input-error :messages="$errors->get('badge_number')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full bg-[#1A1D17] border border-[#3E4636]
                               text-gray-100 px-4 py-2.5 rounded-md focus:ring-2
                               focus:ring-[#C7B98E] outline-none"
                        type="password"
                        name="password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center text-gray-400 text-sm">
                        <input id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-500 bg-[#1A1D17] text-[#C7B98E]
                                   focus:ring-[#C7B98E]" name="remember">
                        <span class="ml-2">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-[#C7B98E] hover:underline"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="text-center pt-4">
                    <x-primary-button
                        class="px-8 py-3.5 bg-[#C7B98E] text-black font-semibold rounded-md shadow-md
                               hover:bg-[#B8A67B] transition cursor-pointer">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            {{-- Register --}}
            <p class="mt-4 text-center text-sm text-gray-400">
                No account yet?
                <a href="{{ route('register') }}" class="text-[#C7B98E] hover:underline font-medium">
                    Register here
                </a>
            </p>

            <p class="mt-6 text-center text-[12px] text-gray-500 tracking-wide">
                Unauthorized personnel are subject to monitoring and access restrictions
            </p>

        </div>
    </section>
</main>

@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    const badge = document.getElementById('badge_number');
    const password = document.getElementById('password');
    const message = document.getElementById('badge-match-message');
    const icon = document.getElementById('badge-icon');
    const submitBtn = document.getElementById('submit-btn');

    function validateForm() {
        const badgeFilled = badge.value.trim() !== '';
        const passwordFilled = password.value.trim() !== '';

        if (!badgeFilled || !passwordFilled) {
            submitBtn.disabled = true;
            message.textContent = '';
            icon.classList.add('hidden');
            return;
        }

        // Visual confirmation (optional but clean UX)
        message.textContent = 'Credentials ready';
        message.classList.remove('text-red-500');
        message.classList.add('text-green-500');

        icon.innerHTML = `
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round"
                       d="M5 13l4 4L19 7" />
            </svg>`;
        icon.classList.remove('hidden');

        submitBtn.disabled = false;
    }

    badge.addEventListener('input', validateForm);
    password.addEventListener('input', validateForm);
});
</script> 