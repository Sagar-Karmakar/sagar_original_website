@use('Carbon\CarbonImmutable')

@php
    $timezone = config('booking.timezone');
    $firstDay = CarbonImmutable::parse(array_key_first($days), $timezone);
    $lastDay = CarbonImmutable::parse(array_key_last($days), $timezone);
    $months = $firstDay->month === $lastDay->month ? $firstDay->format('F Y') : $firstDay->format('F').' – '.$lastDay->format('F Y');
@endphp

<x-layouts.app title="Book a free 20-minute call" nav="focused" footer="minimal"
    description="Married, but living like room partners? Book a free 20-minute call with couples coach Sagar Karmakar. Online, in English, Hindi or Bengali.">

    <div class="pt-[clamp(2.5rem,6vw,5.5rem)] pb-section">
        <div class="mx-auto flex max-w-site flex-wrap items-start gap-10 px-6">

            <div data-hero class="flex min-w-0 flex-[1_1_420px] flex-col gap-5">
                <x-eyebrow>Free 20-minute call</x-eyebrow>
                <h1 class="font-serif text-h1 font-semibold">Married, but living like room partners?</h1>
                <p class="text-[19px] text-muted">Book a free 20-minute call. We'll look at what's happening between you two, and I'll tell you honestly whether I can help.</p>
                <ul aria-label="At a glance" class="flex flex-wrap gap-2">
                    @foreach (['Free', '20 minutes', 'Online', 'English, Hindi or Bengali'] as $fact)
                        <li class="rounded-full bg-panel px-3.5 py-1.5 text-sm">{{ $fact }}</li>
                    @endforeach
                </ul>
                <div class="flex flex-col gap-3 rounded-2xl border border-line bg-surface p-7">
                    <h2 class="font-serif text-2xl font-semibold">What happens on the call</h2>
                    <ol class="flex list-decimal flex-col gap-2 pl-[22px]">
                        <li>You tell me what's been happening between you two.</li>
                        <li>I ask what you've already tried, and what you'd like instead.</li>
                        <li>I tell you honestly whether Back to Us can help, and what it costs. If it's not the right fit, I'll say so.</li>
                    </ol>
                    <p class="text-small text-muted">Both partners are welcome. If only one of you can join, that's fine too.</p>
                </div>
            </div>

            <div class="flex min-w-0 flex-[1_1_440px] flex-col gap-3">
                @if ($selectedDay)
                    <form method="POST" action="{{ route('call.book') }}" data-booking class="flex flex-col gap-8 rounded-[20px] border border-line bg-surface p-4 sm:p-6">
                        @csrf

                        <fieldset>
                            <legend class="font-bold">1. Pick a day</legend>
                            <p class="text-sm text-muted">{{ $months }} · times in India time (IST)</p>
                            <div class="mt-3 grid grid-cols-7 gap-1.5 text-center">
                                @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $weekday)
                                    <span aria-hidden="true" class="pb-1 text-[13px] text-muted">{{ $weekday }}</span>
                                @endforeach
                                @for ($blank = 1; $blank < $firstDay->dayOfWeekIso; $blank++)
                                    <span aria-hidden="true"></span>
                                @endfor
                                @foreach ($days as $date => $slots)
                                    @php($day = CarbonImmutable::parse($date, $timezone))
                                    @if ($slots)
                                        <label class="flex h-11 cursor-pointer items-center justify-center rounded-[10px] bg-brand/10 font-semibold text-brand hover:bg-brand/20 has-checked:bg-brand has-checked:text-white has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-brand">
                                            <input type="radio" name="day" value="{{ $date }}" class="sr-only" @checked($date === $selectedDay)>
                                            <span class="sr-only">{{ $day->format('l, j F') }}</span>
                                            <span aria-hidden="true">{{ $day->day }}</span>
                                        </label>
                                    @else
                                        <span aria-hidden="true" class="flex h-11 items-center justify-center rounded-[10px] text-muted">{{ $day->day }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="font-bold">2. Pick a time</legend>
                            @error('starts_at')
                                <p class="mt-1 text-sm font-semibold text-brand">{{ $message }}</p>
                            @enderror
                            @foreach ($days as $date => $slots)
                                @continue(! $slots)
                                <div data-times-for="{{ $date }}" @if ($date !== $selectedDay) hidden @endif class="mt-3 grid grid-cols-[repeat(auto-fill,minmax(6.5rem,1fr))] gap-2">
                                    @foreach ($slots as $slot)
                                        <label class="flex min-h-11 cursor-pointer items-center justify-center rounded-[10px] border border-line px-3 py-2 font-semibold hover:border-brand has-checked:border-brand has-checked:bg-brand has-checked:text-white has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-brand">
                                            <input type="radio" name="starts_at" value="{{ $slot->toIso8601String() }}" class="sr-only" @checked(old('starts_at') === $slot->toIso8601String())>
                                            {{ $slot->format('g:i a') }}
                                        </label>
                                    @endforeach
                                </div>
                            @endforeach
                        </fieldset>

                        <fieldset class="flex flex-col gap-4">
                            <legend class="mb-4 font-bold">3. Your details</legend>

                            <x-input name="name" label="Your name" autocomplete="name" required maxlength="100" />
                            <x-input name="partner_name" label="Your partner's name" hint="(optional)" maxlength="100" />
                            <x-input name="email" label="Email" type="email" autocomplete="email" required hint="(for your confirmation)" />
                            <x-input name="phone" label="WhatsApp number" type="tel" autocomplete="tel" required placeholder="+91 98765 43210" />

                            <div class="flex flex-col gap-1.5">
                                <label for="language" class="font-semibold">Language for the call</label>
                                <select id="language" name="language" class="form-control">
                                    @foreach (config('booking.languages') as $language)
                                        <option @selected(old('language') === $language)>{{ $language }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <fieldset>
                                <legend class="font-semibold">Who will join the call?</legend>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach (['1' => 'Both of us', '0' => 'Just me for now'] as $value => $label)
                                        <label class="flex min-h-11 cursor-pointer items-center gap-2 rounded-[10px] border border-line px-4 has-checked:border-brand has-checked:bg-brand/10">
                                            <input type="radio" name="partner_joining" value="{{ $value }}" class="size-4 accent-brand" @checked(old('partner_joining', '1') === (string) $value)>
                                            {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>

                            <div class="flex flex-col gap-1.5">
                                <label for="notes" class="font-semibold">Anything you'd like me to know first? <span class="font-normal text-muted">(optional)</span></label>
                                <textarea id="notes" name="notes" rows="3" maxlength="1000" class="form-control">{{ old('notes') }}</textarea>
                            </div>

                            {{-- Spam trap: hidden from people, filled in by bots --}}
                            <div class="sr-only" aria-hidden="true">
                                <label for="website">Leave this empty</label>
                                <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                            </div>
                        </fieldset>

                        <div class="flex flex-col gap-2">
                            <x-button size="lg" class="w-full">Book my free call</x-button>
                            <p class="text-center text-sm text-muted">You'll get a confirmation email with a calendar invite.</p>
                        </div>
                    </form>
                @else
                    <div class="flex flex-col gap-2 rounded-[20px] border border-line bg-surface p-6">
                        <h2 class="font-serif text-2xl font-semibold">No times are open right now</h2>
                        <p class="text-body">The next three weeks are full. Message me on WhatsApp and we'll find a time.</p>
                    </div>
                @endif

                <x-button :href="config('site.whatsapp_url')" variant="outline" class="w-full">
                    <x-icon name="chat" class="size-5" stroke-width="1.8" />
                    Prefer WhatsApp? Message me
                </x-button>
            </div>
        </div>

        <div class="mx-auto mt-10 max-w-site px-6">
            <aside class="flex items-start gap-4 rounded-2xl bg-panel px-6 py-5">
                <x-icon name="shield" class="mt-0.5 size-7 shrink-0 text-brand" stroke-width="1.7" />
                <p class="text-small"><strong>This is coaching, not therapy.</strong> If you ever feel afraid at home, please call the Women Helpline 181, or 112 in an emergency. For emotional support any time, call Tele-MANAS on 14416.</p>
            </aside>
        </div>
    </div>

</x-layouts.app>
