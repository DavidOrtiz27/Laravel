<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaMedica extends Model
{
    protected $table = 'recetas_medicas';
    protected $fillable = [
        'consulta_medica_id',
        'medicamento_id',
        'dosis',
        'frecuencia',
        'duracion'
    ];

    // Relación con consulta médica
    public function consultaMedica()
    {
        return $this->belongsTo(ConsultaMedica::class, 'consulta_medica_id');
    }

    // Relación con medicamento
    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_id');
    }
}
