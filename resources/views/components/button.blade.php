{{-- A link styled as a button; without an href it's a submit button. variant: primary, outline, inverse (on the red band), outline-inverse (on the red band) --}}
@props(['href' => null, 'variant' => 'primary', 'size' => 'md'])

@php
    $filled = in_array($variant, ['primary', 'inverse']);

    $variants = [
        'primary' => 'bg-brand text-white hover:bg-brand/90',
        'outline' => 'border-2 border-brand text-brand hover:bg-brand/10',
        'inverse' => 'bg-white text-brand hover:bg-white/90',
        'outline-inverse' => 'border-2 border-white text-white hover:bg-white/10',
    ];

    $sizes = [
        'sm' => 'min-h-11 rounded-[10px] px-[18px] py-2.5 font-semibold',
        'md' => 'min-h-13 rounded-xl px-6 py-3 text-[17px] font-semibold',
        'lg' => 'min-h-14 rounded-xl px-[26px] py-3 '.($filled ? 'text-lg font-bold' : 'text-[17px] font-semibold'),
    ];

    $classes = ['inline-flex cursor-pointer items-center justify-center gap-2 text-center transition-colors', $variants[$variant], $sizes[$size]];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'submit'])->class($classes) }}>{{ $slot }}</button>
@endif
