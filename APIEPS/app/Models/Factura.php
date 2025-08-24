<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $fillable = [
        'paciente_id',
        'cita_id',
        'monto_total',
        'estado', // pendiente, pagada, anulada
        'fecha_emision',
    ];

    // Relación con paciente
    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }

    // Relación con afiliación
    public function afiliacion()
    {
        return $this->belongsTo(Afiliacion::class, 'afiliacion_id');
    }

    // Relación con pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'factura_id');
    }
}
