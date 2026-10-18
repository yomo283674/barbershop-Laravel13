<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->integer('id_servicio', true);
            $table->integer('id_categoria')->nullable();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 0)->nullable();
            $table->integer('duracion_min')->nullable();
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'ELIMINADO'])->nullable()->default('ACTIVO');
            $table->timestamp('fecha_creacion')->nullable()->useCurrent();
            $table->string('imagen')->nullable();
            $table->integer('id_barbero')->nullable();

            $table->foreign('id_categoria')->references('id_categoria')->on('categorias_servicio');
            $table->foreign('id_barbero')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
