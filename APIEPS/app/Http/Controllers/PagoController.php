<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagoController extends Controller
{
    // Listar todos los Pago
    public function index()
    {
        $Pago = Pago::all();
        return response()->json($Pago);
    }

    // Crear nuevo pago
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'factura_id' => 'required|integer|exists:facturas,id',
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $pago = Pago::create($request->all());
        return response()->json($pago);
    }

    // Listar pago por ID
    public function show(string $id)
    {
        $pago = Pago::findOrFail($id);
        return response()->json($pago);
    }

    // Actualizar pago
    public function update(Request $request, string $id)
    {
        $pago = Pago::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'factura_id' => 'integer|exists:facturas,id',
            'fecha_pago' => 'date',
            'monto' => 'numeric|min:0',
            'metodo_pago' => 'string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $pago->update($request->all());
        return response()->json($pago);
    }

    // Eliminar pago
    public function destroy(string $id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return response()->json(['message' => 'Pago eliminado']);
    }
}
