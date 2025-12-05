@vite('resources/css/app.css')
@vite('resources/js/app.js')

{{-- <header class="bg-gray-800 text-white shadow-lg"> --}}
<div class="navbar bg-base-100 shadow-sm">
  <div class="navbar-start">

    <!-- Desktop menu -->
    <ul class="hidden lg:flex gap-2">
      {{-- <li><a class="btn btn-soft" href="{{ route('home') }}">Home</a></li> --}}
    </ul>
  </div>

  <div class="navbar-center">
    {{-- <a class="btn btn-ghost text-xl" href="{{ route('home') }}">Barkspace</a> --}}
  </div>

  <div class="navbar-end flex items-center gap-4">
    <label class="cursor-pointer flex gap-2 items-center">
      <span class="text-sm">🌙</span>
      <input id="theme-toggle" type="checkbox" class="toggle toggle-primary" />
      <span class="text-sm">☀️</span>
    </label>

    <button class="btn btn-soft btn-circle">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
    </button>
  </div>
</div>