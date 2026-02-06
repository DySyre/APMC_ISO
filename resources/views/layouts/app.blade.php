<!DOCTYPE html>
<html lang="en" data-theme="army">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.png') }}">

    <title>Army Command Portal</title>

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font (optional) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>

{{-- IMPORTANT: no dark class here --}}
<body class="bg-[#FDFDFC] dark:bg-[#020617] text-[#1b1b18] dark:text-slate-100 min-h-screen flex flex-col">

    {{-- Global Header --}}
    @include('partials.header')

    {{-- Page Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Global Theme Script --}}
    <script>
        const html = document.documentElement;

        function applyTheme(theme) {
            if (theme === 'dark') {
                html.classList.add('dark');
                html.setAttribute('data-theme', 'army'); // use army colors when dark
            } else {
                html.classList.remove('dark');
                html.setAttribute('data-theme', 'light'); // or any other theme name
            }
        }

        // Initial load
        const savedTheme = localStorage.getItem('theme') || 'dark';
        applyTheme(savedTheme);

        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('themeToggle');
            if (!toggle) return;

            // optional: sync initial toggle state
            toggle.checked = savedTheme === 'dark';

            toggle.addEventListener('click', () => {
                const nextTheme = html.classList.contains('dark') ? 'light' : 'dark';
                localStorage.setItem('theme', nextTheme);
                applyTheme(nextTheme);
            });
        });
    </script>
</body>
</html>

<script>
function togglePasswordVisibility(id, btn) {
    const input = document.getElementById(id);
    const eyeOpen = btn.querySelector('[data-eye-open]');
    const eyeClosed = btn.querySelector('[data-eye-closed]');

    if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.remove("hidden");
        eyeClosed.classList.add("hidden");
    } else {
        input.type = "password";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
    }
}
</script>
