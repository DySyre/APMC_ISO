@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block mt-1 w-full p-2 bg-[#1A1D17] border border-[#3E4636] text-gray-100px-4 py-2.5 rounded-md focus:ring-2 focus:ring-[#C7B98E] outline-none']) }}>