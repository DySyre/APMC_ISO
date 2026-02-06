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
            </div>
            --}}
        </div>

        <nav class="hidden md:flex items-center gap-6 text-xs font-medium tracking-wide">
            {{-- <a href="{{ url('/') }}" class="hover:text-green-300 transition">HOME</a>
            <a href="#about" class="hover:text-green-300 transition">ABOUT</a>
            <a href="#features" class="hover:text-green-300 transition">FEATURES</a>
            <a href="#contact" class="hover:text-green-300 transition">CONTACT</a> --}}
        </nav>

        <div class="flex items-center gap-4">

            {{-- AUTH LOGIC --}}
            @auth
                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="px-4 py-1.5 text-xs rounded border border-red-500/40
                               text-red-300 hover:bg-red-600/20 transition cursor-pointer">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                {{-- LOGIN --}}
                <a href="{{ route('login') }}"
                   class="text-xs px-4 py-1.5 rounded border border-green-400/50
                          text-green-300 hover:bg-green-600/20 transition cursor-pointer">
                    Login
                </a>

                {{-- REGISTER (optional) --}}
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="text-xs px-4 py-1.5 rounded border border-blue-400/50
                              text-blue-300 hover:bg-blue-600/20 transition cursor-pointer">
                        Register
                    </a>
                @endif
            @endguest

        </div>
    </div>
</header>
