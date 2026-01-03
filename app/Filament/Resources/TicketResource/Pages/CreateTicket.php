<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Equipment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        // Crear el equipo primero si se proporcionaron datos de equipo
        if (isset($data['equipment'])) {
            $equipment = Equipment::create($data['equipment']);
            $data['equipment_id'] = $equipment->id;
            unset($data['equipment']);
        }

        return parent::mutateFormDataBeforeCreate($data);
    }
    
    protected function afterCreate(): void
    {
        if (! empty($this->data['supportStaff'])) {
            $this->record
                ->supportStaff()
                ->sync($this->data['supportStaff']);
        }
    }
}
