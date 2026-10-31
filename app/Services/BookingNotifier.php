<?php

namespace App\Services;

use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use App\Mail\BookingReceived;
use App\Models\Booking;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

/**
 * Tells the couple, Sagar (email, phone, Discord) and Sagar's Google Calendar about
 * bookings. A failed email, notification or calendar update is logged and never
 * stops the booking itself.
 */
class BookingNotifier
{
    public function __construct(private GoogleCalendar $calendar, private PushNotifier $push)
    {
    }

    public function booked(Booking $booking): void
    {
        $this->mail($booking->email, new BookingConfirmed($booking));
        $this->mail(config('booking.notify_email'), new BookingReceived($booking));
        $this->push->send(
            "New free call: {$booking->couple()}",
            $booking->when().' · '.$booking->language.' · '.($booking->partner_joining ? 'both joining' : 'one of them for now'),
            route('admin.bookings', absolute: false),
            $booking->ulid,
        );
        $this->discord('New free call booked', $booking, 0xB81F1F);
        $this->calendar->addBooking($booking);
    }

    public function cancelled(Booking $booking, bool $byClient): void
    {
        if ($byClient) {
            $this->mail(config('booking.notify_email'), new BookingCancelled($booking, byClient: true));
            $this->push->send("Cancelled: {$booking->couple()}", $booking->when().' · the couple cancelled', route('admin.bookings', absolute: false), $booking->ulid);
        } else {
            $this->mail($booking->email, new BookingCancelled($booking, byClient: false));
        }

        $this->discord($byClient ? 'Free call cancelled by the couple' : 'Free call cancelled by you', $booking, 0x6D625A);
        $this->calendar->removeBooking($booking);
    }

    private function mail(string $to, Mailable $mailable): void
    {
        try {
            Mail::to($to)->send($mailable);
        } catch (Throwable $e) {
            report($e);
        }
    }

    private function discord(string $title, Booking $booking, int $color): void
    {
        try {
            $this->postToDiscord($title, $booking, $color);
        } catch (Throwable $e) {
            report($e);
        }
    }

    /**
     * Post a booking to the Discord channel behind DISCORD_BOOKING_WEBHOOK.
     * Throws if Discord refuses it; does nothing when no webhook is set.
     */
    public function postToDiscord(string $title, Booking $booking, int $color): void
    {
        if (! $url = config('booking.discord_webhook')) {
            return;
        }

        $fields = [
            ['name' => 'When', 'value' => $booking->when(), 'inline' => false],
            ['name' => 'Who', 'value' => $booking->couple(), 'inline' => true],
            ['name' => 'Joining', 'value' => $booking->partner_joining ? 'Both of them' : 'One of them for now', 'inline' => true],
            ['name' => 'Language', 'value' => $booking->language, 'inline' => true],
            ['name' => 'WhatsApp', 'value' => "[{$booking->phone}]({$booking->whatsappUrl()})", 'inline' => true],
            ['name' => 'Email', 'value' => $booking->email, 'inline' => true],
        ];

        if ($booking->notes) {
            $fields[] = ['name' => 'What they\'d like you to know', 'value' => Str::limit($booking->notes, 1000), 'inline' => false];
        }

        Http::timeout(5)->post($url, [
            'username' => 'Sagar for Couples',
            // The first line is what shows in phone notifications
            'content' => "**{$title}:** {$booking->couple()}, {$booking->when()}",
            'embeds' => [[
                'title' => 'Open bookings',
                'url' => route('admin.bookings'),
                'color' => $color,
                'fields' => $fields,
                'timestamp' => now()->toIso8601String(),
                'footer' => ['text' => 'Sent from SagarKarmakar.com'],
            ]],
            // Names come from the booking form: never let them ping @everyone or anyone else
            'allowed_mentions' => ['parse' => []],
        ])->throw();
    }
}
