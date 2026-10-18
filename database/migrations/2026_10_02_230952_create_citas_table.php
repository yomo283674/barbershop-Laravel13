<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->integer('id_cita', true);
            $table->integer('id_cliente');
            $table->integer('id_barbero');
            $table->integer('id_servicio');
            $table->date('fecha');
            $table->time('hora');
            $table->enum('estado', ['PENDIENTE', 'ACEPTADA', 'CANCELADA', 'REPROGRAMADA', 'COMPLETADA'])->nullable()->default('PENDIENTE');
            $table->timestamp('fecha_creacion')->nullable()->useCurrent();
            $table->timestamp('fecha_actualizacion')->nullable();
            $table->text('observacion')->nullable();
            $table->text('motivo_cancelacion')->nullable();

            $table->foreign('id_cliente')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_barbero')->references('id_usuario')->on('usuarios');
            $table->foreign('id_servicio')->references('id_servicio')->on('servicios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
