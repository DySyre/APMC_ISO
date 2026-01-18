@extends('layouts.app')

@section('content')

<main class="flex-1 flex items-center justify-center px-6 py-10">
        {{-- Visitor Identity Form --}}
        <section class="relative z-10 py-14 bg-[#0D0F0A]/90 border-t border-[#2F3426]">
            <div class="max-w-xl mx-auto px-6">

            <h2 class="text-center text-2xl font-semibold text-white mb-8 tracking-wide">
                Registration Page
            </h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- First Name --}}
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" 
                        type="text" name="first_name" :value="old('first_name')" required autofocus />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                {{-- Last Name --}}
                <div class="mt-4">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" 
                        type="text" name="last_name" :value="old('last_name')" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                {{-- Badge Number --}}
                <div class="mt-4">
                    <x-input-label for="badge_number" :value="__('Badge Number')" />
                    <x-text-input id="badge_number" 
                        type="text" name="badge_number" :value="old('badge_number')" required />
                    <x-input-error :messages="$errors->get('badge_number')" class="mt-2" />
                </div>

                {{-- Division (Dropdown) --}}
                <div class="mt-4">
                    <x-input-label for="division" :value="__('Division')" />

                    <select id="division" name="division"
                        class="block mt-1 w-full bg-[#1A1D17] border border-[#3E4636] text-gray-100 px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] outline-none" bg-white border-gray-300 rounded-md shadow-smfocus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Select Division --</option>
                        <option value="HR">HR</option>
                        <option value="Finance">Finance</option>
                        <option value="Logistics">Logistics</option>
                        <option value="Operations">Operations</option>
                        <option value="IT">IT</option>
                    </select>

                    <x-input-error :messages="$errors->get('division')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" 
                        type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" 
                        type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirm Password --}}
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" 
                        type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-center mt-4">
                    {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a> --}}

                    <x-primary-button class="ms-4 cursor-pointer px-8 py-3.5 bg-[#C7B98E] text-black font-semibold rounded-md shadow-md">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            {{-- Link to Login --}}
            <p class="mt-4 text-center text-sm text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#C7B98E] hover:underline font-medium">
                    Log in here
                </a>
            </p>

            <p class="mt-6 text-center text-[12px] text-gray-500 tracking-wide">
                Unauthorized personnel are subject to monitoring and access restrictions
            </p>

        </div>
    </section>
</main>

@endsection