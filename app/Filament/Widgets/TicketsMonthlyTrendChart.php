<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\ChartWidget;

class TicketsMonthlyTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Tendencia de Tickets (Ultimos 6 Meses)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $labels = [];
        $values = [];

        foreach (range(5, 0) as $monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            $labels[] = $date->translatedFormat('M Y');
            $values[] = Ticket::query()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $labels[] = now()->translatedFormat('M Y');
        $values[] = Ticket::query()
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $values,
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => 'rgba(14, 165, 233, 0.15)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
