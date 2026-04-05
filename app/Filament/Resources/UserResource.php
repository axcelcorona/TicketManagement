<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Administracion';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del usuario')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Correo')
                            ->email()
                            ->required()
                            ->rule('email:rfc')
                            ->validationMessages([
                                'email' => 'Debes ingresar un correo valido.',
                            ])
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefono')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label('Contrasena')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->minLength(8)
                            ->same('passwordConfirmation'),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->label('Confirmar contrasena')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(false),
                        Forms\Components\Placeholder::make('password_actions')
                            ->label('Acciones de contrasena')
                            ->content('Puedes generar una contrasena segura automaticamente y enviarla al correo del usuario.')
                            ->columnSpanFull(),
                        Forms\Components\Actions::make([
                            Action::make('generatePassword')
                                ->label('Generar password aleatorio')
                                ->icon('heroicon-m-key')
                                ->action(function (Forms\Set $set): void {
                                    $password = Str::password(12, symbols: true);

                                    $set('password', $password);
                                    $set('passwordConfirmation', $password);
                                }),
                        ])
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_support_staff')
                            ->label('Mostrar en personal tecnico')
                            ->helperText('Si lo activas, este usuario aparecera en el listado de personal tecnico.'),
                        Forms\Components\Toggle::make('must_change_password')
                            ->label('Exigir cambio de password al ingresar')
                            ->default(true)
                            ->helperText('Si esta activo, al iniciar sesion el usuario sera enviado al perfil para cambiar su contrasena.'),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Acceso')
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->label('Roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->options(fn () => Role::query()->orderBy('name')->pluck('name', 'id')->all())
                            ->helperText('Usa super_admin para acceso total. panel_user permite entrar al panel.'),
                        Forms\Components\CheckboxList::make('permissions')
                            ->label('Permisos directos')
                            ->relationship('permissions', 'name')
                            ->columns(2)
                            ->options(fn () => Permission::query()
                                ->where(function ($query): void {
                                    $query->where('name', 'like', '%_ticket')
                                        ->orWhere('name', 'like', '%_user');
                                })
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all()
                            )
                            ->helperText('Aqui puedes permitir crear, editar, borrar tickets y administrar usuarios.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_support_staff')
                    ->label('Tecnico')
                    ->boolean(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge(),
                Tables\Columns\TextColumn::make('permissions.name')
                    ->label('Permisos')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
