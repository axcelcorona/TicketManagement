<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\UserPasswordCreatedMail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $plainPassword = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->plainPassword = $data['password'];
        $data['password'] = Hash::make($data['password']);

        return $data;
    }

    protected function afterCreate(): void
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
                    ->title('Usuario creado, pero no fue posible enviar el correo con la contrasena.')
                    ->send();
            }
        }
    }
}
