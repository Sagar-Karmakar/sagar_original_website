<?php

use App\Http\Controllers\Admin\PhoneAppController;
use App\Models\Booking;
use App\Models\PushSubscription;
use App\Models\User;
use App\Services\PushNotifier;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

uses(RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
    $this->travelTo(CarbonImmutable::parse('2026-11-02 09:00', 'Asia/Kolkata')->utc());
    $this->admin = User::factory()->create();
});

function subscriptionData(array $overrides = []): array
{
    return [
        'endpoint' => 'https://fcm.googleapis.com/fcm/send/device-1',
        'keys' => ['p256dh' => 'BNcRdreALRFXTkOOUHK1EtK2wtaz5Ry4YfYCA_0QTpQtUbVlUls0VJXg7A8u-Ts1XbjhazAkj7I99e8QcYP7DkM', 'auth' => 'tBHItJI5svbpez7KI4CCXg'],
        'contentEncoding' => 'aes128gcm',
        ...$overrides,
    ];
}

it('shows the phone app page to the admin only', function () {
    $this->get('/admin/app')->assertRedirect('/admin/login');
    $this->actingAs($this->admin)->get('/admin/app')->assertOk()->assertSee('Turn on booking notifications');
});

it('saves a device once and removes it again', function () {
    $this->actingAs($this->admin)->postJson('/admin/push-subscriptions', subscriptionData())->assertOk();
    $this->actingAs($this->admin)->postJson('/admin/push-subscriptions', subscriptionData())->assertOk();

    expect(PushSubscription::count())->toBe(1)
        ->and(PushSubscription::sole()->public_key)->toStartWith('BNcRdre');

    $this->actingAs($this->admin)->deleteJson('/admin/push-subscriptions', ['endpoint' => 'https://fcm.googleapis.com/fcm/send/device-1'])->assertOk();

    expect(PushSubscription::count())->toBe(0);
});

it('only accepts https push endpoints', function () {
    $this->actingAs($this->admin)->postJson('/admin/push-subscriptions', subscriptionData(['endpoint' => 'http://example.com/push']))
        ->assertUnprocessable();
});

it('notifies the phone about new bookings and couple cancellations, not your own', function () {
    $push = $this->mock(PushNotifier::class);
    // Two bookings, one cancelled by the couple, one by the admin (no notification for that)
    $push->shouldReceive('send')->twice()->withArgs(fn ($title, $body) => $title === 'New free call: Priya & Rahul'
        && $body === 'Monday, 2 November at 7:30 pm IST · English · both joining')->andReturn(1);
    $push->shouldReceive('send')->once()->withArgs(fn ($title) => $title === 'Cancelled: Priya & Rahul')->andReturn(1);

    $this->post('/call', bookingData());
    $this->post(URL::signedRoute('call.cancel', Booking::sole()));

    $this->post('/call', bookingData(['email' => 'second@example.com']));
    $this->actingAs($this->admin)->post(route('admin.bookings.cancel', Booking::latest('id')->first()));
});

it('sends a test notification from the admin', function () {
    $this->mock(PushNotifier::class)->shouldReceive('send')->once()->andReturn(2);

    $this->actingAs($this->admin)->post('/admin/push/test')->assertSessionHas('status', 'Test sent to 2 devices.');
});

it('sends nothing when no device has notifications on', function () {
    expect(app(PushNotifier::class)->send('Title', 'Body'))->toBe(0);
});

it('serves the Android app to the admin when it has been built', function () {
    $this->get('/admin/app/android')->assertRedirect('/admin/login');

    $response = $this->actingAs($this->admin)->get('/admin/app/android');

    is_file(base_path(PhoneAppController::APK_PATH)) ? $response->assertOk()->assertDownload('sagar-admin.apk') : $response->assertNotFound();
});

it('has an installable app manifest', function () {
    $manifest = json_decode(file_get_contents(public_path('admin-manifest.json')), true, flags: JSON_THROW_ON_ERROR);

    expect($manifest)->toMatchArray(['start_url' => '/admin', 'display' => 'standalone'])
        ->and(collect($manifest['icons'])->pluck('sizes')->unique()->values()->all())->toBe(['192x192', '512x512']);

    foreach ($manifest['icons'] as $icon) {
        expect(public_path($icon['src']))->toBeFile();
    }
});
