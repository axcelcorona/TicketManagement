<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasPanelShield;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_support_staff',
        'must_change_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_support_staff' => 'boolean',
            'must_change_password' => 'boolean',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function (self $user): void {
            $user->syncSupportStaffProfile();
        });

        static::deleted(function (self $user): void {
            $user->supportStaffProfile()?->delete();
        });
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function supportStaffProfile(): HasOne
    {
        return $this->hasOne(SupportStaff::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['super_admin', 'panel_user'])
            || $this->hasAnyPermission([
                'view_any_ticket',
                'view_ticket',
                'create_ticket',
                'update_ticket',
                'delete_ticket',
                'view_any_user',
                'view_user',
                'create_user',
                'update_user',
                'delete_user',
            ]);
    }

    public function syncSupportStaffProfile(): void
    {
        if (! $this->is_support_staff) {
            $this->supportStaffProfile()?->delete();

            return;
        }

        $supportStaff = SupportStaff::query()
            ->where(function ($query): void {
                $query->where('user_id', $this->id);

                if (filled($this->email)) {
                    $query->orWhere('email', $this->email);
                }

                if (filled($this->phone)) {
                    $query->orWhere('phone', $this->phone);
                }
            })
            ->first();

        if ($supportStaff) {
            $supportStaff->update([
                'user_id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);

            return;
        }

        $this->supportStaffProfile()->create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
    }
}
