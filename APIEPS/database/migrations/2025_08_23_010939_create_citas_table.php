<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->foreignId('especialidad_id')->constrained('especialidades');
            $table->foreignId('medico_id')->constrained('medicos');
            $table->foreignId('consultorio_id')->constrained('consultorios');
            $table->date('fecha');
            $table->time('hora');
            $table->enum('estado',["pendiente","confirmada","cancelada","atendida"])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
