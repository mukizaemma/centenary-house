<?php

namespace App\Mail;

use App\Models\RoomEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RoomEnquiryResponse extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public RoomEnquiry $enquiry,
    ) {}

    public function envelope(): Envelope
    {
        $roomTitle = $this->enquiry->room?->title;
        $subject = 'Response to your enquiry';

        if ($roomTitle) {
            $subject = 'Response to your enquiry about ' . $roomTitle;
        }

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.room-enquiry-response',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

