<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Booking extends Model
{
    use HasUlids, Prunable;

    /**
     * Bookings are deleted 12 months after the call, as the privacy policy promises
     * (`php artisan model:prune`, run daily by the scheduler).
     */
    public function prunable(): Builder
    {
        return static::where('starts_at', '<', now()->subMonths(12));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'starts_at',
        'ends_at',
        'active_slot',
        'name',
        'partner_name',
        'email',
        'phone',
        'language',
        'partner_joining',
        'notes',
        'google_event_id',
        'cancelled_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'immutable_datetime',
            'ends_at' => 'immutable_datetime',
            'active_slot' => 'immutable_datetime',
            'cancelled_at' => 'immutable_datetime',
            'partner_joining' => 'boolean',
        ];
    }

    /**
     * The public id used in links; the numeric id stays private.
     *
     * @return list<string>
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNull('cancelled_at');
    }

    public function isCancelled(): bool
    {
        return $this->cancelled_at !== null;
    }

    public function isPast(): bool
    {
        return $this->starts_at->isPast();
    }

    public function cancel(): void
    {
        $this->update(['cancelled_at' => now(), 'active_slot' => null]);
    }

    /**
     * The start time in the booking timezone (India time).
     */
    public function localStart(): CarbonImmutable
    {
        return $this->starts_at->setTimezone(config('booking.timezone'));
    }

    /**
     * "Tuesday, 3 November at 7:30 pm IST"
     */
    public function when(): string
    {
        return $this->localStart()->format('l, j F \a\t g:i a').' IST';
    }

    public function couple(): string
    {
        return $this->partner_name ? "{$this->name} & {$this->partner_name}" : $this->name;
    }

    /**
     * Chat link for the client's number; 10-digit numbers are taken as Indian.
     */
    public function whatsappUrl(): string
    {
        $digits = preg_replace('/\D/', '', $this->phone);

        return 'https://wa.me/'.(strlen($digits) === 10 ? '91'.$digits : $digits);
    }

    public function googleCalendarUrl(): string
    {
        return 'https://calendar.google.com/calendar/render?'.http_build_query([
            'action' => 'TEMPLATE',
            'text' => 'Free call with Sagar Karmakar',
            'dates' => $this->starts_at->format('Ymd\THis\Z').'/'.$this->ends_at->format('Ymd\THis\Z'),
            'details' => $this->calendarDetails(),
            'location' => config('booking.meeting_url') ?: 'Online',
        ]);
    }

    /**
     * The booking as an iCalendar file, for Apple, Outlook and other calendars.
     */
    public function toIcs(): string
    {
        $escape = fn (string $text) => str_replace("\n", '\n', addcslashes($text, ',;\\'));

        return implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Sagar for Couples//Free call//EN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            "UID:{$this->ulid}@sagarkarmakar.com",
            'DTSTAMP:'.now('UTC')->format('Ymd\THis\Z'),
            'DTSTART:'.$this->starts_at->format('Ymd\THis\Z'),
            'DTEND:'.$this->ends_at->format('Ymd\THis\Z'),
            'SUMMARY:'.$escape('Free call with Sagar Karmakar'),
            'DESCRIPTION:'.$escape($this->calendarDetails()),
            'LOCATION:'.$escape(config('booking.meeting_url') ?: 'Online'),
            $this->isCancelled() ? 'STATUS:CANCELLED' : 'STATUS:CONFIRMED',
            'END:VEVENT',
            'END:VCALENDAR',
        ])."\r\n";
    }

    private function calendarDetails(): string
    {
        return config('booking.meeting_url')
            ? 'Join here: '.config('booking.meeting_url')
            : 'Sagar will send you the call link on WhatsApp before the call.';
    }
}
