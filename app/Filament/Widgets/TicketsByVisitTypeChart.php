<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\ChartWidget;

class TicketsByVisitTypeChart extends ChartWidget
{
    protected static ?string $heading = 'Tickets por Tipo de Visita';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $rows = Ticket::query()
            ->visibleTo(auth()->user())
            ->selectRaw('visit_type_id, COUNT(*) as total')
            ->with('visitType')
            ->groupBy('visit_type_id')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $rows->pluck('total')->all(),
                    'backgroundColor' => '#6366f1',
                ],
            ],
            'labels' => $rows->map(fn (Ticket $ticket): string => $ticket->visitType?->name ?? 'Sin tipo')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
