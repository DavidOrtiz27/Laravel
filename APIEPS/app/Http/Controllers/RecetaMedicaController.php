<?php

namespace App\Http\Controllers;

use App\Models\RecetaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecetaMedicaController extends Controller
{
    // Listar todas las recetas médicas
    public function index()
    {
        $recetas = RecetaMedica::all();
        return response()->json($recetas);
    }

    // Crear nueva receta médica
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consulta_medica_id' => 'required|integer|exists:consultas_medicas,id',
            'fecha' => 'required|date',
            'indicaciones' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $receta = RecetaMedica::create($request->all());
        return response()->json($receta);
    }

    // Listar receta médica por ID
    public function show(string $id)
    {
        $receta = RecetaMedica::findOrFail($id);
        return response()->json($receta);
    }

    // Actualizar receta médica
    public function update(Request $request, string $id)
    {
        $receta = RecetaMedica::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'consulta_medica_id' => 'integer|exists:consultas_medicas,id',
            'fecha' => 'date',
            'indicaciones' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $receta->update($request->all());
        return response()->json($receta);
    }

    // Eliminar receta médica
    public function destroy(string $id)
    {
        $receta = RecetaMedica::findOrFail($id);
        $receta->delete();

        return response()->json(['message' => 'Receta médica eliminada']);
    }
}
