<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{
    // Listar todos los Paciente
    public function index()
    {
        $Paciente = Paciente::all();
        return response()->json($Paciente);
    }

    // Crear nuevo paciente
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'documento' => 'required|string|max:50|unique:pacientes',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100|unique:pacientes',
            'ciudad_id' => 'required|integer|exists:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $paciente = Paciente::create($request->all());
        return response()->json($paciente);
    }

    // Listar paciente por ID
    public function show(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    // Actualizar paciente
    public function update(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string',
            'documento' => 'string|unique:pacientes,documento,' . $id, // <- aquí
            'telefono' => 'nullable|string',
            'email' => 'nullable|email|unique:pacientes,email,' . $id, // <- y aquí
            'ciudad_id' => 'integer|exists:ciudades,id'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $paciente->update($request->all());
        return response()->json($paciente);
    }

    // Eliminar paciente
    public function destroy(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return response()->json(['message' => 'Paciente eliminado']);
    }
}
