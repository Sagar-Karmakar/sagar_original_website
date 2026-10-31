<?php

use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use App\Mail\BookingReceived;
use App\Models\BlockedDate;
use App\Models\Booking;
use App\Models\User;
use App\Services\BookingAvailability;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();

    // Monday 2 November 2026, 9 am India time. Starting hours: weekdays 7:30–9:30 pm, weekends 10 am–12 pm.
    $this->travelTo(CarbonImmutable::parse('2026-11-02 09:00', 'Asia/Kolkata')->utc());
});

function openTimes(string $date): array
{
    return collect(app(BookingAvailability::class)->days()[$date])->map->format('H:i')->all();
}

it('offers slots inside the weekly hours', function () {
    expect(app(BookingAvailability::class)->days())->toHaveCount(21)
        ->and(openTimes('2026-11-02'))->toBe(['19:30', '20:00', '20:30', '21:00'])
        ->and(openTimes('2026-11-07'))->toBe(['10:00', '10:30', '11:00', '11:30']);
});

it('keeps the minimum notice', function () {
    $this->travelTo(CarbonImmutable::parse('2026-11-02 16:00', 'Asia/Kolkata')->utc());

    expect(openTimes('2026-11-02'))->toBe(['20:00', '20:30', '21:00']);
});

it('closes blocked days', function () {
    BlockedDate::create(['date' => '2026-11-03']);

    expect(openTimes('2026-11-03'))->toBe([]);
});

it('shows the booking calendar', function () {
    $this->get('/call')->assertOk()->assertSee('Pick a day')->assertSee('7:30 pm');
});

it('books a call and tells both sides', function () {
    $response = $this->post('/call', bookingData());

    $booking = Booking::sole();
    $response->assertRedirect(URL::signedRoute('call.booked', $booking));

    expect($booking->starts_at->toIso8601String())->toBe('2026-11-02T14:00:00+00:00')
        ->and($booking->couple())->toBe('Priya & Rahul');

    Mail::assertSent(BookingConfirmed::class, fn ($mail) => $mail->hasTo('priya@example.com'));
    Mail::assertSent(BookingReceived::class, fn ($mail) => $mail->hasTo(config('booking.notify_email')));

    $this->get(URL::signedRoute('call.booked', $booking))->assertOk()->assertSee('See you on Monday, 2 November');
    $this->get(URL::signedRoute('call.calendar', $booking))->assertOk()->assertSee('DTSTART:20261102T140000Z');
});

it('never double-books a slot', function () {
    $this->post('/call', bookingData());
    $this->post('/call', bookingData(['email' => 'other@example.com']))->assertSessionHasErrors('starts_at');

    expect(Booking::count())->toBe(1)
        ->and(openTimes('2026-11-02'))->toBe(['20:00', '20:30', '21:00']);
});

it('rejects times outside the weekly hours', function () {
    $this->post('/call', bookingData(['starts_at' => '2026-11-02T15:00:00+05:30']))->assertSessionHasErrors('starts_at');

    expect(Booking::count())->toBe(0);
});

it('turns away bots that fill the hidden field', function () {
    $this->post('/call', bookingData(['website' => 'spam.example']))->assertSessionHasErrors('website');

    expect(Booking::count())->toBe(0);
});

it('needs the signed link to see a booking', function () {
    $this->post('/call', bookingData());

    $this->get(route('call.booked', Booking::sole()))->assertForbidden();
});

it('lets the couple cancel and reopens the slot', function () {
    $this->post('/call', bookingData());
    $booking = Booking::sole();

    $this->post(URL::signedRoute('call.cancel', $booking))->assertRedirect();

    expect($booking->fresh()->isCancelled())->toBeTrue();
    Mail::assertSent(BookingCancelled::class, fn ($mail) => $mail->byClient && $mail->hasTo(config('booking.notify_email')));

    $this->post('/call', bookingData(['email' => 'other@example.com']))->assertSessionHasNoErrors();
});

it('keeps the admin area behind a login', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
    $this->get('/admin/availability')->assertRedirect('/admin/login');
});

it('logs the admin in', function () {
    User::factory()->create(['email' => 'sagar@example.com', 'password' => 'a-long-password']);

    $this->post('/admin/login', ['email' => 'sagar@example.com', 'password' => 'wrong-password'])->assertSessionHasErrors('email');
    $this->post('/admin/login', ['email' => 'sagar@example.com', 'password' => 'a-long-password'])->assertRedirect('/admin');

    $this->assertAuthenticated();
});

it('lets the admin see and cancel bookings', function () {
    $this->post('/call', bookingData());
    $booking = Booking::sole();
    $admin = User::factory()->create();

    $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Priya &amp; Rahul', escape: false);
    $this->actingAs($admin)->post(route('admin.bookings.cancel', $booking))->assertRedirect();

    expect($booking->fresh()->isCancelled())->toBeTrue();
    Mail::assertSent(BookingCancelled::class, fn ($mail) => ! $mail->byClient && $mail->hasTo('priya@example.com'));
});

it('lets the admin set weekly hours and days off', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin)->get('/admin/availability')->assertOk();
    $this->actingAs($admin)->put(route('admin.availability.update'), [
        'days' => [1 => ['open' => '1', 'opens_at' => '18:00', 'closes_at' => '19:00'], 2 => ['open' => '0']],
    ])->assertSessionHasNoErrors();

    expect(openTimes('2026-11-02'))->toBe(['18:00', '18:30'])
        ->and(openTimes('2026-11-03'))->toBe([]);

    $this->actingAs($admin)->put(route('admin.availability.update'), [
        'days' => [1 => ['open' => '1', 'opens_at' => '19:00', 'closes_at' => '18:00']],
    ])->assertSessionHasErrors('days.1.closes_at');

    $this->actingAs($admin)->post(route('admin.blocked-dates.store'), ['date' => '2026-11-09'])->assertSessionHasNoErrors();
    expect(openTimes('2026-11-09'))->toBe([]);
});
