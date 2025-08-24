<?php

namespace App\Http\Controllers;

use App\Models\ConsultaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultaMedicaController extends Controller
{
    // Listar todas las consultas médicas
    public function index()
    {
        $consultas = ConsultaMedica::all();
        return response()->json($consultas);
    }

    // Crear nueva consulta médica
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cita_id' => 'nullable|integer|exists:citas,id',
            'motivo' => 'required|string|max:255',
            'diagnostico' => 'nullable|string|max:255',
            'tratamiento' => 'nullable|string|max:500',
            'fecha_consulta'=>'date|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $consulta = ConsultaMedica::create($request->all());
        return response()->json($consulta);
    }

    // Listar consulta médica por ID
    public function show(string $id)
    {
        $consulta = ConsultaMedica::findOrFail($id);
        return response()->json($consulta);
    }

    // Actualizar consulta médica
    public function update(Request $request, string $id)
    {
        $consulta = ConsultaMedica::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'cita_id' => 'nullable|integer|exists:citas,id',
            'motivo' => 'string|max:255',
            'diagnostico' => 'nullable|string|max:255',
            'tratamiento' => 'nullable|string|max:500',
            'fecha_consulta'=>'date|date_format:Y-m-d'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $consulta->update($request->all());
        return response()->json($consulta);
    }

    // Eliminar consulta médica
    public function destroy(string $id)
    {
        $consulta = ConsultaMedica::findOrFail($id);
        $consulta->delete();

        return response()->json(['message' => 'Consulta médica eliminada']);
    }
}
