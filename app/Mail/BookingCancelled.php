<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Sent to Sagar when the couple cancels, or to the couple when Sagar cancels.
 */
class BookingCancelled extends Mailable
{
    public function __construct(public Booking $booking, public bool $byClient)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->byClient
            ? "Cancelled: {$this->booking->couple()}, {$this->booking->when()}"
            : 'Your free call with Sagar is cancelled');
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.booking.cancelled');
    }
}
