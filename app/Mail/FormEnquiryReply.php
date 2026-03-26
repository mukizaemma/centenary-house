<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormEnquiryReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $visitorName,
        public string $contextLabel,
        public string $originalMessage,
        public string $adminResponse,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: your enquiry — '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.form-enquiry-reply',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
