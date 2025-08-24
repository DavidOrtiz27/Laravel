<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenExamen extends Model
{
    protected $table = 'ordenes_examenes';
    protected $fillable = [
        'consulta_medica_id',
        'examen_medico_id',
        'laboratorio_id',
        'fecha_orden',
        'estado' // pendiente, realizado, entregado
    ];

    // Relación con consulta médica
    public function consultaMedica()
    {
        return $this->belongsTo(ConsultasMedicas::class, 'consulta_medica_id');
    }

    // Relación con examen médico
    public function examenMedico()
    {
        return $this->belongsTo(ExamenesMedico::class, 'examen_medico_id');
    }

    // Relación con laboratorio
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorios::class, 'laboratorio_id');
    }
}
