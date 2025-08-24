<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aseguradora extends Model
{
    protected $table = 'aseguradoras';
    protected $fillable = ['nombre','nit','direccion','telefono','email','ciudad_id'];

    public function afiliaciones()
    {
        return $this->hasMany(Afiliacion::class, 'aseguradora_id');
    }

    public function pacientes()
    {
        return $this->hasManyThrough(
            Paciente::class,
            Afiliacion::class,
            'aseguradora_id',
            'id',
            'id',
            'paciente_id'
        );
    }
}

