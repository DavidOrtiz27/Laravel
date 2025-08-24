<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoriaClinicaController extends Controller
{
    // Listar todas las historias clínicas
    public function index()
    {
        $historias = HistoriaClinica::all();
        return response()->json($historias);
    }

    // Crear nueva historia clínica
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'antecedentes' => 'nullable|string|max:1000',
            'alergias' => 'nullable|string|max:500',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $historia = HistoriaClinica::create($request->all());
        return response()->json($historia);
    }

    // Listar historia clínica por ID
    public function show(string $id)
    {
        $historia = HistoriaClinica::findOrFail($id);
        return response()->json($historia);
    }

    // Actualizar historia clínica
    public function update(Request $request, string $id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'paciente_id' => 'integer|exists:pacientes,id',
            'antecedentes' => 'nullable|string|max:1000',
            'alergias' => 'nullable|string|max:500',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $historia->update($request->all());
        return response()->json($historia);
    }

    // Eliminar historia clínica
    public function destroy(string $id)
    {
        $historia = HistoriaClinica::findOrFail($id);
        $historia->delete();

        return response()->json(['message' => 'Historia clínica eliminada']);
    }
}
