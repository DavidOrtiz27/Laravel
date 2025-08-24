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
        Schema::create('recetas_medicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_medica_id')->constrained('consultas_medicas');
            $table->foreignId('medicamento_id')->constrained('medicamentos');
            $table->string('dosis');
            $table->string('frecuencia');
            $table->string('duracion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas_medicas');
    }
};
