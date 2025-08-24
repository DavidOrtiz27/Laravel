<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    protected $fillable = ['ciudad_id','nombre','documento','telefono','email','direccion'];

    public function afiliaciones()
    {
        return $this->hasMany(Afiliacion::class, 'paciente_id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }

    public function historiaClinica()
    {
        return $this->hasOne(HistoriaClinica::class, 'paciente_id');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'paciente_id');
    }

    public function consultasMedicas()
    {
        return $this->hasManyThrough(
            ConsultaMedica::class, // Modelo destino
            Cita::class,            // Modelo intermedio
            'paciente_id',          // FK en citas
            'cita_id',              // FK en consultas_medicas
            'id',                   // PK en pacientes
            'id'                    // PK en citas
        );
    }


}
