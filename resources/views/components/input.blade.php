{{-- Labelled text input with its validation error. Extra attributes (required, autocomplete...) go on the input. --}}
@props(['name', 'label', 'hint' => null, 'type' => 'text', 'value' => null])

<div class="flex flex-col gap-1.5">
    <label for="{{ $name }}" class="font-semibold">
        {{ $label }}
        @if ($hint)
            <span class="font-normal text-muted">{{ $hint }}</span>
        @endif
    </label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}"
           @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
           {{ $attributes->class('form-control') }}>
    @error($name)
        <p id="{{ $name }}-error" class="text-sm font-semibold text-brand">{{ $message }}</p>
    @enderror
</div>
