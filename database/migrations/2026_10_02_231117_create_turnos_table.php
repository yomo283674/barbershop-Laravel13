<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->integer('id_turno', true);
            $table->integer('id_cliente');
            $table->integer('id_cita')->nullable()->unique();
            $table->date('fecha');
            $table->integer('posicion')->nullable();
            $table->enum('estado', ['EN_ESPERA', 'EN_ATENCION', 'FINALIZADO'])->nullable()->default('EN_ESPERA');
            $table->timestamp('fecha_actualizacion')->nullable();

            $table->foreign('id_cliente')->references('id_usuario')->on('usuarios');
            $table->foreign('id_cita')->references('id_cita')->on('citas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};
