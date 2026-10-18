<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->integer('id_auditoria', true);
            $table->integer('id_usuario');
            $table->string('accion');
            $table->timestamp('fecha_hora')->nullable()->useCurrent();
            $table->string('resultado')->nullable();
            $table->string('entidad_afectada')->nullable();
            $table->text('detalle')->nullable();
            $table->text('observacion')->nullable();

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};
