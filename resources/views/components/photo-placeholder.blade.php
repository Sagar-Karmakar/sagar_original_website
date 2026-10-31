{{-- Stand-in until the real photo is ready. Set the shape with a class (aspect-[4/5]); the slot takes an optional icon. --}}
@props(['label', 'hint' => null])

<div role="img" aria-label="Photo placeholder: {{ $label }}" {{ $attributes->class('flex flex-col items-center justify-center gap-3 rounded-3xl border-2 border-dashed border-dash bg-panel p-6 text-center text-muted') }}>
    {{ $slot }}
    <span class="font-semibold">Photo: {{ $label }}</span>
    @if ($hint)
        <span class="text-sm">{{ $hint }}</span>
    @endif
</div>
