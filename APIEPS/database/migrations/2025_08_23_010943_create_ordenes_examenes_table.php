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
        Schema::create('ordenes_examenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_medica_id')->constrained('consultas_medicas');
            $table->foreignId('examen_medico_id')->constrained('examenes_Medico');
            $table->foreignId('laboratorio_id')->constrained('laboratorios');
            $table->date('fecha_orden');
            $table->enum('estado',["pendiente","realizado","entregado"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_examenes');
    }
};
