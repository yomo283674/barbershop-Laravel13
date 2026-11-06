<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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

    protected $appends = ['nueva_hora_12'];

    /**
     * Retorna la nueva hora propuesta en formato 12 horas AM/PM.
     */
    public function getNuevaHora12Attribute(): string
    {
        if (empty($this->nueva_hora)) {
            return '';
        }

        try {
            return Carbon::createFromFormat('H:i:s', strlen($this->nueva_hora) === 5 ? "{$this->nueva_hora}:00" : $this->nueva_hora)->format('h:i A');
        } catch (\Throwable $e) {
            return Carbon::parse($this->nueva_hora)->format('h:i A');
        }
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }
}
