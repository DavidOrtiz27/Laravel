<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';
    protected $fillable = [
        'especialidad_id',
        'ciudad_id',
        'nombre',
        'documento',
        'telefono',
        'email'
    ];

    // Relación con especialidad
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    // Relación con ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    // Relación con horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'medico_id');
    }

    // Relación con citas
    public function citas()
    {
        return $this->hasMany(Cita::class, 'medico_id');
    }

    // Relación con consultas médicas
    public function consultasMedicas()
    {
        return $this->hasMany(ConsultaMedica::class, 'medico_id');
    }
}
