<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

     /**
     * Rellenar el formulario con datos que NO son columnas
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Cargar personal de soporte desde la tabla pivote
        $data['supportStaff'] = $this->record
            ->supportStaff()
            ->pluck('support_staff_id')
            ->toArray();

        // Cargar datos del equipo
        if ($this->record->equipment) {
            $data['equipment'] = [
                'code'   => $this->record->equipment->code,
                'serial' => $this->record->equipment->serial,
                'brand'  => $this->record->equipment->brand,
                'model'  => $this->record->equipment->model,
            ];
        }

        return $data;
    }

    /**
     * Guardar relaciones al editar
     */
    protected function afterSave(): void
    {
        $this->record->supportStaff()->sync(   
            $this->data['supportStaff'] ?? []
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
