<?php

namespace Modules\User\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Traits\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,
        HasFactory,
        HasRoles,
        HasProfilePhoto,
        Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $fillable = [
        'name',
        'gender',
        'email',
        'password',
        'birthdate',
        'phoneNumber',
        'timezone',
        'language',
        'last_login_ip',
        'last_login_at',
        'status',
        'address',
        'avatarURL',
        'level_id',
        'speciality_id',
        'phone_number_verified_at',
    ];

    public static function boot()
    {
        parent::boot();
        // Will fire everytime an User is created
        static::created(function (User $user) {
            $user->forceFill(['username' => Str::slug($user->name)])->save();
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_number_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'can_login' => 'boolean',
        'status' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsFile(function (string $mimeType): bool {
                return in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'], true);
            });
    }

    public function userRoles(): array
    {
        $roles = array();
        foreach ($this->roles as $role) {
            $roles[] = $role->name;
        }
        return $roles;
    }

    public function userPermissions(): array
    {
        $permissions = array();
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission->name;
            }
        }
        return $permissions;
    }
}
