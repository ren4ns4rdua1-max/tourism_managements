<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The booking instance.
     */
    public Booking $booking;

    /**
     * The action type (accepted or declined).
     */
    public string $action;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, string $action)
    {
        $this->booking = $booking;
        $this->action = $action;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->action === 'accepted' 
            ? 'Your Booking Has Been Confirmed!' 
            : 'Your Booking Has Been Declined';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmation',
        );
    }
}
