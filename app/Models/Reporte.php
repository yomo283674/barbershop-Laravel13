<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reporte extends Model
{
    protected $table = 'reportes';

    protected $primaryKey = 'id_reporte';

    const CREATED_AT = 'fecha_generacion';

    const UPDATED_AT = null;

    protected $fillable = ['id_generador', 'tipo_reporte', 'fecha_inicio', 'fecha_fin', 'datos'];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'datos' => 'array',
        ];
    }

    public function generador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_generador');
    }
}
