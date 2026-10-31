<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingAvailability;
use App\Services\BookingNotifier;
use Carbon\CarbonImmutable;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * The free call page with the booking calendar.
     */
    public function create(BookingAvailability $availability): View
    {
        $days = $availability->days();
        $openDays = collect($days)->filter()->keys();

        return view('call', [
            'days' => $days,
            // Keep the day picked before a validation error, unless it has filled up since
            'selectedDay' => $openDays->contains(old('day')) ? old('day') : $openDays->first(),
        ]);
    }

    public function store(Request $request, BookingAvailability $availability, BookingNotifier $notifier): RedirectResponse
    {
        $data = $request->validate([
            'starts_at' => ['required', 'date'],
            'name' => ['required', 'string', 'max:100'],
            'partner_name' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9+\-\s()]{7,32}$/'],
            'language' => ['required', Rule::in(config('booking.languages'))],
            'partner_joining' => ['required', 'boolean'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'website' => ['prohibited'], // left empty by people, filled in by spam bots
        ], [
            'starts_at.required' => 'Pick a day and a time for your call.',
            'phone.regex' => 'Please enter a phone number, like +91 98765 43210.',
            'partner_joining.required' => 'Let me know who will join the call.',
        ]);

        $start = CarbonImmutable::parse($data['starts_at'])->utc();
        $taken = ['starts_at' => 'Sorry, that time was just taken. Please pick another one.'];

        if (! $availability->isOpen($start)) {
            return back()->withInput()->withErrors($taken);
        }

        try {
            $booking = Booking::create([
                ...collect($data)->except(['starts_at', 'website'])->all(),
                'starts_at' => $start,
                'ends_at' => $start->addMinutes(config('booking.duration')),
                'active_slot' => $start,
            ]);
        } catch (UniqueConstraintViolationException) {
            return back()->withInput()->withErrors($taken);
        }

        $notifier->booked($booking);

        return redirect(URL::signedRoute('call.booked', $booking));
    }

    /**
     * Confirmation page, reached through the signed link in the email.
     */
    public function show(Booking $booking): View
    {
        return view('call-booked', ['booking' => $booking]);
    }

    public function calendar(Booking $booking): Response
    {
        return response($booking->toIcs(), 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="free-call.ics"',
        ]);
    }

    public function cancel(Booking $booking, BookingNotifier $notifier): RedirectResponse
    {
        if (! $booking->isCancelled() && ! $booking->isPast()) {
            $booking->cancel();
            $notifier->cancelled($booking, byClient: true);
        }

        return redirect(URL::signedRoute('call.booked', $booking))->with('status', 'Your call is cancelled.');
    }
}
