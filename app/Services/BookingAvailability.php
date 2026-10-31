<?php

namespace App\Services;

use App\Models\BlockedDate;
use App\Models\Booking;
use App\Models\WeeklyHour;
use Carbon\CarbonImmutable;

class BookingAvailability
{
    /**
     * Open slots for every day from today to the end of the booking window,
     * keyed by date (Y-m-d, India time). Days with nothing open have an empty list.
     *
     * @return array<string, list<CarbonImmutable>>
     */
    public function days(): array
    {
        $timezone = config('booking.timezone');
        $duration = config('booking.duration');
        $interval = config('booking.interval');

        $today = CarbonImmutable::now($timezone)->startOfDay();
        $lastDay = $today->addDays(config('booking.days_ahead') - 1);
        $earliest = CarbonImmutable::now($timezone)->addHours(config('booking.min_notice'));

        $hours = WeeklyHour::orderBy('opens_at')->get()->groupBy('weekday');

        $blocked = BlockedDate::whereBetween('date', [$today->toDateString(), $lastDay->toDateString()])
            ->pluck('date')
            ->map(fn ($date) => substr($date, 0, 10))
            ->all();

        $booked = Booking::active()
            ->whereBetween('starts_at', [$today->utc(), $lastDay->endOfDay()->utc()])
            ->get(['starts_at', 'ends_at']);

        $days = [];

        for ($day = $today; $day <= $lastDay; $day = $day->addDay()) {
            $slots = [];

            if (! in_array($day->toDateString(), $blocked)) {
                foreach ($hours->get($day->dayOfWeekIso, []) as $window) {
                    $closes = $day->setTimeFromTimeString($window->closes_at);

                    for ($slot = $day->setTimeFromTimeString($window->opens_at); $slot->addMinutes($duration) <= $closes; $slot = $slot->addMinutes($interval)) {
                        $end = $slot->addMinutes($duration);
                        $taken = $booked->contains(fn (Booking $booking) => $slot < $booking->ends_at && $end > $booking->starts_at);

                        if ($slot >= $earliest && ! $taken) {
                            $slots[] = $slot;
                        }
                    }
                }
            }

            $days[$day->toDateString()] = $slots;
        }

        return $days;
    }

    /**
     * Whether a call can still be booked at this exact start time.
     */
    public function isOpen(CarbonImmutable $start): bool
    {
        $slots = $this->days()[$start->setTimezone(config('booking.timezone'))->toDateString()] ?? [];

        return collect($slots)->contains(fn (CarbonImmutable $slot) => $slot->eq($start));
    }
}
