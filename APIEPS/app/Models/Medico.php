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
        return $this->belongsTo(Especialidades::class, 'especialidad_id');
    }

    // Relación con ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudades::class, 'ciudad_id');
    }

    // Relación con horarios
    public function horarios()
    {
        return $this->hasMany(Horarios::class, 'medico_id');
    }

    // Relación con citas
    public function citas()
    {
        return $this->hasMany(Citas::class, 'medico_id');
    }

    // Relación con consultas médicas
    public function consultasMedicas()
    {
        return $this->hasMany(ConsultasMedicas::class, 'medico_id');
    }
}
