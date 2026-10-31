<x-layouts.app nav="home" sticky-cta>

    <!-- Hero -->
    <section class="pt-[clamp(2.5rem,6vw,6rem)] pb-[clamp(3rem,6vw,5.5rem)]">
        <div class="mx-auto flex max-w-site flex-wrap items-center gap-12 px-6">
            <div data-hero class="flex min-w-0 flex-[1_1_500px] flex-col gap-5">
                <p class="self-start rounded-2xl border border-line bg-surface px-3.5 py-1.5 text-sm font-semibold text-muted sm:rounded-full">For married couples · Online · English, Hindi or Bengali</p>
                <h1 class="font-serif text-hero font-semibold tracking-[-0.01em]">
                    Married, but living like
                    <span class="relative whitespace-nowrap">room partners?<svg viewBox="0 0 300 20" preserveAspectRatio="none" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" class="absolute -bottom-2 left-0 h-3.5 w-full text-brand"><path d="M4 14 C 60 4, 120 18, 180 9 S 270 6, 296 11"/></svg></span>
                </h1>
                <p class="max-w-145 text-lead text-body">Back to Us is a 4-week online program that helps you laugh, talk and feel like a team again, with 2-minute couple games and simple talk tools made for busy Indian homes.</p>
                <div class="mt-1 flex flex-wrap gap-3">
                    <x-button :href="route('call')" size="lg">Book your free 20-minute call</x-button>
                    <x-button :href="config('site.whatsapp_url')" variant="outline" size="lg">
                        <x-icon name="chat" class="size-5" stroke-width="1.8" />
                        Ask on WhatsApp
                    </x-button>
                </div>
                <ul aria-label="About the free call" class="flex flex-wrap gap-x-5 gap-y-2 text-small text-body">
                    @foreach (['Free first call', 'No pressure to buy', 'Private and confidential'] as $point)
                        <li class="flex items-center gap-1.5"><x-icon name="check" class="size-[18px] text-brand" stroke-width="2.4" />{{ $point }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="relative min-w-0 flex-[1_1_360px]">
                <x-photo name="home-hero" alt="Sagar and Arpita smiling together on the sofa at home" class="aspect-[4/5]" eager>
                    <x-icon name="chai" class="size-10 text-brand" stroke-width="1.5" />
                </x-photo>
                <div class="absolute bottom-7 -left-3 flex max-w-60 flex-col gap-0.5 rounded-2xl border border-line bg-surface px-[18px] py-3.5">
                    <span class="text-xs font-bold tracking-[0.08em] text-brand uppercase">Tonight's game · 2 min</span>
                    <span class="font-serif text-xl font-semibold">Chai Toast</span>
                    <span class="text-sm text-muted">Toast your partner for one small thing they did today.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Sound familiar -->
    <section class="border-y border-line bg-surface py-section">
        <div class="mx-auto flex max-w-site flex-col gap-8 px-6">
            <div data-reveal class="flex max-w-190 flex-col gap-3">
                <x-eyebrow>Sound familiar?</x-eyebrow>
                <h2 class="font-serif text-h2 font-semibold">You didn't stop loving each other. Life just got full.</h2>
            </div>
            <div data-stagger class="grid grid-fit-62 gap-4">
                @foreach ([
                    'Your talks sound like a to-do list: bills, EMIs, school forms, the gas cylinder.',
                    'Same sofa, different worlds. One scrolls reels, one answers the office group.',
                    'Small things turn into big fights, and nobody remembers how they started.',
                    'You can\'t remember the last time you laughed together until your stomach hurt.',
                ] as $sign)
                    <div class="rounded-2xl border border-line bg-page p-6 text-lg">{{ $sign }}</div>
                @endforeach
            </div>
            <p data-reveal class="max-w-190 text-[19px]">If that's your home, nothing is wrong with you. This is what busy lives do to good couples. The way back is usually smaller, and lighter, than you think.</p>
        </div>
    </section>

    <!-- Quote -->
    <section class="bg-panel py-[clamp(3.5rem,7vw,6rem)]">
        <div data-reveal class="mx-auto flex max-w-225 flex-col items-center gap-4 px-6 text-center">
            <p class="font-serif text-[clamp(1.75rem,3.6vw,2.875rem)] leading-[1.2] font-medium italic"><span class="text-brand">“</span>Most marriages don't break in one big fight. They drift, one ‘we'll talk later’ at a time.<span class="text-brand">”</span></p>
            <p class="text-lg text-body">The good news: what drifted slowly can come back, two minutes at a time.</p>
        </div>
    </section>

    <!-- How it works -->
    <section id="how" class="py-section">
        <div class="mx-auto flex max-w-site flex-col gap-8 px-6">
            <div data-reveal class="flex max-w-190 flex-col gap-3">
                <x-eyebrow>The Back to Us way</x-eyebrow>
                <h2 class="font-serif text-h2 font-semibold">Play first. Then talk.</h2>
                <p class="text-lg text-body">Most couples are told to “communicate more”. When you're tired and hurt, that's the hardest thing to do. So we start with something easier: play.</p>
            </div>
            <ol data-stagger class="grid grid-fit-65 gap-5">
                @foreach ([
                    ['cards', '1. Play', '2-minute games that make you laugh, notice each other and feel like a team. Most need nothing but the two of you.'],
                    ['talk', '2. Talk', 'Simple tools for the hard stuff: start gently, listen without fixing, pause a fight and come back, and say sorry in a way that repairs.'],
                    ['heart', '3. Keep it going', 'A small daily practice and WhatsApp check-ins between sessions, so the change doesn\'t fade after the call ends.'],
                ] as [$icon, $step, $text])
                    <li class="flex flex-col gap-3 rounded-2xl border border-line bg-surface p-7">
                        <span class="flex size-13 items-center justify-center rounded-[14px] bg-brand/10 text-brand"><x-icon :name="$icon" class="size-7" stroke-width="1.6" /></span>
                        <h3 class="font-serif text-2xl font-semibold">{{ $step }}</h3>
                        <p class="text-body">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
            <p class="max-w-205 text-small text-muted">Research links laughing together, gratitude and trying new things together with closer, happier couples. These are links, not promises, and I'll always tell you which is which.</p>
        </div>
    </section>

    <!-- Sample games -->
    <section class="border-y border-line bg-surface py-section">
        <div class="mx-auto flex max-w-site flex-col gap-8 px-6">
            <div data-reveal class="flex max-w-190 flex-col gap-3">
                <x-eyebrow>Try one tonight</x-eyebrow>
                <h2 class="font-serif text-h2 font-semibold">A taste of the games</h2>
            </div>
            <div data-stagger class="grid grid-fit-65 gap-5">
                @foreach ([
                    ['Laugh', 'Worst Pickup Line', 'Each of you invents the worst pickup line you can, and delivers it with total confidence. First to laugh loses.'],
                    ['Cherish', 'Chai Toast', 'Raise your cup and toast your partner for one small thing. “To the only person here who can fold a fitted bedsheet.”'],
                    ['Touch', 'Melt Hug', 'Hug, and don\'t let go until you both feel your shoulders drop. Not the polite side-hug you give relatives at weddings.'],
                ] as [$kind, $game, $howTo])
                    <div class="flex flex-col gap-2.5 rounded-[20px] border-t-6 border-brand bg-page p-7">
                        <span class="text-[13px] font-bold tracking-[0.08em] text-muted uppercase">{{ $kind }} · 2 min · ₹0</span>
                        <h3 class="font-serif text-[26px] font-semibold">{{ $game }}</h3>
                        <p class="text-body">{{ $howTo }}</p>
                    </div>
                @endforeach
            </div>
            <div class="flex items-center gap-5">
                @if ($cover = \App\Support\SiteImage::url('book-just-the-two-of-us'))
                    <a href="{{ route('books') }}" class="shrink-0">
                        <img src="{{ $cover }}" alt="Cover of Just The Two Of Us" loading="lazy" class="aspect-[2/3] w-20 rounded-md object-cover shadow-md sm:w-24">
                    </a>
                @endif
                <p>Back to Us couples get all 120 games from my book, <a href="{{ route('books') }}" class="italic underline hover:text-brand">Just The Two Of Us</a>. Many have a quiet version for when family is in the next room.</p>
            </div>
        </div>
    </section>

    <!-- Aims -->
    <section class="py-section">
        <div class="mx-auto flex max-w-site flex-col gap-7 px-6">
            <div data-reveal class="flex max-w-190 flex-col gap-3">
                <x-eyebrow>In 4 weeks</x-eyebrow>
                <h2 class="font-serif text-h2 font-semibold">What we work towards together</h2>
                <p class="text-muted">Every couple is different, so these are aims, not promises.</p>
            </div>
            <ul data-stagger class="grid grid-fit-65 gap-4">
                @foreach ([
                    'A real laugh together, most evenings',
                    'Fights that end the same day, and stay ended',
                    'Saying the hard thing without starting a war',
                    'Feeling like a team again, not colleagues',
                ] as $aim)
                    <li class="flex items-start gap-3.5 rounded-2xl border border-line bg-surface p-[22px]">
                        <x-icon name="check" class="size-[26px] shrink-0 text-brand" stroke-width="2.2" />
                        <span class="text-lg">{{ $aim }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- The program -->
    <section id="back-to-us" class="bg-panel py-section">
        <div class="mx-auto flex max-w-site flex-col gap-10 px-6">
            <div class="flex flex-wrap items-start gap-10">
                <div data-reveal class="flex min-w-0 flex-[1_1_480px] flex-col gap-4">
                    <x-eyebrow>The program</x-eyebrow>
                    <h2 class="font-serif text-h1 font-semibold">Back to Us</h2>
                    <p class="text-[19px]">A 4-week online program for married couples who want to feel like friends, and lovers, again.</p>
                    <p class="mt-2 font-bold">Everything you get:</p>
                    <ul class="flex flex-col gap-3">
                        @foreach ([
                            ['4 weekly couple sessions', ', online, at times that suit working couples'],
                            ['A 2-minute game every day', ', picked for that week'],
                            ['WhatsApp check-ins', ' between sessions'],
                            ['A private safety check', ' with each partner before week 1'],
                            ['2 booster calls', ', 1 month and 3 months later'],
                        ] as [$item, $detail])
                            <li class="flex items-start gap-3">
                                <x-icon name="check" class="mt-[3px] size-[22px] shrink-0 text-brand" stroke-width="2.2" />
                                <span><strong>{{ $item }}</strong>{{ $detail }}</span>
                            </li>
                        @endforeach
                        <li class="flex items-start gap-3">
                            <x-icon name="check" class="mt-[3px] size-[22px] shrink-0 text-brand" stroke-width="2.2" />
                            <span><strong>Bonus:</strong> all 120 games in my book, <em>Just The Two Of Us</em></span>
                        </li>
                    </ul>
                </div>

                <div data-reveal class="flex min-w-0 flex-[1_1_360px] flex-col gap-3.5 rounded-[20px] border-2 border-brand bg-surface p-8">
                    <p class="self-start rounded-full bg-brand px-3 py-1 text-[13px] font-bold tracking-[0.06em] text-white uppercase">{{ $offer['label'] }}</p>
                    <p class="font-serif text-[56px] leading-none font-semibold">₹{{ number_format($offer['price']) }}</p>
                    <p class="text-muted">per couple, for the whole 4 weeks</p>
                    <p class="rounded-xl bg-page px-3.5 py-3 text-small">For comparison, one couple session in India usually costs ₹2,800–3,500. Back to Us gives you 4 sessions, daily games and support between them.</p>
                    @if ($offer['spots_total'])
                        <p class="self-start rounded-full bg-panel px-3.5 py-1.5 text-small font-bold">
                            {{ $offer['spots_left'] ? "Spots left: {$offer['spots_left']} of {$offer['spots_total']}" : 'All spots are taken for now' }}
                        </p>
                    @endif
                    <x-button :href="route('call')" size="lg" class="w-full">Start with a free call</x-button>
                    @if ($offer['note'])
                        <p class="text-small text-muted">@if ($offer['note_title'])<strong class="text-ink">{{ $offer['note_title'] }}</strong> @endif{{ $offer['note'] }}</p>
                    @endif
                    <p class="text-small text-muted"><strong class="text-ink">Refund rule:</strong> if Back to Us doesn't feel worth it after the first two weeks, tell me and I'll refund everything except any payment fee (UPI has none). <a href="{{ route('refund') }}" class="underline hover:text-brand">Details</a></p>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h3 class="font-serif text-[28px] font-semibold">Your 4 weeks</h3>
                <div data-stagger class="grid grid-fit-55 gap-4">
                    @foreach ([
                        ['Friends again', 'Laugh and play as a team. Notice the small ways you still reach for each other.'],
                        ['Talk without fighting', 'Gentle starts, real listening, a break that ends in coming back, and a sorry that repairs.'],
                        ['Heal', 'Trust and old hurts, gently. See the pattern you\'re both stuck in, instead of blaming each other.'],
                        ['Spark', 'Closeness and romance, at your own pace. And a plan to keep playing after we finish.'],
                    ] as [$week, $text])
                        <div class="flex flex-col gap-2 rounded-2xl bg-page p-6">
                            <span class="flex size-10 items-center justify-center rounded-full bg-brand font-bold text-white">{{ $loop->iteration }}</span>
                            <h4 class="text-xl font-bold">{{ $week }}</h4>
                            <p class="text-body">{{ $text }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- How to start -->
    <section class="py-section">
        <div class="mx-auto flex max-w-site flex-col gap-7 px-6">
            <h2 data-reveal class="font-serif text-h2 font-semibold">How to start</h2>
            <ol data-stagger class="grid grid-fit-65 gap-5">
                @foreach ([
                    ['1. Book a free 20-minute call', 'Tell me what\'s going on. I\'ll tell you honestly whether I can help.'],
                    ['2. A private check with each of you', 'A short call with each partner alone, so both of you feel safe and heard.'],
                    ['3. Start your 4 weeks', 'Weekly sessions, daily games and check-ins. Then 2 booster calls at 1 and 3 months.'],
                ] as [$step, $text])
                    <li class="flex flex-col gap-2.5 border-t-3 border-brand pt-[18px]">
                        <span class="font-serif text-[22px] font-semibold">{{ $step }}</span>
                        <span class="text-body">{{ $text }}</span>
                    </li>
                @endforeach
            </ol>
            <div>
                <x-button :href="route('call')" size="lg">Book your free call</x-button>
            </div>
        </div>
    </section>

    <!-- Meet your coach -->
    <section class="border-y border-line bg-surface py-section">
        <div class="mx-auto flex max-w-site flex-wrap items-center gap-12 px-6">
            <div data-reveal class="min-w-0 flex-[1_1_360px]">
                <x-photo name="coach" alt="Sagar Karmakar taking notes during a coaching session" class="aspect-square" />
            </div>
            <div data-reveal class="flex min-w-0 flex-[1_1_480px] flex-col gap-4">
                <x-eyebrow>Meet your coach</x-eyebrow>
                <h2 class="font-serif text-h2 font-semibold">Hi, I'm Sagar Karmakar.</h2>
                <p>I'm a couples coach, and I'm married to Arpita. I do this work because of my own marriage, and because of the marriages around me where two good people quietly became room partners.</p>
                <p>I love the science of relationships, so I'll always tell you what research shows and what it doesn't. And I'm honest about my limits: I'm a coach, not a therapist, and I'll never promise to save your marriage. I'll give you simple things to do, and I'll check that you do them.</p>
                <p>Arpita and I still fight sometimes. The difference is that our fights now end quickly, and we come out of them closer. We didn't start like this: we were a normal couple, and we got here by choosing to learn.</p>
                <a href="{{ route('about') }}" class="self-start font-semibold text-brand underline hover:decoration-2">Read my story</a>
            </div>
        </div>
    </section>

    <!-- Reviews (added in Admin → Reviews; hidden until there's one to show) -->
    @if ($reviews->isNotEmpty())
        <section class="py-section">
            <div class="mx-auto flex max-w-site flex-col gap-8 px-6">
                <h2 data-reveal class="font-serif text-h2 font-semibold">What couples say</h2>
                <div data-stagger class="grid grid-fit-70 gap-5">
                    @foreach ($reviews as $review)
                        <figure class="flex flex-col gap-3.5 rounded-2xl border border-line bg-surface p-7">
                            <span aria-hidden="true" class="font-serif text-5xl leading-[0.6] text-brand">“</span>
                            <blockquote class="text-lg whitespace-pre-line">{{ $review->quote }}</blockquote>
                            <figcaption class="text-sm text-muted">{{ $review->couple }}@if ($review->context) · {{ $review->context }}@endif</figcaption>
                        </figure>
                    @endforeach
                </div>
                <p class="text-small text-muted">Names are hidden. Every couple is different, and no result is promised.</p>
            </div>
        </section>
    @endif

    <!-- Who it's for (needs its own top space when there are no reviews above) -->
    <section @class(['pb-section', 'pt-section' => $reviews->isEmpty()])>
        <div data-stagger class="mx-auto grid max-w-site grid-fit-75 gap-5 px-6">
            <div class="flex flex-col gap-3.5 rounded-2xl border border-line bg-surface p-8">
                <h2 class="font-serif text-3xl font-semibold">Back to Us is for you if</h2>
                <ul class="flex list-disc flex-col gap-2 pl-[22px]">
                    <li>You're married and want to enjoy your marriage again</li>
                    <li>You both want to join the sessions</li>
                    <li>You can find 2 minutes a day for a game</li>
                    <li>You want simple things to do, not long lectures</li>
                </ul>
            </div>
            <div class="flex flex-col gap-3.5 rounded-2xl border border-line bg-surface p-8">
                <h2 class="font-serif text-3xl font-semibold">It's not the right first step if</h2>
                <ul class="flex list-disc flex-col gap-2 pl-[22px]">
                    <li>There is fear, violence or abuse at home</li>
                    <li>One of you is in a mental health crisis</li>
                    <li>Addiction is part of what's happening</li>
                </ul>
                <p class="text-muted">You deserve real support. Call the Women Helpline 181, or 112 in an emergency. Tele-MANAS (14416) offers emotional support any time.</p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="border-t border-line bg-surface py-section">
        <div class="mx-auto flex max-w-205 flex-col gap-6 px-6">
            <h2 data-reveal class="font-serif text-h2 font-semibold">Questions couples ask</h2>
            <div class="flex flex-col border-t border-line">
                @foreach ([
                    'We\'re both so busy. Will we have time?' => 'That\'s exactly who this is for. The daily game takes 2 minutes, and sessions are online at times that suit working couples, evenings and weekends included.',
                    'We don\'t fight much. We\'ve just drifted. Is this for us?' => 'Yes. That\'s the “room partner” stage, and it\'s one of the most common things I see. Week 1 is all about friendship and play.',
                    'What if my partner won\'t come?' => 'Very common. Many partners say yes to a game before they say yes to coaching. Try one 2-minute game at home, lightly, with no talk of “working on us”. If they get curious, the free call is open to you both. It can also be with just one of you.',
                    'What if it doesn\'t help?' => 'Every couple is different, and I can\'t promise results. That\'s why the first call is free, I\'ll tell you honestly if it\'s not the right fit, and the refund rule is simple: if Back to Us doesn\'t feel worth it after the first two weeks, I refund everything except any fee the payment provider keeps. No long questions.',
                    'Is this therapy?' => 'No. This is coaching. I don\'t diagnose or treat any condition. If you need a therapist or a doctor, I\'ll tell you honestly and help you find one.',
                    'Is it private?' => 'Yes. What you share stays between us. I never share a couple\'s story without written permission, and names are always hidden.',
                    'Which language, and where?' => 'English, Hindi or Hinglish, and Bengali. Everything is online, so you can join from anywhere.',
                ] as $question => $answer)
                    <details class="border-b border-line py-[18px]">
                        <summary class="cursor-pointer text-lg font-semibold">{{ $question }}</summary>
                        <p class="mt-3 text-body">{{ $answer }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Closing call to action -->
    <section class="bg-brand py-[clamp(4rem,8vw,7rem)] text-white">
        <div data-reveal class="mx-auto flex max-w-site flex-col items-center gap-5 px-6 text-center">
            <h2 class="font-serif text-h1 font-semibold">Your next evening can feel different.</h2>
            <p class="max-w-150 text-xl">It starts with one free, 20-minute call. No pressure, no hard selling.</p>
            <div class="flex flex-wrap justify-center gap-3">
                <x-button :href="route('call')" variant="inverse" size="lg">Book your free 20-minute call</x-button>
                <x-button :href="config('site.whatsapp_url')" variant="outline-inverse" size="lg">Ask on WhatsApp</x-button>
            </div>
            <p class="text-small text-white/85">
                {{ $offer['label'] }} · ₹{{ number_format($offer['price']) }} per couple
                @if ($offer['spots_total'])
                    · {{ $offer['spots_left'] ? "{$offer['spots_left']} of {$offer['spots_total']} spots left" : 'all spots taken for now' }}
                @endif
            </p>
        </div>
    </section>

</x-layouts.app>
