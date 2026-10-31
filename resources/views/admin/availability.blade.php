<x-layouts.admin title="Availability">

    <div class="flex flex-col gap-12">
        <section class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <h1 class="font-serif text-h2 font-semibold">Weekly hours</h1>
                <p class="max-w-190 text-muted">In India time (IST). Calls are {{ config('booking.duration') }} minutes, and a new one can start every {{ config('booking.interval') }} minutes. Couples can book from {{ config('booking.min_notice') }} hours ahead, up to {{ config('booking.days_ahead') }} days out.</p>
            </div>

            <form method="POST" action="{{ route('admin.availability.update') }}" class="flex flex-col rounded-2xl border border-line bg-surface p-5 sm:p-6">
                @csrf
                @method('PUT')

                @foreach ($weekdays as $number => $weekday)
                    @php($window = $hours->get($number))
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 border-b border-line py-4 first:pt-0">
                        <label class="flex w-full items-center gap-3 font-semibold sm:w-36">
                            <input type="hidden" name="days[{{ $number }}][open]" value="0">
                            <input type="checkbox" name="days[{{ $number }}][open]" value="1" class="size-5 accent-brand"
                                   @checked(old("days.$number.open", $window ? '1' : '0') === '1')>
                            {{ $weekday }}
                        </label>
                        <label>
                            <span class="sr-only">{{ $weekday }} from</span>
                            <input type="time" name="days[{{ $number }}][opens_at]" class="form-control w-auto py-2"
                                   value="{{ old("days.$number.opens_at", $window ? substr($window->opens_at, 0, 5) : '19:30') }}">
                        </label>
                        <span class="text-muted">to</span>
                        <label>
                            <span class="sr-only">{{ $weekday }} until</span>
                            <input type="time" name="days[{{ $number }}][closes_at]" class="form-control w-auto py-2"
                                   value="{{ old("days.$number.closes_at", $window ? substr($window->closes_at, 0, 5) : '21:30') }}">
                        </label>
                        @error("days.$number.closes_at")
                            <p class="w-full text-sm font-semibold text-brand">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="pt-5">
                    <x-button>Save weekly hours</x-button>
                </div>
            </form>
        </section>

        <section class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <h2 class="font-serif text-h2 font-semibold">Days off</h2>
                <p class="text-muted">Block a holiday or a busy day so nobody can book it.</p>
            </div>

            <form method="POST" action="{{ route('admin.blocked-dates.store') }}" class="flex flex-wrap items-end gap-4 rounded-2xl border border-line bg-surface p-5 sm:p-6">
                @csrf
                <div class="flex flex-col gap-1.5">
                    <label for="date" class="font-semibold">Date</label>
                    <input id="date" name="date" type="date" required value="{{ old('date') }}" min="{{ now(config('booking.timezone'))->toDateString() }}" class="form-control w-auto py-2">
                </div>
                <div class="flex min-w-48 flex-1 flex-col gap-1.5">
                    <label for="note" class="font-semibold">Note <span class="font-normal text-muted">(only you see this)</span></label>
                    <input id="note" name="note" type="text" maxlength="255" value="{{ old('note') }}" class="form-control py-2">
                </div>
                <x-button>Block this day</x-button>
                @error('date')
                    <p class="w-full text-sm font-semibold text-brand">{{ $message }}</p>
                @enderror
            </form>

            @if ($blockedDates->isNotEmpty())
                <ul class="flex flex-col divide-y divide-line rounded-2xl border border-line bg-surface">
                    @foreach ($blockedDates as $blocked)
                        <li class="flex flex-wrap items-center justify-between gap-3 px-5 py-3">
                            <span>
                                <strong>{{ \Illuminate\Support\Carbon::parse($blocked->date)->format('l, j F Y') }}</strong>
                                @if ($blocked->note)
                                    <span class="text-muted">· {{ $blocked->note }}</span>
                                @endif
                            </span>
                            <form method="POST" action="{{ route('admin.blocked-dates.destroy', $blocked) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer text-small font-semibold text-brand underline">Open again</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <h2 class="font-serif text-h2 font-semibold">Google Calendar</h2>
                <p class="max-w-190 text-muted">Connect your Google Calendar and every new booking is added to it automatically, with the couple's details. Cancelled calls are removed from it.</p>
            </div>

            <div class="flex flex-col items-start gap-4 rounded-2xl border border-line bg-surface p-5 sm:p-6">
                @if (! $calendar->isConfigured())
                    <p>To turn this on, add <code>GOOGLE_CLIENT_ID</code> and <code>GOOGLE_CLIENT_SECRET</code> to <code>.env</code>. The README's "Google Calendar" section shows how to get them from Google. It's free and takes about 10 minutes.</p>
                @elseif ($calendarConnection)
                    <p><strong>Connected</strong> to {{ $calendarConnection->google_email }}.</p>
                    @if ($calendarConnection->last_error)
                        <p class="rounded-xl bg-brand/10 px-4 py-3 text-small text-brand"><strong>The last calendar update failed:</strong> {{ $calendarConnection->last_error }} If this keeps happening, disconnect and connect again.</p>
                    @endif
                    <form method="POST" action="{{ route('admin.google.disconnect') }}">
                        @csrf
                        <x-button variant="outline" size="sm">Disconnect</x-button>
                    </form>
                @else
                    <x-button :href="route('admin.google.connect')">Connect Google Calendar</x-button>
                    <p class="text-small text-muted">You'll go to Google to allow access to your calendar's events, then come back here.</p>
                @endif
            </div>
        </section>
    </div>

</x-layouts.admin>
