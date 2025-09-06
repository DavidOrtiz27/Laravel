<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HorarioController extends Controller
{
    /**
     * Obtiene una lista de todos los horarios.
     *
     * @group Horario
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "medico_id": 1,
     *       "dia_semana": "Lunes",
     *       "hora_inicio": "08:00",
     *       "hora_fin": "17:00"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $Horario = Horario::all();
        return response()->json($Horario);
    }

    /**
     * Crea un nuevo horario.
     *
     * @group Horario
     * @bodyParam medico_id integer required ID del médico. Example: 1
     * @bodyParam dia_semana string required Día de la semana. Example: Lunes
     * @bodyParam hora_inicio string required Hora de inicio en formato HH:mm. Example: 08:00
     * @bodyParam hora_fin string required Hora de fin en formato HH:mm. Example: 17:00
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "medico_id": 1,
     *   "dia_semana": "Lunes",
     *   "hora_inicio": "08:00",
     *   "hora_fin": "17:00"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
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

    /**
     * Obtiene un horario específico por su ID.
     *
     * @group Horario
     * @urlParam id string required ID del horario. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "medico_id": 1,
     *   "dia_semana": "Lunes",
     *   "hora_inicio": "08:00",
     *   "hora_fin": "17:00"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Horario no encontrado"
     * }
     */
    public function show(string $id)
    {
        $horario = Horario::findOrFail($id);
        return response()->json($horario);
    }

    /**
     * Actualiza un horario existente.
     *
     * @group Horario
     * @urlParam id string required ID del horario. Example: 1
     * @bodyParam medico_id integer opcional ID del médico. Example: 1
     * @bodyParam dia_semana string opcional Día de la semana. Example: Lunes
     * @bodyParam hora_inicio string opcional Hora de inicio en formato HH:mm. Example: 08:00
     * @bodyParam hora_fin string opcional Hora de fin en formato HH:mm. Example: 17:00
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "medico_id": 1,
     *   "dia_semana": "Lunes",
     *   "hora_inicio": "08:00",
     *   "hora_fin": "17:00"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Horario no encontrado"
     * }
     */
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

    /**
     * Elimina un horario existente.
     *
     * @group Horario
     * @urlParam id string required ID del horario. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Horario eliminado"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Horario no encontrado"
     * }
     */
    public function destroy(string $id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();

        return response()->json(['message' => 'Horario eliminado']);
    }
}
