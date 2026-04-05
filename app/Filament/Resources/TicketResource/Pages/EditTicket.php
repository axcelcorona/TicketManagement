<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Mail\TicketClosedMail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected ?string $originalStatus = null;

     /**
     * Rellenar el formulario con datos que NO son columnas
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->originalStatus = $this->record->status;

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

        $this->record->load(['user', 'visitType', 'equipment', 'supportStaff']);

        if (($this->originalStatus !== 'closed') && ($this->record->status === 'closed')) {
            $recipient = $this->record->client_email ?: $this->record->user?->email;

            if (! $recipient) {
                Log::warning('TicketClosedMail: no hay destinatario para el ticket #' . $this->record->id);

                return;
            }

            $referenceNumber = 'INC-' . str_pad((string) $this->record->id, 6, '0', STR_PAD_LEFT);

            try {
                Mail::to($recipient)->send(
                    new TicketClosedMail(
                        $this->record,
                        $referenceNumber,
                    )
                );

                Log::info('TicketClosedMail enviado', [
                    'ticket_id' => $this->record->id,
                    'referencia' => $referenceNumber,
                    'destinatario' => $recipient,
                ]);
            } catch (\Throwable $e) {
                Log::error('TicketClosedMail ERROR al enviar', [
                    'ticket_id' => $this->record->id,
                    'destinatario' => $recipient,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
