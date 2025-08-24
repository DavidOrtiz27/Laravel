<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HorarioController extends Controller
{
    // Listar todos los Horario
    public function index()
    {
        $Horario = Horario::all();
        return response()->json($Horario);
    }

    // Crear nuevo horario
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medico_id' => 'required|integer|exists:Medico,id',
            'dia_semana' => 'required|string|max:20',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $horario = Horario::create($request->all());
        return response()->json($horario);
    }

    // Listar horario por ID
    public function show(string $id)
    {
        $horario = Horario::findOrFail($id);
        return response()->json($horario);
    }

    // Actualizar horario
    public function update(Request $request, string $id)
    {
        $horario = Horario::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'medico_id' => 'integer|exists:Medico,id',
            'dia_semana' => 'string|max:20',
            'hora_inicio' => 'date_format:H:i',
            'hora_fin' => 'date_format:H:i|after:hora_inicio'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $horario->update($request->all());
        return response()->json($horario);
    }

    // Eliminar horario
    public function destroy(string $id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();

        return response()->json(['message' => 'Horario eliminado']);
    }
}
