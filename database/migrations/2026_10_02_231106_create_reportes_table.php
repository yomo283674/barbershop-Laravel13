<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->integer('id_reporte', true);
            $table->integer('id_generador');
            $table->string('tipo_reporte')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('datos')->nullable();
            $table->timestamp('fecha_generacion')->nullable()->useCurrent();

            $table->foreign('id_generador')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
