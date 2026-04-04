<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total = Ticket::query()->count();
        $open = Ticket::query()->where('status', 'open')->count();
        $closed = Ticket::query()->where('status', 'closed')->count();
        $thisMonth = Ticket::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            Stat::make('Total de Tickets', (string) $total)
                ->description('Incidencias registradas en total')
                ->icon('heroicon-o-ticket'),

            Stat::make('Tickets Abiertos', (string) $open)
                ->description('Pendientes de cierre')
                ->descriptionColor('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('Tickets Cerrados', (string) $closed)
                ->description('Incidencias resueltas')
                ->descriptionColor('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Tickets Este Mes', (string) $thisMonth)
                ->description('Creados durante el mes actual')
                ->icon('heroicon-o-calendar-days'),
        ];
    }
}
