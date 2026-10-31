<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedDate;
use App\Models\WeeklyHour;
use App\Services\GoogleCalendar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AvailabilityController extends Controller
{
    public const WEEKDAYS = [1 => 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    public function edit(GoogleCalendar $calendar): View
    {
        return view('admin.availability', [
            'weekdays' => self::WEEKDAYS,
            'hours' => WeeklyHour::all()->keyBy('weekday'),
            'blockedDates' => BlockedDate::where('date', '>=', now(config('booking.timezone'))->toDateString())->orderBy('date')->get(),
            'calendar' => $calendar,
            'calendarConnection' => $calendar->connection(),
        ]);
    }

    /**
     * Save the weekly hours: one open window per day.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'days' => ['array'],
            'days.*.open' => ['nullable', 'boolean'],
            'days.*.opens_at' => ['nullable', 'date_format:H:i'],
            'days.*.closes_at' => ['nullable', 'date_format:H:i'],
        ]);

        $open = collect($data['days'] ?? [])
            ->only(array_keys(self::WEEKDAYS))
            ->filter(fn (array $day) => ! empty($day['open']));

        foreach ($open as $weekday => $day) {
            if (empty($day['opens_at']) || empty($day['closes_at']) || $day['closes_at'] <= $day['opens_at']) {
                throw ValidationException::withMessages([
                    "days.{$weekday}.closes_at" => self::WEEKDAYS[$weekday].' needs a start time and a later end time.',
                ]);
            }
        }

        DB::transaction(function () use ($open) {
            WeeklyHour::query()->delete();

            foreach ($open as $weekday => $day) {
                WeeklyHour::create(['weekday' => $weekday, 'opens_at' => $day['opens_at'], 'closes_at' => $day['closes_at']]);
            }
        });

        return back()->with('status', 'Weekly hours saved.');
    }

    public function blockDate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today', 'unique:blocked_dates,date'],
            'note' => ['nullable', 'string', 'max:255'],
        ], [
            'date.unique' => 'That day is already blocked.',
        ]);

        BlockedDate::create($data);

        return back()->with('status', 'Day blocked. Existing bookings on it are kept; cancel them on the bookings page if needed.');
    }

    public function unblockDate(BlockedDate $blockedDate): RedirectResponse
    {
        $blockedDate->delete();

        return back()->with('status', 'Day opened again.');
    }
}
