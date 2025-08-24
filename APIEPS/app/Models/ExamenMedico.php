<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamenMedico extends Model
{
    protected $table = 'examenes_Medico';
    protected $fillable = [
        'laboratorio_id',
        'nombre',
        'descripcion',
        'precio'
    ];

    // Relación con laboratorio
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorios::class, 'laboratorio_id');
    }

    // Relación con órdenes de examen
    public function ordenesExamenes()
    {
        return $this->hasMany(OrdenesExamenes::class, 'examen_medico_id');
    }
}
