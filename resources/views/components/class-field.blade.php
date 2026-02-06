@props(['id', 'label' => null])

<div class="mt-4">
    @if($label)
        <x-input-label :for="$id" :value="$label" />
    @endif

    <div class="relative">
        {{ $slot }}
    </div>

    <x-input-error :messages="$errors->get($id)" class="mt-2" />
</div>
