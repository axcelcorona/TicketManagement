<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Section::make('Informacion General')->schema([

                    Forms\Components\TextInput::make('client_name')
                        ->label('Nombre del Cliente')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('client_email')
                        ->email()
                        ->label('Correo del Cliente')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('owner_name')
                        ->label('Nombre del Usuario Responsable')
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('call_time')
                        ->label('Fecha y Hora de Llamada')
                        ->required(),
                    Forms\Components\DateTimePicker::make('start_time')->label('Fecha y Hora de Inicio'),
                    Forms\Components\DateTimePicker::make('end_time')->label('Fecha y Hora de Fin'),
                    Forms\Components\Select::make('status')
                        ->label('Estado')
                        ->options([
                            'open'   => 'Abierto',
                            'closed' => 'Cerrado',
                        ])
                        ->required()
                        ->rules(['required'])
                        ->default(fn ($record) => $record?->status ?? 'open')
                        ->hidden(fn ($livewire) => $livewire instanceof Pages\CreateTicket),
                    Forms\Components\TextInput::make('location')
                        ->label('Ubicación')
                        ->maxLength(255),
                
                ])->columns(2),

                Forms\Components\Section::make('Detalle del Equipo')->schema([
                    Forms\Components\TextInput::make('equipment.code')
                    ->required()
                    ->label('Código'),

                    Forms\Components\TextInput::make('equipment.serial')
                    ->required()
                    ->label('Serial'),

                    Forms\Components\TextInput::make('equipment.brand')
                    ->label('Marca'),
                    
                    Forms\Components\TextInput::make('equipment.model')
                    ->label('Modelo'),

                ])->columns(2),

                Forms\Components\Section::make()->label('Tipo de Visita')->schema([
                    Forms\Components\Select::make('visit_type_id')
                        ->relationship('visitType', 'name')
                        ->label('Tipo de Visita')
                        ->live()
                        ->required(),
                ])->columns(1),

               Forms\Components\Section::make('Personal de soporte')->schema([
                    Forms\Components\Select::make('supportStaff')
                    ->label('Personal de soporte')
                    ->multiple()
                    ->options(
                        \App\Models\SupportStaff::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->placeholder('Buscar y seleccionar especialistas')
                    ->helperText('Puedes seleccionar múltiples especialistas. Busca por nombre y agrega todos los que necesites.'),
                ])->columns(1),

                Forms\Components\Section::make('Descripcion del Problema y Solucion')->schema([

                    Forms\Components\Textarea::make('problem_description')
                        ->columnSpanFull()
                        ->label('Descripción del Problema')
                        ->required(),
                    Forms\Components\Textarea::make('solution_applied')
                        ->columnSpanFull()
                        ->label('Solución Aplicada'),
                    Forms\Components\Textarea::make('observations')
                        ->columnSpanFull()
                        ->label('Observaciones'),
                ])->columns(1),
                    // Forms\Components\Select::make('visit_type_id')
                    // ->relationship('visit_type', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('client_name')->searchable(), 
                Tables\Columns\TextColumn::make('visitType.name')->label('Visita')->badge(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                            'open'   => 'Abierto',
                            'closed' => 'Cerrado',
                        ]),
                
                Tables\Filters\SelectFilter::make('visit_type_id')
                    ->label('Tipo de Visita')
                    ->relationship('visitType', 'name'),
                
                // Tables\Filters\SelectFilter::make('client_name')
                //     ->label('Nombre del Cliente'),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('download_pdf')
                    ->label('Descargar PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Ticket $record) {

                        $pdf = Pdf::loadView('pdf.ticket', [
                            'ticket' => $record->load([
                                'visitType',
                                'supportStaff',
                            ]),
                        ]);

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            "ticket_{$record->id}.pdf"
                        );
                    }),
            ]);
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
