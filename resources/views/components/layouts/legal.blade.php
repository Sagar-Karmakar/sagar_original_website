@props(['title', 'updated' => '31 October 2026'])

@php
    $pages = ['privacy' => 'Privacy', 'terms' => 'Terms', 'refund' => 'Refund policy'];
@endphp

<x-layouts.app :title="$title" nav="minimal">
    <div class="pt-[clamp(2.5rem,6vw,5rem)] pb-section">
        <div class="mx-auto flex max-w-site flex-wrap items-start gap-12 px-6">
            <nav aria-label="Legal pages" class="flex flex-[1_1_200px] flex-col gap-1.5">
                @foreach ($pages as $route => $label)
                    <a href="{{ route($route) }}" @if (request()->routeIs($route)) aria-current="page" @endif
                       class="rounded-lg px-3 py-2 text-muted hover:text-ink aria-[current=page]:bg-panel aria-[current=page]:font-semibold aria-[current=page]:text-ink">{{ $label }}</a>
                @endforeach
            </nav>

            <article class="flex max-w-190 min-w-0 flex-[999_1_560px] flex-col gap-4 leading-[1.7] [&_a]:text-brand [&_a]:underline [&_a:hover]:decoration-2 [&_h2]:mt-4 [&_h2]:font-serif [&_h2]:text-[26px] [&_h2]:leading-[1.3] [&_h2]:font-semibold">
                <h1 class="font-serif text-h1 font-semibold">{{ $title }}</h1>
                <p class="text-muted">Last updated: {{ $updated }}</p>

                {{ $slot }}
            </article>
        </div>
    </div>
</x-layouts.app>
