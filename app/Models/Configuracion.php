<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function administrador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_administrador_actualizacion');
    }
}
