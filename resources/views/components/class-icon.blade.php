@props(['type' => 'eye']) {{-- eye | eye-off --}}

@if ($type === 'eye')
    <svg {{ $attributes->merge(['class' => 'w-5 h-5']) }} fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 
                 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>
@endif

@if ($type === 'eye-off')
    <svg {{ $attributes->merge(['class' => 'w-5 h-5']) }} fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7 
                 .478-1.52 1.34-2.847 2.458-3.875M9.88 9.88a3 3 0 104.24 4.24" />
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 3l18 18" />
    </svg>
@endif
