<?php

use App\Models\Booking;
use App\Models\User;
use App\Services\BookingNotifier;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

// Deletes bookings older than 12 months (see Booking::prunable). Needs the server cron in README → Going online.
Schedule::command('model:prune')->daily();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:create {email? : Leave out to use ADMIN_EMAIL and ADMIN_PASSWORD from .env} {--name=Sagar Karmakar} {--password= : Set the password here instead of being asked}', function (?string $email = null) {
    if ($email === null) {
        ['email' => $email, 'password' => $password] = config('site.admin');

        if (! $email || ! $password) {
            $this->error('Set ADMIN_EMAIL and ADMIN_PASSWORD in .env, or run: php artisan admin:create you@example.com');

            return 1;
        }
    } else {
        $password = $this->option('password') ?: $this->secret('Choose a password (at least 10 characters; it stays hidden while you type)');
    }

    if (strlen((string) $password) < 10) {
        $this->error('The password needs at least 10 characters. Nothing was saved.');

        return 1;
    }

    User::updateOrCreate(['email' => $email], ['name' => $this->option('name'), 'password' => $password]);

    $this->info("Done. Log in at ".route('login')." with {$email}.");
})->purpose('Create the admin login for /admin, or reset its password');

Artisan::command('mail:test {to? : Address to send to (defaults to BOOKING_NOTIFY_EMAIL)}', function (?string $to = null) {
    $to ??= config('booking.notify_email');
    $this->line('Sending through '.config('mail.mailers.smtp.host').' as '.config('mail.from.address').'...');

    try {
        Mail::raw('If you can read this, sagarkarmakar.com can send email.', fn ($message) => $message->to($to)->subject('Test email from sagarkarmakar.com'));
    } catch (Throwable $e) {
        $this->error('Sending failed: '.$e->getMessage());

        return 1;
    }

    $this->info("Sent to {$to}. Check the inbox, and the spam folder.");
})->purpose('Send a test email to check the mail settings');

Artisan::command('discord:test', function (BookingNotifier $notifier) {
    if (! config('booking.discord_webhook')) {
        $this->error('Add DISCORD_BOOKING_WEBHOOK to .env first (Discord → channel settings → Integrations → Webhooks → Copy Webhook URL).');

        return 1;
    }

    // A made-up booking for tomorrow evening; nothing is saved
    $start = CarbonImmutable::tomorrow(config('booking.timezone'))->setTime(19, 30)->utc();
    $booking = new Booking([
        'starts_at' => $start,
        'ends_at' => $start->addMinutes(config('booking.duration')),
        'name' => 'Priya',
        'partner_name' => 'Rahul',
        'email' => 'priya@example.com',
        'phone' => '+91 98765 43210',
        'language' => 'Hindi or Hinglish',
        'partner_joining' => true,
        'notes' => 'This is a test message from php artisan discord:test. No real call was booked.',
    ]);

    try {
        $notifier->postToDiscord('Test: new free call booked', $booking, 0xB81F1F);
    } catch (Throwable $e) {
        $this->error('Discord refused the message: '.$e->getMessage());

        return 1;
    }

    $this->info('Sent. Check your Discord channel.');
})->purpose('Send a sample booking alert to Discord');

Artisan::command('push:keys', function () {
    // Made with OpenSSL directly: the web-push library's own key maker fails on Windows PHP without an openssl.cnf
    $key = openssl_pkey_get_details(openssl_pkey_new(['ec' => ['curve_name' => 'prime256v1', 'private_key_type' => OPENSSL_KEYTYPE_EC]]))['ec'];
    $encode = fn (string $bytes) => rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
    $pad = fn (string $bytes) => str_pad($bytes, 32, "\0", STR_PAD_LEFT);

    $this->line('# Add these to .env. New keys switch off notifications on devices already set up; turn them on again in the admin.');
    $this->line('VAPID_PUBLIC_KEY='.$encode("\x04".$pad($key['x']).$pad($key['y'])));
    $this->line('VAPID_PRIVATE_KEY='.$encode($pad($key['d'])));
})->purpose('Create the keys for phone notifications');
