<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleCalendar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class GoogleCalendarController extends Controller
{
    /**
     * Send Sagar to Google to allow access to his calendar.
     */
    public function connect(Request $request, GoogleCalendar $calendar): RedirectResponse
    {
        abort_unless($calendar->isConfigured(), 404);

        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        return redirect()->away($calendar->authorizationUrl($state));
    }

    /**
     * Google sends Sagar back here after he allows (or denies) access.
     */
    public function callback(Request $request, GoogleCalendar $calendar): RedirectResponse
    {
        $state = $request->session()->pull('google_oauth_state');

        if (! $state || ! hash_equals($state, (string) $request->query('state')) || ! $request->filled('code')) {
            return to_route('admin.availability')->with('status', 'Google Calendar was not connected. Please try again.');
        }

        try {
            $connection = $calendar->connect($request->query('code'));
        } catch (Throwable $e) {
            report($e);

            return to_route('admin.availability')->with('status', 'Google Calendar could not be connected: '.$e->getMessage());
        }

        $added = $calendar->addUpcomingBookings();

        return to_route('admin.availability')->with('status', "Connected to {$connection->google_email}. ".($added
            ? "{$added} upcoming ".Str::plural('call', $added).' added to your calendar.'
            : 'New bookings will appear in your calendar.'));
    }

    public function disconnect(GoogleCalendar $calendar): RedirectResponse
    {
        $calendar->disconnect();

        return back()->with('status', 'Google Calendar disconnected. Events already added stay in your calendar.');
    }
}
