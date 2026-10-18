<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->integer('id_notificacion', true);
            $table->integer('id_cita')->nullable();
            $table->integer('id_usuario_destino');
            $table->enum('tipo', ['CONFIRMACION', 'CANCELACION', 'REPROGRAMACION', 'RECORDATORIO', 'OTRO']);
            $table->string('asunto')->nullable();
            $table->text('mensaje')->nullable();
            $table->string('medio')->nullable()->default('CORREO');
            $table->enum('estado', ['ENVIADA', 'FALLIDA', 'PENDIENTE'])->nullable()->default('PENDIENTE');
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_lectura')->nullable();

            $table->foreign('id_cita')->references('id_cita')->on('citas');
            $table->foreign('id_usuario_destino')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
