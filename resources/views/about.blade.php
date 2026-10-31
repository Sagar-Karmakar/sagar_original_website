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
                <x-photo name="about" alt="Sagar and Arpita at home" class="aspect-[4/5]" eager />
            </div>
        </div>
    </section>

    <!-- Why -->
    <section class="border-y border-line bg-surface py-section">
        <div data-reveal class="mx-auto flex max-w-190 flex-col gap-[18px] px-6">
            <h2 class="font-serif text-h2 font-semibold">My story</h2>
            <p>Arpita and I fell in love at first sight. What came next wasn't a fairy tale. We fought, we misunderstood each other, and more than once a fight went so far that we talked about breaking up.</p>
            <p>We ended up married instead, because I started learning how to keep a relationship good. The biggest thing I learned is that love doesn't just happen. We create it, step by step, through small things we do for each other every day.</p>
            <p>I learned from courses, from coaching I took myself, and from our own ups and downs. Then I met my mentor, Alex Johnson, who showed me where to learn properly. Since then I've studied relationship psychology, communication and NLP, and tried all of it in our own marriage first. I even left my job to learn this well.</p>
            <p>It changed us. We still fight sometimes, but now our fights end quickly. Nobody in my life matters more than Arpita, and to us, we're the best couple in the world. We didn't start like that. We got here because we had the courage, and the wish, to learn.</p>
            <p>Friends and family started asking for help, so I helped anyone who had the courage to change, and learned from every couple. After a long time doing it for free, I made a decision: if what I know can help couples become happy, romantic partners for life, it's fair to make it my work, at a fair price. That's how Sagar for Couples began.</p>
            <p>And it's why I start with play. When two tired people laugh together again, the hard conversations get a little easier.</p>
        </div>
    </section>

    <!-- Timeline -->
    <section class="py-section">
        <div class="mx-auto flex max-w-site flex-col gap-7 px-6">
            <h2 data-reveal class="font-serif text-h2 font-semibold">The road so far</h2>
            <ol data-stagger class="grid grid-fit-55 gap-4">
                @foreach ([
                    ['2019', 'Met Arpita, and started learning how to build a good relationship: communication, coaching, and our own ups and downs'],
                    ['2024', 'Met my mentor, Alex Johnson, who showed me where to learn properly. Then psychology, communication and NLP'],
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
