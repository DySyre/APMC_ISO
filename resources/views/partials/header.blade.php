{{-- in <head> --}}
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

{{-- in <body> --}}
<header class="relative z-10 border-b border-green-900/60 bg-black/80 backdrop-blur">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            {{-- LOGO placeholder --}}
            <div class="flex items-center">
                <img src="{{ asset('image/pa-logo.png') }}"
                    alt="PA Logo"
                    class="h-14 w-auto object-contain">
            </div> 

        {{-- 
            <div>
                <div class="text-xs uppercase tracking-[0.2em] text-green-400">Philippine Army</div>
                <div class="text-sm font-semibold text-gray-100">
                    Serving the People, Securing the Land
                </div>
            </div> --}}
        </div>

        <nav class="hidden md:flex items-center gap-6 text-xs font-medium tracking-wide">
            <a href="{{ url('/') }}" class="hover:text-green-300 transition">HOME</a>
            <a href="#about" class="hover:text-green-300 transition">ABOUT</a>
            <a href="#features" class="hover:text-green-300 transition">FEATURES</a>
            <a href="#contact" class="hover:text-green-300 transition">CONTACT</a>
        </nav>
        {{-- Theme Switch --}}
            <button id="themeToggle"
                class="px-3 py-1 text-xs rounded border border-gray-400/50 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Toggle Theme
            </button>
    </div>
</header>