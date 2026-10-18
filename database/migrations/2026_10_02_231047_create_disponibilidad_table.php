<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disponibilidad', function (Blueprint $table) {
            $table->integer('id_disponibilidad', true);
            $table->integer('id_barbero');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('disponible')->nullable()->default(true);

            $table->foreign('id_barbero')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disponibilidad');
    }
};
