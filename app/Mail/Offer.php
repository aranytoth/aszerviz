<?php

namespace App\Mail;

use App\Models\Worksheet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class Offer extends Mailable
{
    use Queueable, SerializesModels;

    public Worksheet $worksheet;
    /**
     * Create a new message instance.
     */
    public function __construct(Worksheet $worksheet)
    {
        $this->worksheet = $worksheet;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->worksheet->garage->company->company_name.' ajánlat',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.offer',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(Storage::disk('public')->path('pdf/'.$this->worksheet->worksheet_id.'.pdf'))
            ->as('ajanlat.pdf')
            ->withMime('application/pdf'),
        ];
    }
}
