<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    protected $table = 'consultorios';
    protected $fillable = [
        'ciudad_id',
        'nombre',
        'direccion',
        'telefono'
    ];

    // Relación con ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudades::class, 'ciudad_id');
    }

    // Relación con médicos
    public function Medico()
    {
        return $this->hasMany(Medico::class, 'consultorio_id');
    }

    // Relación con citas
    public function citas()
    {
        return $this->hasMany(Citas::class, 'consultorio_id');
    }
}
