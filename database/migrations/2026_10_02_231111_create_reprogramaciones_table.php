<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reprogramaciones', function (Blueprint $table) {
            $table->integer('id_reprogramacion', true);
            $table->integer('id_cita');
            $table->date('nueva_fecha');
            $table->time('nueva_hora');
            $table->enum('estado', ['PENDIENTE', 'CONFIRMADA', 'CANCELADA', 'EXPIRADA'])->nullable()->default('PENDIENTE');
            $table->timestamp('fecha_solicitud')->nullable()->useCurrent();
            $table->timestamp('fecha_limite_respuesta')->nullable();

            $table->foreign('id_cita')->references('id_cita')->on('citas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reprogramaciones');
    }
};
