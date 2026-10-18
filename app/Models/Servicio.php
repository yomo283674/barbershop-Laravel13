<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $primaryKey = 'id_servicio';

    const CREATED_AT = 'fecha_creacion';

    const UPDATED_AT = null;

    protected $fillable = [
        'id_categoria', 'nombre', 'descripcion', 'precio',
        'duracion_min', 'estado', 'imagen', 'id_barbero',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function barbero(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_barbero');
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'id_servicio');
    }
}
