{{-- nav: "home" (section links), "pages" (page links), "minimal" (call button only), "focused" (no booking distractions) --}}
@props(['nav' => 'pages'])

@php
    $links = match ($nav) {
        'home' => [
            ['How it works', '#how', null],
            ['Back to Us', '#back-to-us', null],
            ['About', route('about'), 'about'],
            ['Books', route('books'), 'books'],
        ],
        'pages' => [
            ['Home', route('home'), 'home'],
            ['About', route('about'), 'about'],
            ['Books', route('books'), 'books'],
        ],
        default => [],
    };
@endphp

<header class="border-b border-line">
    <div class="mx-auto flex max-w-site flex-wrap items-center justify-between gap-4 px-6 py-4">
        <a href="{{ route('home') }}" class="font-serif text-2xl font-semibold text-ink">Sagar <span class="italic text-brand">for Couples</span></a>

        @if ($nav === 'focused')
            <a href="{{ route('home') }}#back-to-us" class="font-semibold text-brand hover:underline">About Back to Us</a>
        @elseif ($nav === 'minimal')
            <x-button :href="route('call')" size="sm">Book a free call</x-button>
        @else
            <nav aria-label="Main" class="hidden items-center gap-6 md:flex">
                @foreach ($links as [$label, $href, $route])
                    <a href="{{ $href }}" @if ($route && request()->routeIs($route)) aria-current="page" @endif
                       class="text-muted hover:text-ink aria-[current=page]:font-semibold aria-[current=page]:text-ink">{{ $label }}</a>
                @endforeach
                <x-button :href="route('call')" size="sm">Book a free call</x-button>
            </nav>

            <button type="button" data-menu-toggle aria-expanded="false" aria-controls="site-menu" aria-label="Open menu"
                    class="group flex size-11 items-center justify-center rounded-[10px] border border-line bg-surface text-ink md:hidden">
                <x-icon name="menu" class="size-[22px] group-aria-expanded:hidden" stroke-width="1.8" />
                <x-icon name="close" class="hidden size-[22px] group-aria-expanded:block" stroke-width="1.8" />
            </button>

            <nav id="site-menu" data-menu aria-label="Main" hidden class="flex w-full flex-col pb-2 md:hidden">
                @foreach ($links as [$label, $href, $route])
                    <a href="{{ $href }}" @if ($route && request()->routeIs($route)) aria-current="page" @endif
                       class="border-b border-line py-3 text-lg text-ink aria-[current=page]:font-semibold">{{ $label }}</a>
                @endforeach
                <x-button :href="route('call')" class="mt-4 w-full">Book a free call</x-button>
            </nav>
        @endif
    </div>
</header>
