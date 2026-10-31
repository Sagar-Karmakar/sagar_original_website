<x-layouts.admin title="Bookings">

    <div class="flex flex-col gap-12">
        <section class="flex flex-col gap-6">
            <h1 class="font-serif text-h2 font-semibold">Upcoming calls</h1>

            @forelse ($upcoming as $day => $bookings)
                <div class="flex flex-col gap-3">
                    <h2 class="font-bold">{{ $day }}</h2>
                    @foreach ($bookings as $booking)
                        <article class="flex flex-col gap-4 rounded-2xl border border-line bg-surface p-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex min-w-0 flex-col gap-1">
                                <p class="font-serif text-xl font-semibold">{{ $booking->localStart()->format('g:i a') }} · {{ $booking->couple() }}</p>
                                <p class="text-small text-muted">{{ $booking->language }} · {{ $booking->partner_joining ? 'Both joining' : 'One partner for now' }}</p>
                                <p class="text-small break-words">
                                    <a href="{{ $booking->whatsappUrl() }}" class="text-brand underline hover:decoration-2">WhatsApp {{ $booking->phone }}</a>
                                    · <a href="mailto:{{ $booking->email }}" class="text-brand underline hover:decoration-2">{{ $booking->email }}</a>
                                </p>
                                @if ($booking->notes)
                                    <p class="mt-2 rounded-xl bg-panel px-4 py-3 text-small whitespace-pre-line">{{ $booking->notes }}</p>
                                @endif
                            </div>
                            <details class="shrink-0">
                                <summary class="cursor-pointer text-small font-semibold text-muted">Cancel…</summary>
                                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="mt-2">
                                    @csrf
                                    <x-button variant="outline" size="sm">Cancel and email them</x-button>
                                </form>
                            </details>
                        </article>
                    @endforeach
                </div>
            @empty
                <p class="rounded-2xl border-2 border-dashed border-dash bg-surface p-6 text-muted">
                    No calls booked yet. Share <a href="{{ route('call') }}" class="text-brand underline">{{ route('call') }}</a> to get your first.
                </p>
            @endforelse
        </section>

        @if ($recent->isNotEmpty())
            <section class="flex flex-col gap-4">
                <h2 class="font-serif text-2xl font-semibold">Past and cancelled</h2>
                <div class="overflow-x-auto rounded-2xl border border-line bg-surface">
                    <table class="w-full text-left text-small">
                        <thead class="border-b border-line text-muted">
                            <tr>
                                <th scope="col" class="px-4 py-3 font-semibold">When</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Who</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recent as $booking)
                                <tr class="border-b border-line last:border-0">
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $booking->when() }}</td>
                                    <td class="px-4 py-3">{{ $booking->couple() }} · <a href="{{ $booking->whatsappUrl() }}" class="text-brand underline">{{ $booking->phone }}</a></td>
                                    <td class="px-4 py-3">{{ $booking->isCancelled() ? 'Cancelled' : 'Done' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>

</x-layouts.admin>
