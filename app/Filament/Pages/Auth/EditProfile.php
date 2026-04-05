<?php

namespace App\Filament\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends BaseEditProfile
{
    protected static bool $isDiscovered = false;

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label('Nombre')
            ->disabled();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Correo')
            ->disabled();
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Nueva contrasena')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->rule(Password::default())
            ->required(fn (): bool => (bool) $this->getUser()->must_change_password)
            ->autocomplete('new-password')
            ->dehydrated(fn ($state): bool => filled($state))
            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
            ->live(debounce: 500)
            ->same('passwordConfirmation');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (filled($data['password'] ?? null)) {
            $data['must_change_password'] = false;
        } else {
            unset($data['password']);
        }

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Perfil actualizado correctamente.';
    }

    protected function getRedirectUrl(): ?string
    {
        return Filament::getUrl();
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        $action = parent::getCancelFormAction();

        return $action->visible(fn (): bool => ! $this->getUser()->must_change_password);
    }

    protected function afterSave(): void
    {
        if (! $this->getUser()->must_change_password) {
            Notification::make()
                ->success()
                ->title('La contrasena fue actualizada.')
                ->send();
        }
    }
}
