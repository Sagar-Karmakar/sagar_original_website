<?php

use App\Models\Booking;
use App\Models\CalendarConnection;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
    config(['services.google.client_id' => 'client-id', 'services.google.client_secret' => 'client-secret']);
    $this->travelTo(CarbonImmutable::parse('2026-11-02 09:00', 'Asia/Kolkata')->utc());
});

function connectCalendar(array $attributes = []): CalendarConnection
{
    return CalendarConnection::create([
        'google_email' => 'sagar@gmail.com',
        'refresh_token' => 'refresh-token',
        'access_token' => 'access-token',
        'access_token_expires_at' => now()->addHour(),
        ...$attributes,
    ]);
}

it('connects to Google and adds calls booked before connecting', function () {
    $this->post('/call', bookingData());
    $admin = User::factory()->create();

    $redirect = $this->actingAs($admin)->get('/admin/google/connect');
    $redirect->assertRedirectContains('accounts.google.com');
    $state = session('google_oauth_state');

    $claims = rtrim(strtr(base64_encode(json_encode(['email' => 'sagar@gmail.com'])), '+/', '-_'), '=');
    Http::fake([
        'oauth2.googleapis.com/token' => Http::response([
            'access_token' => 'access-token', 'refresh_token' => 'refresh-token', 'expires_in' => 3599, 'id_token' => "header.{$claims}.signature",
        ]),
        'www.googleapis.com/calendar/*' => Http::response(['id' => 'event-1']),
    ]);

    $this->actingAs($admin)->get("/admin/google/callback?code=auth-code&state={$state}")
        ->assertRedirect('/admin/availability')
        ->assertSessionHas('status', 'Connected to sagar@gmail.com. 1 upcoming call added to your calendar.');

    expect(CalendarConnection::sole()->refresh_token)->toBe('refresh-token')
        ->and(Booking::sole()->google_event_id)->toBe('event-1');
});

it('refuses a callback that did not start here', function () {
    $this->actingAs(User::factory()->create())->get('/admin/google/callback?code=auth-code&state=forged')
        ->assertRedirect('/admin/availability');

    expect(CalendarConnection::count())->toBe(0);
});

it('adds new bookings to the calendar and removes cancelled ones', function () {
    connectCalendar();
    Http::fake(['www.googleapis.com/calendar/*' => Http::sequence()->push(['id' => 'event-1'])->push([], 204)]);

    $this->post('/call', bookingData());
    $booking = Booking::sole();

    Http::assertSent(fn (Request $request) => $request->method() === 'POST'
        && $request->url() === 'https://www.googleapis.com/calendar/v3/calendars/primary/events'
        && $request->hasHeader('Authorization', 'Bearer access-token')
        && $request['summary'] === 'Free call: Priya & Rahul'
        && $request['start']['dateTime'] === '2026-11-02T14:00:00+00:00');
    expect($booking->google_event_id)->toBe('event-1');

    $this->post(URL::signedRoute('call.cancel', $booking));

    Http::assertSent(fn (Request $request) => $request->method() === 'DELETE' && str_ends_with($request->url(), '/events/event-1'));
    expect($booking->fresh()->google_event_id)->toBeNull();
});

it('gets a new access token when the old one has expired', function () {
    connectCalendar(['access_token_expires_at' => now()->subMinute()]);
    Http::fake([
        'oauth2.googleapis.com/token' => Http::response(['access_token' => 'new-token', 'expires_in' => 3599]),
        'www.googleapis.com/calendar/*' => Http::response(['id' => 'event-1']),
    ]);

    $this->post('/call', bookingData());

    Http::assertSent(fn (Request $request) => str_contains($request->url(), '/calendar/') && $request->hasHeader('Authorization', 'Bearer new-token'));
    expect(CalendarConnection::sole()->access_token)->toBe('new-token');
});

it('still books the call when Google fails, and shows the problem in the admin', function () {
    connectCalendar();
    Http::fake(['www.googleapis.com/calendar/*' => Http::response(['error' => 'backendError'], 500)]);

    $this->post('/call', bookingData())->assertSessionHasNoErrors();

    expect(Booking::count())->toBe(1)
        ->and(CalendarConnection::sole()->last_error)->not->toBeNull();

    $this->actingAs(User::factory()->create())->get('/admin/availability')->assertSee('The last calendar update failed');
});

it('does nothing with Google when no calendar is connected', function () {
    Http::fake();

    $this->post('/call', bookingData());

    Http::assertNothingSent();
});
