<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\CalendarConnection;
use Closure;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

/**
 * Puts bookings into Sagar's Google Calendar once he connects it in /admin/availability.
 * Talks to Google's REST API directly. A failed update is saved on the connection and
 * shown in the admin; it never stops a booking.
 */
class GoogleCalendar
{
    private const AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';

    private const TOKEN_URL = 'https://oauth2.googleapis.com/token';

    private const REVOKE_URL = 'https://oauth2.googleapis.com/revoke';

    private const EVENTS_URL = 'https://www.googleapis.com/calendar/v3/calendars/%s/events';

    public function isConfigured(): bool
    {
        return filled(config('services.google.client_id')) && filled(config('services.google.client_secret'));
    }

    public function connection(): ?CalendarConnection
    {
        return CalendarConnection::first();
    }

    /**
     * Google's consent page, which sends Sagar back to the callback route with a code.
     */
    public function authorizationUrl(string $state): string
    {
        return self::AUTH_URL.'?'.http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => route('admin.google.callback'),
            'response_type' => 'code',
            'scope' => 'openid email https://www.googleapis.com/auth/calendar.events',
            'access_type' => 'offline',
            'prompt' => 'consent', // always hand back a refresh token
            'state' => $state,
        ]);
    }

    /**
     * Swap the code from Google's callback for tokens and save the connection.
     */
    public function connect(string $code): CalendarConnection
    {
        $tokens = Http::asForm()->post(self::TOKEN_URL, [
            'code' => $code,
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => route('admin.google.callback'),
            'grant_type' => 'authorization_code',
        ])->throw()->json();

        if (empty($tokens['refresh_token'])) {
            throw new RuntimeException('Google did not send a refresh token. Please try connecting again.');
        }

        // The ID token came straight from Google over HTTPS, so its email can be read without checking the signature
        $claims = json_decode(base64_decode(strtr(explode('.', $tokens['id_token'] ?? '')[1] ?? '', '-_', '+/')), true);

        CalendarConnection::query()->delete();

        return CalendarConnection::create([
            'google_email' => $claims['email'] ?? 'your Google account',
            'refresh_token' => $tokens['refresh_token'],
            'access_token' => $tokens['access_token'],
            'access_token_expires_at' => now()->addSeconds($tokens['expires_in'] - 60),
        ]);
    }

    public function disconnect(): void
    {
        if ($connection = $this->connection()) {
            // Best effort: the connection is removed here even if Google can't be reached
            rescue(fn () => Http::asForm()->timeout(10)->post(self::REVOKE_URL, ['token' => $connection->refresh_token]));
            $connection->delete();
        }
    }

    public function addBooking(Booking $booking): void
    {
        $this->sync(function (CalendarConnection $connection) use ($booking) {
            $event = $this->api($connection)->post($this->eventsUrl($connection), $this->eventFor($booking))->throw()->json();

            $booking->update(['google_event_id' => $event['id']]);
        });
    }

    public function removeBooking(Booking $booking): void
    {
        if (! $booking->google_event_id) {
            return;
        }

        $this->sync(function (CalendarConnection $connection) use ($booking) {
            $response = $this->api($connection)->delete($this->eventsUrl($connection).'/'.rawurlencode($booking->google_event_id));

            // Already deleted by hand in Google Calendar is fine
            if (! in_array($response->status(), [404, 410])) {
                $response->throw();
            }

            $booking->update(['google_event_id' => null]);
        });
    }

    /**
     * Add the upcoming bookings made before the calendar was connected.
     */
    public function addUpcomingBookings(): int
    {
        $bookings = Booking::active()->whereNull('google_event_id')->where('starts_at', '>', now())->get();

        $bookings->each(fn (Booking $booking) => $this->addBooking($booking));

        return $bookings->count();
    }

    private function sync(Closure $update): void
    {
        if (! $this->isConfigured() || ! $connection = $this->connection()) {
            return;
        }

        try {
            $update($connection);
            $connection->update(['last_error' => null]);
        } catch (Throwable $e) {
            report($e);
            $connection->update(['last_error' => Str::limit($e->getMessage(), 500)]);
        }
    }

    private function api(CalendarConnection $connection): PendingRequest
    {
        return Http::withToken($this->accessToken($connection))->acceptJson()->timeout(10);
    }

    /**
     * Access tokens last an hour; the refresh token gets a new one when needed.
     */
    private function accessToken(CalendarConnection $connection): string
    {
        if ($connection->access_token && $connection->access_token_expires_at?->isFuture()) {
            return $connection->access_token;
        }

        $tokens = Http::asForm()->timeout(10)->post(self::TOKEN_URL, [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $connection->refresh_token,
            'grant_type' => 'refresh_token',
        ])->throw()->json();

        $connection->update([
            'access_token' => $tokens['access_token'],
            'access_token_expires_at' => now()->addSeconds($tokens['expires_in'] - 60),
        ]);

        return $tokens['access_token'];
    }

    private function eventsUrl(CalendarConnection $connection): string
    {
        return sprintf(self::EVENTS_URL, rawurlencode($connection->calendar_id));
    }

    /**
     * @return array<string, mixed>
     */
    private function eventFor(Booking $booking): array
    {
        $details = array_filter([
            "WhatsApp: {$booking->phone} ({$booking->whatsappUrl()})",
            "Email: {$booking->email}",
            "Language: {$booking->language}",
            'Joining: '.($booking->partner_joining ? 'Both of them' : 'Just one of them for now'),
            $booking->notes ? "What they'd like you to know: {$booking->notes}" : null,
            'All bookings: '.route('admin.bookings'),
        ]);

        return array_filter([
            'summary' => "Free call: {$booking->couple()}",
            'description' => implode("\n", $details),
            'location' => config('booking.meeting_url'),
            'start' => ['dateTime' => $booking->starts_at->toIso8601String(), 'timeZone' => config('booking.timezone')],
            'end' => ['dateTime' => $booking->ends_at->toIso8601String(), 'timeZone' => config('booking.timezone')],
        ]);
    }
}
