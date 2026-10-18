<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id_cita
 * @property int $id_cliente
 * @property int $id_barbero
 * @property int $id_servicio
 * @property Carbon|null $fecha
 * @property string $hora
 * @property string $estado
 * @property string|null $observacion
 * @property string|null $motivo_cancelacion
 * @property Turno|null $turno
 */
class Cita extends Model
{
    protected $table = 'citas';

    protected $primaryKey = 'id_cita';

    const CREATED_AT = 'fecha_creacion';

    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'id_cliente',
        'id_barbero',
        'id_servicio',
        'fecha',
        'hora',
        'estado',
        'observacion',
        'motivo_cancelacion',
    ];

    protected function casts(): array
    {
        return ['fecha' => 'date'];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_cliente');
    }

    public function barbero(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_barbero');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    public function turno(): HasOne
    {
        return $this->hasOne(Turno::class, 'id_cita');
    }

    public function reprogramaciones(): HasMany
    {
        return $this->hasMany(Reprogramacion::class, 'id_cita');
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class, 'id_cita');
    }
}
