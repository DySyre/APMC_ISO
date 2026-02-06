@extends('layouts.app')

@section('content')

<body class="bg-[#0A0C07] text-white font-sans">

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('{{ asset('image/afpbanner.jpg') }}');">
        <div class="absolute inset-0 bg-black/60"></div>

        <div class="relative z-10 max-w-4xl text-center px-6">
            {{-- <h1 class="text-4xl md:text-6xl font-bold mb-6 tracking-wide uppercase">Armed Forces of the Philippines</h1> --}}
            <p class="text-gray-300 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto">
                Dedicated to protecting the sovereignty, peace, and security of the nation.
            </p>
            <div class="mt-10">
                <a href="#mission" class="px-8 py-3 bg-[#C7B98E] text-black rounded-md text-lg font-semibold hover:bg-[#B8A67B] transition">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section id="mission" class="py-20 px-8 max-w-6xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6 tracking-wide">Our Mission</h2>
        <p class="text-gray-300 max-w-3xl mx-auto leading-relaxed text-lg">
            The AFP is committed to securing the freedom and integrity of the Philippine Republic, serving with honor, duty, and loyalty. Our mission extends beyond defense—supporting humanitarian efforts, disaster response, and nation‑building.
        </p>
    </section>

    <!-- Core Values -->
    <section class="py-20 bg-[#0F110C] px-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12 tracking-wide">Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="text-center bg-[#1A1D17] border border-[#3E4636] rounded-xl p-8">
                    <h3 class="text-xl font-semibold mb-3">Honor</h3>
                    <p class="text-gray-400">We uphold the highest moral principles and serve with integrity.</p>
                </div>
                <div class="text-center bg-[#1A1D17] border border-[#3E4636] rounded-xl p-8">
                    <h3 class="text-xl font-semibold mb-3">Duty</h3>
                    <p class="text-gray-400">Our commitment to protect the nation remains steadfast in all circumstances.</p>
                </div>
                <div class="text-center bg-[#1A1D17] border border-[#3E4636] rounded-xl p-8">
                    <h3 class="text-xl font-semibold mb-3">Loyalty</h3>
                    <p class="text-gray-400">We serve with unyielding loyalty to the country and its people.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Branches -->
    <section class="py-20 px-8 max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12 tracking-wide">Branches of Service</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-[#1A1D17] border border-[#3E4636] rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-2">Philippine Army</h3>
                <p class="text-gray-400">Ground forces responsible for defending the nation and ensuring internal stability.</p>
            </div>

            <div class="bg-[#1A1D17] border border-[#3E4636] rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-2">Philippine Navy</h3>
                <p class="text-gray-400">Maritime defense ensuring territorial integrity across Philippine waters.</p>
            </div>

            <div class="bg-[#1A1D17] border border-[#3E4636] rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-2">Philippine Air Force</h3>
                <p class="text-gray-400">Air defense capabilities securing national airspace and conducting aerial missions.</p>
            </div>
        </div>
    </section>

@endsection