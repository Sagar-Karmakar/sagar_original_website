<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\URL;

/**
 * Sent to the couple, with the call attached as a calendar invite.
 */
class BookingConfirmed extends Mailable
{
    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        // Replies go to the inbox people write to (contact@), not the sending address
        return new Envelope(
            replyTo: [new Address(config('site.email'), 'Sagar Karmakar')],
            subject: 'Your free call with Sagar is booked',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.booking.confirmed',
            with: ['url' => URL::signedRoute('call.booked', $this->booking)],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->booking->toIcs(), 'free-call.ics')->withMime('text/calendar'),
        ];
    }
}
