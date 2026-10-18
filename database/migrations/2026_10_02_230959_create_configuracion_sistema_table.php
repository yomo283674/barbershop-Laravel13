<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_sistema', function (Blueprint $table) {
            $table->integer('id_configuracion', true);
            $table->string('nombre_negocio')->nullable();
            $table->string('logo_url')->nullable();
            $table->time('horario_apertura')->nullable();
            $table->time('horario_cierre')->nullable();
            $table->integer('duracion_cita_min')->nullable();
            $table->integer('tiempo_cancelacion_min')->nullable()->default(10);
            $table->integer('tiempo_reprogramacion_min')->nullable()->default(10);
            $table->integer('tiempo_notificacion_min')->nullable()->default(2);
            $table->integer('id_administrador_actualizacion')->nullable();
            $table->timestamp('fecha_actualizacion')->nullable();

            $table->foreign('id_administrador_actualizacion')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};
