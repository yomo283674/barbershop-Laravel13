<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reprogramacion extends Model
{
    protected $table = 'reprogramaciones';

    protected $primaryKey = 'id_reprogramacion';

    const CREATED_AT = 'fecha_solicitud';

    const UPDATED_AT = null;

    protected $fillable = [
        'id_cita', 'nueva_fecha', 'nueva_hora', 'estado', 'fecha_limite_respuesta',
    ];

    protected function casts(): array
    {
        return [
            'nueva_fecha' => 'date',
            'fecha_limite_respuesta' => 'datetime',
        ];
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }
}
