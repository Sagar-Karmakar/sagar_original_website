<x-layouts.app title="About Sagar Karmakar"
    description="Sagar Karmakar is a couples coach who loves science and spirituality, and wants every idea he teaches to stand up to both.">

    <!-- Intro -->
    <section class="py-[clamp(3rem,7vw,6.5rem)]">
        <div class="mx-auto flex max-w-site flex-wrap items-center gap-12 px-6">
            <div data-hero class="flex min-w-0 flex-[1_1_520px] flex-col gap-5">
                <x-eyebrow>About</x-eyebrow>
                <h1 class="font-serif text-hero font-semibold">Hi, I'm Sagar Karmakar.</h1>
                <p class="max-w-145 text-lead text-muted">Couples coach. I love science and I love spirituality, and I want every idea I teach to stand up to both.</p>
            </div>
            <div class="min-w-0 flex-[1_1_340px]">
                <x-photo-placeholder label="Sagar and Arpita at home" class="aspect-[4/5]" />
            </div>
        </div>
    </section>

    <!-- Why -->
    <section class="border-y border-line bg-surface py-section">
        <div data-reveal class="mx-auto flex max-w-190 flex-col gap-[18px] px-6">
            <h2 class="font-serif text-h2 font-semibold">Why I do this</h2>
            <p>I coach couples because of my own marriage to Arpita, and because of the marriages I've watched around me: two good people, slowly turning into colleagues who share a home and a to-do list.</p>
            <p>That's why I start with play. When two tired people laugh together again, the hard conversations get a little easier.</p>
            <p class="text-muted">[Your story in your own words: the stall, what didn't work, what you found, where you are now. No invented details.]</p>
        </div>
    </section>

    <!-- Timeline -->
    <section class="py-section">
        <div class="mx-auto flex max-w-site flex-col gap-7 px-6">
            <h2 data-reveal class="font-serif text-h2 font-semibold">The road so far</h2>
            <ol data-stagger class="grid grid-fit-55 gap-4">
                @foreach ([
                    ['[Year]', '[A moment that shaped you]'],
                    ['[Year]', '[Training or learning you did]'],
                    ['2026', 'Started @sagarforcouples'],
                    ['Now', 'Coaching couples online, and writing books for couples'],
                ] as [$when, $what])
                    <li class="flex flex-col gap-1.5 border-t-3 border-brand pt-4">
                        <span class="font-serif text-[26px] font-semibold">{{ $when }}</span>
                        <span class="text-muted">{{ $what }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <!-- Values -->
    <section class="bg-panel py-section">
        <div class="mx-auto flex max-w-site flex-col gap-7 px-6">
            <h2 data-reveal class="font-serif text-h2 font-semibold">What I stand for</h2>
            <div data-stagger class="grid grid-fit-60 gap-4">
                @foreach ([
                    'Honesty' => 'Published prices, real refunds, real numbers, no invented stories.',
                    'Practice over talk' => 'Every session ends with something you\'ll actually do.',
                    'Accountability' => 'I check in on you, and someone checks on me.',
                    'Respect' => 'Consent in every exercise. No pressure, no shaming.',
                ] as $value => $meaning)
                    <div class="flex flex-col gap-2 rounded-2xl bg-surface p-6">
                        <h3 class="text-xl font-bold">{{ $value }}</h3>
                        <p class="text-muted">{{ $meaning }}</p>
                    </div>
                @endforeach
            </div>
            <p class="max-w-190"><strong>What I'm not:</strong> a therapist or a doctor. When you need one, I'll tell you honestly and help you find one.</p>
        </div>
    </section>

    <!-- Call to action -->
    <section class="bg-brandpy-[clamp(3.5rem,7vw,6rem)] text-white">
        <div data-reveal class="mx-auto flex max-w-site flex-col items-center gap-5 px-6 text-center">
            <h2 class="font-serif text-h1 font-semibold">Let's talk for 20 minutes.</h2>
            <x-button :href="route('call')" variant="inverse">Book a free call</x-button>
        </div>
    </section>

</x-layouts.app>
