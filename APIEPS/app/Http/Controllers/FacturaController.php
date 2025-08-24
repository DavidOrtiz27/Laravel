<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacturaController extends Controller
{
    // Listar todas las Factura
    public function index()
    {
        $Factura = Factura::all();
        return response()->json($Factura);
    }

    // Crear nueva factura
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'cita_id' => 'required|integer|exists:citas,id',
            'monto_total' => 'required',
            'fecha_emision' => 'required|date',
            'estado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $factura = Factura::create($request->all());
        return response()->json($factura);
    }

    // Listar factura por ID
    public function show(string $id)
    {
        $factura = Factura::findOrFail($id);
        return response()->json($factura);
    }

    // Actualizar factura
    public function update(Request $request, string $id)
    {
        $factura = Factura::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'paciente_id' => 'integer|exists:pacientes,id',
            'cita_id' => 'integer|exists:citas,id',
            'monto_total' => 'required',
            'fecha_emision' => 'date',
            'estado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $factura->update($request->all());
        return response()->json($factura);
    }

    // Eliminar factura
    public function destroy(string $id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();

        return response()->json(['message' => 'Factura eliminada']);
    }
}
