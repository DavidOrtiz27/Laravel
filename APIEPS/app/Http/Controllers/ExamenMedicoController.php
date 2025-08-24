<?php

namespace App\Http\Controllers;

use App\Models\ExamenMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamenMedicoController extends Controller
{
    // Listar todos los exámenes médicos
    public function index()
    {
        $examenes = ExamenMedico::all();
        return response()->json($examenes);
    }

    // Crear nuevo examen médico
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'laboratorio_id' => 'required|integer|exists:laboratorios,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $examen = ExamenMedico::create($request->all());
        return response()->json($examen);
    }

    // Listar examen médico por ID
    public function show(string $id)
    {
        $examen = ExamenMedico::findOrFail($id);
        return response()->json($examen);
    }

    // Actualizar examen médico
    public function update(Request $request, string $id)
    {
        $examen = ExamenMedico::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'laboratorio_id' => 'integer|exists:laboratorios,id',
            'nombre' => 'string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $examen->update($request->all());
        return response()->json($examen);
    }

    // Eliminar examen médico
    public function destroy(string $id)
    {
        $examen = ExamenMedico::findOrFail($id);
        $examen->delete();

        return response()->json(['message' => 'Examen médico eliminado']);
    }
}
