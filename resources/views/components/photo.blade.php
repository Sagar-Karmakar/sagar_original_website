{{-- public/images/{name}.(webp|jpg|jpeg|png) when it's there, a dashed placeholder until then. Set the shape with a class (aspect-[4/5]). --}}
@use('App\Support\SiteImage')
@props(['name', 'alt', 'hint' => null, 'eager' => false])

@if ($url = SiteImage::url($name))
    <img src="{{ $url }}" alt="{{ $alt }}" loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async"
         {{ $attributes->class('w-full rounded-3xl object-cover') }}>
@else
    <x-photo-placeholder :label="$alt" :hint="$hint" :attributes="$attributes">{{ $slot }}</x-photo-placeholder>
@endif
