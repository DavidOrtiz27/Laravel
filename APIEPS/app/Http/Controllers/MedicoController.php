<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicoController extends Controller
{
    // Listar todos los médicos
    public function index()
    {
        $medico = Medico::all();
        return response()->json($medico);
    }

    // Crear nuevo médico
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'documento' => 'required|string|max:50|unique:medicos',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100|unique:medicos',
            'especialidad_id' => 'required|integer|exists:especialidades,id',
            'ciudad_id' => 'required|integer|exists:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $medico = Medico::create($request->all());
        return response()->json($medico);
    }

    // Listar médico por ID
    public function show(string $id)
    {
        $medico = Medico::findOrFail($id);
        return response()->json($medico);
    }

    // Actualizar médico
    public function update(Request $request, string $id)
    {
        $medico = Medico::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'documento' => 'string|max:50,',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'especialidad_id' => 'integer|exists:especialidades,id',
            'ciudad_id' => 'integer|exists:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $medico->update($request->all());
        return response()->json($medico);
    }

    // Eliminar médico
    public function destroy(string $id)
    {
        $medico = Medico::findOrFail($id);
        $medico->delete();

        return response()->json(['message' => 'Médico eliminado']);
    }
}
