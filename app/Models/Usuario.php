<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROL_ADMIN = 1;

    public const ROL_BARBERO = 2;

    public const ROL_CLIENTE = 3;

    public const ESTADO_ACTIVO = 'ACTIVO';

    public const ESTADO_INACTIVO = 'INACTIVO';

    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    public const CREATED_AT = 'fecha_registro';

    public const UPDATED_AT = null;

    protected $fillable = [
        'id_rol',
        'nombre',
        'email',
        'telefono',
        'password',
        'estado',
        'numero_identificacion',
        'documento',
        'especialidad',
        'fecha_ingreso',
        'cargo',
        'metodo_2fa',
        'foto_perfil',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'ultimo_acceso' => 'datetime',
            'fecha_ingreso' => 'date',
        ];
    }

    public function esAdmin(): bool
    {
        return (int) $this->id_rol === self::ROL_ADMIN;
    }

    public function esBarbero(): bool
    {
        return (int) $this->id_rol === self::ROL_BARBERO;
    }

    public function esCliente(): bool
    {
        return (int) $this->id_rol === self::ROL_CLIENTE;
    }

    public function scopeActivos(Builder $query): Builder
    {
        return $query->whereIn('estado', ['ACTIVO', 'activo']);
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function citasComoCliente(): HasMany
    {
        return $this->hasMany(Cita::class, 'id_cliente');
    }

    public function citasComoBarbero(): HasMany
    {
        return $this->hasMany(Cita::class, 'id_barbero');
    }

    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class, 'id_barbero');
    }

    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'id_barbero');
    }

    public function turnos(): HasMany
    {
        return $this->hasMany(Turno::class, 'id_cliente');
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class, 'id_usuario_destino');
    }

    public function reportes(): HasMany
    {
        return $this->hasMany(Reporte::class, 'id_generador');
    }

    public function auditorias(): HasMany
    {
        return $this->hasMany(Auditoria::class, 'id_usuario');
    }
}
