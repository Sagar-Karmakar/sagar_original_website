<x-layouts.app title="Books for couples"
    description="Books by Sagar Karmakar for Indian couples: small things to do together, on every page.">

    <div class="pt-[clamp(3rem,7vw,6rem)] pb-section">
        <div class="mx-auto flex max-w-site flex-col gap-10 px-6">
            <div data-hero class="flex max-w-180 flex-col gap-3">
                <x-eyebrow>Books for couples</x-eyebrow>
                <h1 class="font-serif text-h1 font-semibold">Small things to do together, on every page.</h1>
                <p class="text-[19px] text-body">Written for real Indian homes: busy days, full houses, and two people who still choose each other.</p>
            </div>

            <div data-stagger class="grid grid-fit-85 gap-6">
                @foreach ([
                    [
                        'title' => 'Just The Two Of Us',
                        'image' => 'book-just-the-two-of-us',
                        'blurb' => '120 games for Indian couples to laugh, talk and fall in love again. Two-minute games for chai time, quiet versions for full houses, and games to play apart.',
                        'cover' => 'bg-brand text-white',
                        'cta' => 'Get it free with Back to Us',
                        'href' => route('home').'#back-to-us',
                        'variant' => 'primary',
                    ],
                    [
                        'title' => 'Love Rediscovered',
                        'image' => 'book-love-rediscovered',
                        'blurb' => 'A five-week journey back to each other: noticing the love you stopped seeing, calming your reactions, talking without blame, and closeness again.',
                        'cover' => 'border-2 border-brand bg-panel text-brand',
                        'cta' => 'Tell me when it\'s out',
                        'href' => config('site.whatsapp_url'),
                        'variant' => 'outline',
                    ],
                ] as $book)
                    <article class="flex flex-wrap items-start gap-6 rounded-[20px] border border-line bg-surface p-7">
                        @if ($cover = \App\Support\SiteImage::url($book['image']))
                            <img src="{{ $cover }}" alt="Cover of {{ $book['title'] }}" loading="lazy" class="aspect-[2/3] w-[180px] flex-none rounded-lg object-cover shadow-md">
                        @else
                            <div role="img" aria-label="Cover placeholder: {{ $book['title'] }}" class="{{ $book['cover'] }} flex aspect-[2/3] w-[180px] flex-none flex-col justify-between rounded-lg p-4">
                                <span class="font-serif text-lg leading-[1.15] font-semibold break-words">{{ $book['title'] }}</span>
                                <span class="text-xs">Sagar Karmakar</span>
                            </div>
                        @endif
                        <div class="flex min-w-0 flex-[1_1_200px] flex-col gap-2.5">
                            <span class="self-start rounded-full bg-panel px-3 py-1 text-[13px] font-semibold">Coming soon</span>
                            <h2 class="font-serif text-[28px] leading-[1.15] font-semibold">{{ $book['title'] }}</h2>
                            <p class="text-body">{{ $book['blurb'] }}</p>
                            <x-button :href="$book['href']" :variant="$book['variant']" size="sm" class="mt-1 self-start">{{ $book['cta'] }}</x-button>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>

</x-layouts.app>
