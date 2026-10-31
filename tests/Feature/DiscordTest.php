<?php

use App\Models\Booking;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
    config(['booking.discord_webhook' => 'https://discord.com/api/webhooks/1/token']);
    $this->travelTo(CarbonImmutable::parse('2026-11-02 09:00', 'Asia/Kolkata')->utc());
});

it('posts new bookings and cancellations to Discord', function () {
    Http::fake(['discord.com/*' => Http::response(null, 204)]);

    $this->post('/call', bookingData(['notes' => 'We keep fighting about chores.']));

    Http::assertSent(fn (Request $request) => $request->url() === 'https://discord.com/api/webhooks/1/token'
        && $request['content'] === '**New free call booked:** Priya & Rahul, Monday, 2 November at 7:30 pm IST'
        && $request['allowed_mentions'] === ['parse' => []]
        && collect($request['embeds'][0]['fields'])->contains('value', 'We keep fighting about chores.'));

    $this->post(URL::signedRoute('call.cancel', Booking::sole()));

    Http::assertSent(fn (Request $request) => str_starts_with($request['content'], '**Free call cancelled by the couple:**'));
});

it('still books the call when Discord is down', function () {
    Http::fake(['discord.com/*' => Http::response('Service Unavailable', 503)]);

    $this->post('/call', bookingData())->assertSessionHasNoErrors();

    expect(Booking::count())->toBe(1);
});

it('sends a sample alert with discord:test', function () {
    Http::fake(['discord.com/*' => Http::response(null, 204)]);

    $this->artisan('discord:test')->assertSuccessful();

    Http::assertSent(fn (Request $request) => str_starts_with($request['content'], '**Test: new free call booked:** Priya & Rahul'));
    expect(Booking::count())->toBe(0);
});

it('explains what to do when no webhook is set', function () {
    config(['booking.discord_webhook' => null]);

    $this->artisan('discord:test')->assertFailed();
});
