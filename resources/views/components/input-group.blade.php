@props([
    'label',
    'name',
    'type' => 'text',
    'step' => null,
    'value' => '',
])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $step ? 'step='.$step : '' }}
        value="{{ old($name, $value) }}"
        required
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
    >
    @error($name)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
