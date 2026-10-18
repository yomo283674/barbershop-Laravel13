<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auditoria extends Model
{
    protected $table = 'auditoria';

    protected $primaryKey = 'id_auditoria';

    const CREATED_AT = 'fecha_hora';

    const UPDATED_AT = null;

    protected $fillable = [
        'id_usuario', 'accion', 'resultado', 'entidad_afectada', 'detalle', 'observacion',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
