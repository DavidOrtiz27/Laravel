<?php

namespace App\Http\Controllers;

use App\Models\OrdenExamen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdenExamenController extends Controller
{
    // Listar todas las órdenes de examen
    public function index()
    {
        $ordenes = OrdenExamen::all();
        return response()->json($ordenes);
    }

    // Crear nueva orden de examen
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consulta_medica_id' => 'required|integer|exists:consultas_medicas,id',
            'examen_medico_id' => 'required|integer|exists:examenes_Medico,id',
            'fecha_solicitud' => 'required|date',
            'resultado' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $orden = OrdenExamen::create($request->all());
        return response()->json($orden);
    }

    // Listar orden por ID
    public function show(string $id)
    {
        $orden = OrdenExamen::findOrFail($id);
        return response()->json($orden);
    }

    // Actualizar orden de examen
    public function update(Request $request, string $id)
    {
        $orden = OrdenExamen::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'consulta_medica_id' => 'integer|exists:consultas_medicas,id',
            'examen_medico_id' => 'integer|exists:examenes_Medico,id',
            'fecha_solicitud' => 'date',
            'resultado' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $orden->update($request->all());
        return response()->json($orden);
    }

    // Eliminar orden de examen
    public function destroy(string $id)
    {
        $orden = OrdenExamen::findOrFail($id);
        $orden->delete();

        return response()->json(['message' => 'Orden de examen eliminada']);
    }
}
