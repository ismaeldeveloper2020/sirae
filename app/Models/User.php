<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\VerifyEmailNotification;
use App\Notifications\ResetPasswordNotification;

use Spatie\Permission\Traits\HasRoles;

use App\Models\Aspirantes\Archivos;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apaterno',
        'amaterno',
        'email',
        'password',
        'clave_elector',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'name',
    ];

    /**
     * Nombre compatible con Jetstream y las vistas heredadas.
     * La tabla users conserva nombre, apaterno y amaterno como columnas reales.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => trim(implode(' ', array_filter([
                $attributes['nombre'] ?? null,
                $attributes['apaterno'] ?? null,
                $attributes['amaterno'] ?? null,
            ]))),
            set: fn (?string $value) => ['nombre' => $value],
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class);
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function documentos()
    {
        return $this->hasMany(
            Archivos::class,
            'user_id',
            'id'
        );
    }

}
