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
            {{-- <a href="{{ url('/') }}" class="hover:text-green-300 transition">HOME</a>
            <a href="#about" class="hover:text-green-300 transition">ABOUT</a>
            <a href="#features" class="hover:text-green-300 transition">FEATURES</a>
            <a href="#contact" class="hover:text-green-300 transition">CONTACT</a> --}}
        </nav>

        <div class="flex items-center gap-4">

    @auth
        {{-- LOGOUT (POST method required by Laravel) --}}
        {{-- <form method="POST" action="{{ route('landing') }}">
            @csrf
            <button
                type="submit"
                class="px-4 py-1.5 text-xs rounded border border-red-500/40 
                       text-red-300 hover:bg-red-600/20 transition">
                Logout
            </button>
        </form> --}}
    @else
        {{-- LOGIN --}}
        {{-- <a href="{{ route('landing') }}"
           class="text-xs px-4 py-1.5 rounded border border-green-400/50 
                  text-green-300 hover:bg-green-600/20 transition">
            Login
        </a> --}}

        {{-- REGISTER (optional, only if enabled) --}}
        {{-- @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="text-xs px-4 py-1.5 rounded border border-blue-400/50 
                      text-blue-300 hover:bg-blue-600/20 transition">
                Register
            </a>
        @endif --}}
    @endauth

</div>
    </div>
</header>


  {{-- Theme Switch --}}
        {{-- <div class="flex items-center gap-2">
            <span class="text-[11px] text-gray-300">Dark</span>

            <label class="relative inline-flex items-center cursor-pointer">
                {{-- Hidden checkbox that JS uses --}}
                {{-- <input
                    id="themeToggle"
                    type="checkbox"
                    class="sr-only peer"
                /> --}}
                {{-- Slider track + knob --}}
                {{-- <div
                    class="w-11 h-6 bg-gray-400/70 rounded-full
                        peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-green-500
                        peer-checked:bg-green-500
                        relative transition
                        after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                        after:bg-white after:h-5 after:w-5 after:rounded-full
                        after:shadow after:transition-all
                        peer-checked:after:translate-x-5"
                ></div> --}}
            {{-- </label>

            <span class="text-[11px] text-gray-300">Light</span>
        </div> --}}