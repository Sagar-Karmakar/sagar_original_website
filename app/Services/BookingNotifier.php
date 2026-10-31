<?php

namespace App\Services;

use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use App\Mail\BookingReceived;
use App\Models\Booking;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Tells the couple and Sagar about bookings. A failed email or Discord post is
 * logged and never stops the booking itself.
 */
class BookingNotifier
{
    public function booked(Booking $booking): void
    {
        $this->mail($booking->email, new BookingConfirmed($booking));
        $this->mail(config('booking.notify_email'), new BookingReceived($booking));
        $this->discord('New free call booked', $booking, 0xB81F1F);
    }

    public function cancelled(Booking $booking, bool $byClient): void
    {
        $byClient
            ? $this->mail(config('booking.notify_email'), new BookingCancelled($booking, byClient: true))
            : $this->mail($booking->email, new BookingCancelled($booking, byClient: false));

        $this->discord($byClient ? 'Free call cancelled by the couple' : 'Free call cancelled by you', $booking, 0x6D625A);
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
        if (! $url = config('booking.discord_webhook')) {
            return;
        }

        try {
            Http::timeout(5)->post($url, [
                'embeds' => [[
                    'title' => $title,
                    'color' => $color,
                    'fields' => [
                        ['name' => 'When', 'value' => $booking->when(), 'inline' => false],
                        ['name' => 'Who', 'value' => $booking->couple(), 'inline' => true],
                        ['name' => 'Language', 'value' => $booking->language, 'inline' => true],
                        ['name' => 'WhatsApp', 'value' => $booking->whatsappUrl(), 'inline' => false],
                    ],
                    'timestamp' => now()->toIso8601String(),
                    'footer' => ['text' => 'Sent from SagarKarmakar.com'],
                ]],
            ])->throw();
        } catch (Throwable $e) {
            report($e);
        }
    }
}
