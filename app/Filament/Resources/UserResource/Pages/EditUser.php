<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\UserPasswordCreatedMail;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $plainPassword = null;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (filled($data['password'] ?? null)) {
            $this->plainPassword = $data['password'];
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if (! $this->record->hasRole('super_admin') && ! $this->record->hasRole('panel_user')) {
            $this->record->assignRole('panel_user');
        }

        if (filled($this->plainPassword)) {
            try {
                Mail::to($this->record->email)->send(
                    new UserPasswordCreatedMail(
                        $this->record,
                        $this->plainPassword,
                        (bool) $this->record->must_change_password,
                    )
                );
            } catch (Throwable $exception) {
                Notification::make()
                    ->warning()
                    ->title('Se actualizo la contrasena, pero no fue posible enviar el correo.')
                    ->send();
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
