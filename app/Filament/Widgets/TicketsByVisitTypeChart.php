<?php

namespace App\Filament\Widgets;

use App\Models\VisitType;
use Filament\Widgets\ChartWidget;

class TicketsByVisitTypeChart extends ChartWidget
{
    protected static ?string $heading = 'Tickets por Tipo de Visita';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $rows = VisitType::query()
            ->withCount('tickets')
            ->orderByDesc('tickets_count')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $rows->pluck('tickets_count')->all(),
                    'backgroundColor' => '#6366f1',
                ],
            ],
            'labels' => $rows->pluck('name')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
