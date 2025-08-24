<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';
    protected $fillable = ['nombre'];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'ciudad_id');
    }

    public function medicos()
    {
        return $this->hasMany(Medico::class, 'ciudad_id');
    }

    public function consultorios()
    {
        return $this->hasMany(Consultorio::class, 'ciudad_id');
    }
}
