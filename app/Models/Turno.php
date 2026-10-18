<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turno extends Model
{
    protected $table = 'turnos';

    protected $primaryKey = 'id_turno';

    const CREATED_AT = null;

    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['id_cliente', 'id_cita', 'fecha', 'posicion', 'estado'];

    protected function casts(): array
    {
        return ['fecha' => 'date'];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_cliente');
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }
}
