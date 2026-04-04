<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Mail\TicketCreatedMail;
use App\Models\Equipment;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $recipient = $this->record->client_email ?: Auth::user()?->email;

        if (! $recipient) {
            Log::warning('TicketCreatedMail: no hay destinatario para el ticket #' . $this->record->id);
            return;
        }

        $referenceNumber = 'INC-' . str_pad((string) $this->record->id, 6, '0', STR_PAD_LEFT);

        try {
            Mail::to($recipient)->send(
                new TicketCreatedMail(
                    $this->record->load(['visitType', 'equipment', 'supportStaff']),
                    $referenceNumber
                )
            );

            Log::info('TicketCreatedMail enviado', [
                'ticket_id'  => $this->record->id,
                'referencia' => $referenceNumber,
                'destinatario' => $recipient,
            ]);
        } catch (\Throwable $e) {
            Log::error('TicketCreatedMail ERROR al enviar', [
                'ticket_id' => $this->record->id,
                'destinatario' => $recipient,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
