<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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

    protected $appends = [
        'hora_inicio_12',
        'hora_fin_12',
        'franja_12',
    ];

    /**
     * Retorna la hora de inicio en formato 12 horas AM/PM.
     */
    public function getHoraInicio12Attribute(): string
    {
        if (empty($this->hora_inicio)) {
            return '';
        }

        try {
            return Carbon::createFromFormat('H:i:s', strlen($this->hora_inicio) === 5 ? "{$this->hora_inicio}:00" : $this->hora_inicio)->format('h:i A');
        } catch (\Throwable $e) {
            return Carbon::parse($this->hora_inicio)->format('h:i A');
        }
    }

    /**
     * Retorna la hora de finalización en formato 12 horas AM/PM.
     */
    public function getHoraFin12Attribute(): string
    {
        if (empty($this->hora_fin)) {
            return '';
        }

        try {
            return Carbon::createFromFormat('H:i:s', strlen($this->hora_fin) === 5 ? "{$this->hora_fin}:00" : $this->hora_fin)->format('h:i A');
        } catch (\Throwable $e) {
            return Carbon::parse($this->hora_fin)->format('h:i A');
        }
    }

    /**
     * Retorna la franja completa en formato 12 horas (ej: 01:00 PM – 02:00 PM).
     */
    public function getFranja12Attribute(): string
    {
        return "{$this->hora_inicio_12} – {$this->hora_fin_12}";
    }

    public function barbero(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_barbero');
    }
}
