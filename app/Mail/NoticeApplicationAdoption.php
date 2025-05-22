<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoticeApplicationAdoption extends Mailable
{
    use Queueable, SerializesModels;

    public string $recipient_name;
    public string $subjectText;
    public string $title;
    public string $body_message;

    /**
     * Create a new message instance.
     */
    public function __construct(string $recipient_name, string $subjectText, string $title, string $body_message)
    {
        $this->recipient_name = $recipient_name;
        $this->subjectText = $subjectText;
        $this->title = $title;
        $this->body_message = $body_message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notice_application_adoption',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
