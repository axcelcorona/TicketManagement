<?php

namespace App\Filament\Widgets;

use App\Models\SupportStaff;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TicketsBySupportStaffTable extends BaseWidget
{
    protected static ?string $heading = 'Total de Tickets por Personal de Soporte';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SupportStaff::query()->withCount('tickets')
            )
            ->defaultSort('tickets_count', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tickets_count')
                    ->label('Tickets Atendidos')
                    ->badge()
                    ->sortable(),
            ]);
    }
}
