<?php

namespace App\Mail;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class TicketClosedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Ticket $ticket,
        public string $referenceNumber,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incidencia cerrada: ' . $this->referenceNumber,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tickets.closed',
            with: [
                'ticket' => $this->ticket,
                'referenceNumber' => $this->referenceNumber,
            ],
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.ticket', [
            'ticket' => $this->ticket,
        ]);

        $clientName = Str::slug($this->ticket->client_name ?: 'cliente', '_');
        $currentDate = now()->format('Y-m-d');
        $filename = "{$clientName}_{$this->ticket->id}_{$currentDate}.pdf";

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(
                fn (): string => $pdf->output(),
                $filename,
            )->withMime('application/pdf'),
        ];
    }
}
