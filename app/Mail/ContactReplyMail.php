<?php

namespace App\Mail;

use App\Modules\Contact\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $contactMessage, $replyMessage)
    {
        $this->contactMessage = $contactMessage;
        $this->replyMessage = $replyMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: ' . $this->contactMessage->subject,
            replyTo: [config('mail.from.address')],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-reply',
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

    /**
     * Get the message headers.
     */
    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-Priority' => '3',
                'X-Mailer' => 'PHP/' . phpversion(),
            ],
        );
    }
}
