<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Configuracion extends Model
{
    protected $table = 'configuracion_sistema';

    protected $primaryKey = 'id_configuracion';

    const CREATED_AT = null;

    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'nombre_negocio', 'logo_url', 'horario_apertura', 'horario_cierre',
        'duracion_cita_min', 'tiempo_cancelacion_min', 'tiempo_reprogramacion_min',
        'tiempo_notificacion_min', 'id_administrador_actualizacion',
    ];

    protected $appends = [
        'horario_apertura_12',
        'horario_cierre_12',
    ];

    /**
     * Retorna el horario de apertura en formato 12 horas AM/PM (ej: 08:00 AM).
     */
    public function getHorarioApertura12Attribute(): string
    {
        if (empty($this->horario_apertura)) {
            return '';
        }

        try {
            return Carbon::createFromFormat('H:i:s', strlen($this->horario_apertura) === 5 ? "{$this->horario_apertura}:00" : $this->horario_apertura)->format('h:i A');
        } catch (\Throwable $e) {
            return Carbon::parse($this->horario_apertura)->format('h:i A');
        }
    }

    /**
     * Retorna el horario de cierre en formato 12 horas AM/PM (ej: 08:00 PM).
     */
    public function getHorarioCierre12Attribute(): string
    {
        if (empty($this->horario_cierre)) {
            return '';
        }

        try {
            return Carbon::createFromFormat('H:i:s', strlen($this->horario_cierre) === 5 ? "{$this->horario_cierre}:00" : $this->horario_cierre)->format('h:i A');
        } catch (\Throwable $e) {
            return Carbon::parse($this->horario_cierre)->format('h:i A');
        }
    }

    public function administrador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_administrador_actualizacion');
    }
}
