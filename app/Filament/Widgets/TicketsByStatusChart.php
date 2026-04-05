<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\ChartWidget;

class TicketsByStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Tickets por Estado';

    protected static ?int $sort = 2;

    protected function getTicketQuery(): Builder
    {
        return Ticket::query()->visibleTo(auth()->user());
    }

    protected function getData(): array
    {
        $open = $this->getTicketQuery()->where('status', 'open')->count();
        $closed = $this->getTicketQuery()->where('status', 'closed')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => [$open, $closed],
                    'backgroundColor' => ['#f59e0b', '#10b981'],
                ],
            ],
            'labels' => ['Abiertos', 'Cerrados'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
