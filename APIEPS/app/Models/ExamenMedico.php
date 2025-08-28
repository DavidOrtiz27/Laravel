<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamenMedico extends Model
{
    protected $table = 'examenes_Medico';
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo'
    ];

    // Relación con laboratorio
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'laboratorio_id');
    }

    // Relación con órdenes de examen
    public function ordenesExamenes()
    {
        return $this->hasMany(OrdenExamen::class, 'examen_medico_id');
    }
}
