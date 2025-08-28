<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $table = 'historias_clinicas';
    protected $fillable = [
        'paciente_id',
        'fecha_creacion',
        'observaciones'
    ];

    // Relación con paciente
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }

    // Relación con consultas médicas
    public function consultasMedicas()
    {
        return $this->hasMany(ConsultasMedicas::class, 'historia_clinica_id');
    }
}
