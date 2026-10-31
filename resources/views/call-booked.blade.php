<x-layouts.app :title="$booking->isCancelled() ? 'Call cancelled' : 'You\'re booked'" nav="focused" footer="minimal">

    <div class="mx-auto flex max-w-190 flex-col gap-6 px-6 pt-[clamp(2.5rem,6vw,5.5rem)] pb-section">
        @if (session('status'))
            <p role="status" class="rounded-xl bg-brand/10 px-4 py-3 font-semibold text-brand">{{ session('status') }}</p>
        @endif

        @if ($booking->isCancelled())
            <x-eyebrow>Cancelled</x-eyebrow>
            <h1 class="font-serif text-h1 font-semibold">This call is cancelled.</h1>
            <p class="text-lead text-body">It was on {{ $booking->when() }}. Whenever you're ready, pick a new time.</p>
            <div>
                <x-button :href="route('call')" size="lg">Pick a new time</x-button>
            </div>
        @else
            <x-eyebrow>You're booked</x-eyebrow>
            <h1 class="font-serif text-h1 font-semibold">See you on {{ $booking->localStart()->format('l, j F') }}.</h1>

            <div class="flex flex-col gap-2 rounded-2xl border border-line bg-surface p-7">
                <p class="font-serif text-2xl font-semibold">{{ $booking->localStart()->format('g:i a') }} India time (IST)</p>
                <p class="text-muted">Free call with Sagar Karmakar · {{ config('booking.duration') }} minutes · Online</p>
                @if (config('booking.meeting_url'))
                    <p>Join here when it's time: <a href="{{ config('booking.meeting_url') }}" class="font-semibold text-brand underline hover:decoration-2">{{ config('booking.meeting_url') }}</a></p>
                @else
                    <p>I'll send you the call link on WhatsApp ({{ $booking->phone }}) before we start.</p>
                @endif
                <p class="text-small text-muted">A confirmation is on its way to {{ $booking->email }}.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <x-button :href="$booking->googleCalendarUrl()" variant="outline">Add to Google Calendar</x-button>
                <x-button :href="URL::signedRoute('call.calendar', $booking)" variant="outline">Add to Apple or Outlook</x-button>
            </div>

            <div class="flex flex-col gap-3 rounded-2xl border border-line bg-surface p-7">
                <h2 class="font-serif text-2xl font-semibold">What happens on the call</h2>
                <ol class="flex list-decimal flex-col gap-2 pl-[22px]">
                    <li>You tell me what's been happening between you two.</li>
                    <li>I ask what you've already tried, and what you'd like instead.</li>
                    <li>I tell you honestly whether Back to Us can help, and what it costs. If it's not the right fit, I'll say so.</li>
                </ol>
            </div>

            @unless ($booking->isPast())
                <details class="rounded-2xl bg-panel px-6 py-4">
                    <summary class="cursor-pointer font-semibold">Can't make it?</summary>
                    <div class="mt-3 flex flex-col items-start gap-3">
                        <p class="text-body">Cancel here, then pick a new time whenever it suits you.</p>
                        <form method="POST" action="{{ URL::signedRoute('call.cancel', $booking) }}">
                            @csrf
                            <x-button variant="outline" size="sm">Cancel this call</x-button>
                        </form>
                    </div>
                </details>
            @endunless
        @endif
    </div>

</x-layouts.app>
