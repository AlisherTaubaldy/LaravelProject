<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $book = [];
    public $book_rent = [];

    /**
     * Create a new message instance.
     */
    public function __construct($book, $book_rent)
    {
        $this->book = $book;
        $this->book_rent = $book_rent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rent Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.rentment',
            with: ['book' => $this->book,
                'book_rent' => $this->book_rent],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
