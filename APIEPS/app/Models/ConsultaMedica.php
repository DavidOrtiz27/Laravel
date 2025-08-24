<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaMedica extends Model
{
    protected $table = 'consultas_medicas';
    protected $fillable = [
        'cita_id',
        'motivo',
        'diagnostico',
        'tratamiento',
        'fecha_consulta',

    ];

    // Relación con paciente
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }

    // Relación con médico
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    // Relación con cita (opcional)
    public function cita()
    {
        return $this->belongsTo(Citas::class, 'cita_id');
    }

    // Relación con receta médica
    public function recetaMedica()
    {
        return $this->hasOne(RecetasMedicas::class, 'consulta_medica_id');
    }
}
