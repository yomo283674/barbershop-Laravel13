<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disponibilidad extends Model
{
    protected $table = 'disponibilidad';

    protected $primaryKey = 'id_disponibilidad';

    public $timestamps = false;

    protected $fillable = ['id_barbero', 'fecha', 'hora_inicio', 'hora_fin', 'disponible'];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'disponible' => 'boolean',
        ];
    }

    public function barbero(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_barbero');
    }
}
