{{-- Stroke icons drawn in currentColor. Size with a class (size-5), weight with stroke-width. --}}
@props(['name'])

@php
    $paths = [
        'check' => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
        'chat' => '<path d="M4 5h16v11H9l-5 4V5z"/>',
        'shield' => '<path d="M12 3l7 3v5c0 5-3.5 8-7 10-3.5-2-7-5-7-10V6l7-3z"/>',
        'cards' => '<rect x="4" y="6" width="11" height="14" rx="2"/><path d="M9 4h9a2 2 0 0 1 2 2v12"/><path d="M9.5 15.5s-2.5-1.5-2.5-3.3a1.4 1.4 0 0 1 2.5-.9 1.4 1.4 0 0 1 2.5.9c0 1.8-2.5 3.3-2.5 3.3z"/>',
        'talk' => '<path d="M3 5h12v8H8l-5 3.5V5z"/><path d="M15 9h6v8.5L18 15h-6v-2"/>',
        'heart' => '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>',
        'chai' => '<path d="M4 9h12v5a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V9z"/><path d="M16 11h1.5a2.5 2.5 0 0 1 0 5H16"/><path d="M8 3c0 1.2 1 1.6 1 3M12 3c0 1.2 1 1.6 1 3"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close' => '<path d="M6 6l12 12M18 6L6 18"/>',
    ];
@endphp

<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" {{ $attributes->merge(['stroke-width' => 2]) }}>{!! $paths[$name] !!}</svg>
