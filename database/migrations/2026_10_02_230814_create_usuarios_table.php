<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id_usuario', true);
            $table->integer('id_rol');
            $table->string('nombre')->nullable();
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->string('password');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'SUSPENDIDO'])->default('ACTIVO');
            $table->timestamp('fecha_registro')->nullable()->useCurrent();
            $table->timestamp('ultimo_acceso')->nullable();
            $table->string('numero_identificacion')->nullable();
            $table->string('documento')->nullable();
            $table->string('especialidad')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('cargo')->nullable();
            $table->string('metodo_2fa')->nullable();
            $table->string('foto_perfil')->nullable();

            $table->foreign('id_rol')->references('id_rol')->on('roles');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
