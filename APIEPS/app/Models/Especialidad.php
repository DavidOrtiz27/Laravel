<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades';
    protected $fillable = [
        'nombre'
    ];

    // Relación con médicos
    public function medicos()
    {
        return $this->hasMany(Medico::class, 'especialidad_id');
    }

    // Relación con citas
    public function citas()
    {
        // 'especialidad_id' es la FK en citas
        return $this->hasMany(Cita::class, 'especialidad_id');
    }
}
