<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_servicio', function (Blueprint $table) {
            $table->integer('id_categoria', true);
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->nullable()->default('ACTIVO');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_servicio');
    }
};
