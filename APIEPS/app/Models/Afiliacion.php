<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Afiliacion extends Model
{
    protected $table = 'afiliaciones';
    protected $fillable = ['paciente_id','aseguradora_id','fecha_inicio','fecha_fin','estado'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function aseguradora()
    {
        return $this->belongsTo(Aseguradora::class, 'aseguradora_id');
    }
}

