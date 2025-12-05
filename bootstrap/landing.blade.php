<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
           
        </header>
        <main class="w-full lg:max-w-4xl max-w-md text-center">
            <h1 class="text-3xl lg:text-4xl font-semibold mb-4">Welcome to Laravel</h1>
            <p class="text-base lg:text-lg mb-6">Your landing page is ready. Start building your application!</p>
            {{-- <a href="{{ route('landing') }}" class="btn btn-primary btn-lg">Go to Home</a> --}}

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body> 
</html>
