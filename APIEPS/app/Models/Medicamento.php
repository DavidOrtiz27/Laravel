<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table = 'medicamentos';
    protected $fillable = [
        'laboratorio_id',
        'nombre',
        'descripcion',
        'presentacion',
        'stock',
        'precio'
    ];

    // Relación con laboratorio
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorios::class, 'laboratorio_id');
    }

    // Relación con recetas médicas
    public function recetasMedicas()
    {
        return $this->hasMany(RecetasMedicas::class, 'medicamento_id');
    }
}
