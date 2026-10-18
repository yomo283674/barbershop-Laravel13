<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias_servicio';

    protected $primaryKey = 'id_categoria';

    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion', 'estado'];

    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class, 'id_categoria');
    }
}
