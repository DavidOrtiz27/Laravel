<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = 'laboratorios';
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'ciudad_id'
    ];

    // Relación con medicamentos
    public function medicamentos()
    {
        return $this->hasMany(Medicamentos::class, 'laboratorio_id');
    }

    // Relación con exámenes médicos
    public function examenesMedico()
    {
        return $this->hasMany(ExamenesMedico::class, 'laboratorio_id');
    }
}
