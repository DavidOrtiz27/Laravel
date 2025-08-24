<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable = [
        'factura_id',
        'metodo_pago', // efectivo, tarjeta, transferencia
        'monto',
        'fecha_pago'
    ];

    // Relación con factura
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }
}
