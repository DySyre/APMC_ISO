@props(['id' => 'password', 'name' => 'password'])

<div class="relative">
    <x-text-input
        :id="$id"
        :name="$name"
        type="password"
        class="pr-10"
        required
    />

    <button
        type="button"
        onclick="togglePasswordVisibility('{{ $id }}', this)"
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-white"
    >
        <x-class-icon type="eye" class="hidden" data-eye-open />
        <x-class-icon type="eye-off" data-eye-closed />
    </button>
</div>
