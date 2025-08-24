<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';
    protected $fillable = [
        'medico_id',
        'consultorio_id',
        'dia_semana',   // Ej: Lunes, Martes...
        'hora_inicio',
        'hora_fin'
    ];

    // Relación con médico
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    // Relación con consultorio
    public function consultorio()
    {
        return $this->belongsTo(Consultorios::class, 'consultorio_id');
    }
}
