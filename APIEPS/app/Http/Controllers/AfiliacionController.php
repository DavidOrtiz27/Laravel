<?php

namespace App\Http\Controllers;

use App\Models\Afiliacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AfiliacionController extends Controller
{
    // Listar todas las afiliaciones
    public function index()
    {
        $afiliaciones = Afiliacion::all();
        return response()->json($afiliaciones);
    }

    // Crear nueva afiliación
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'aseguradora_id' => 'required|integer|exists:aseguradoras,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $afiliacion = Afiliacion::create($request->all());
        return response()->json($afiliacion);
    }

    // Listar afiliación por ID
    public function show(string $id)
    {
        $afiliacion = Afiliacion::findOrFail($id);
        return response()->json($afiliacion);
    }

    // Actualizar afiliación
    public function update(Request $request, string $id)
    {
        $afiliacion = Afiliacion::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'paciente_id' => 'integer|exists:pacientes,id',
            'aseguradora_id' => 'integer|exists:aseguradoras,id',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $afiliacion->update($request->all());
        return response()->json($afiliacion);
    }

    // Eliminar afiliación
    public function destroy(string $id)
    {
        $afiliacion = Afiliacion::findOrFail($id);
        $afiliacion->delete();

        return response()->json(['message' => 'Afiliación eliminada']);
    }
}
