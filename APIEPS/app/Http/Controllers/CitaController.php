<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    // Listar todas las Cita
    public function index()
    {
        $Cita = Cita::all();
        return response()->json($Cita);
    }

    // Crear nueva cita
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'medico_id' => 'required|integer|exists:medicos,id',
            'consultorio_id' => 'required|integer|exists:consultorios,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $cita = Cita::create($request->all());
        return response()->json($cita);
    }

    // Listar cita por ID
    public function show(string $id)
    {
        $cita = Cita::findOrFail($id);
        return response()->json($cita);
    }

    // Actualizar cita
    public function update(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'especialidad_id' => 'required|integer|exists:especialidades,id',
            'medico_id' => 'required|integer|exists:medicos,id',
            'consultorio_id' => 'required|integer|exists:consultorios,id',
            'fecha' => 'date',
            'hora' => '',
            'estado' => 'string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $cita->update($request->all());
        return response()->json($cita);
    }

    // Eliminar cita
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return response()->json(['message' => 'Cita eliminada']);
    }
}
