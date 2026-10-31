<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Sent to Sagar when a couple books.
 */
class BookingReceived extends Mailable
{
    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->booking->email, $this->booking->name)],
            subject: "New free call: {$this->booking->couple()}, {$this->booking->when()}",
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.booking.received');
    }
}
