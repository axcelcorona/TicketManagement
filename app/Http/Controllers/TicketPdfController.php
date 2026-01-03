<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketPdfController extends Controller
{
    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'equipment', 'visitType', 'supportStaff']);

        return Pdf::loadView('pdfs.ticket', compact('ticket'))
            ->setPaper('A4')
            ->download("ticket-{$ticket->id}.pdf");
    }
}
