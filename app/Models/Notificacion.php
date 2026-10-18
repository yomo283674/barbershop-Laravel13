<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $primaryKey = 'id_notificacion';

    public $timestamps = false;

    protected $fillable = [
        'id_cita', 'id_usuario_destino', 'tipo', 'asunto', 'mensaje',
        'medio', 'estado', 'fecha_envio', 'fecha_lectura',
    ];

    protected function casts(): array
    {
        return [
            'fecha_envio' => 'datetime',
            'fecha_lectura' => 'datetime',
        ];
    }

    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }

    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_destino');
    }
}
