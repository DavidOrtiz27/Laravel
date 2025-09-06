<?php

namespace App\Http\Controllers;

use App\Models\ConsultaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultaMedicaController extends Controller
{
    /**
     * Obtiene una lista de todas las consultas médicas.
     *
     * @group Consulta Medica
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "cita_id": 1,
     *       "motivo": "Dolor de cabeza",
     *       "diagnostico": "Migraña",
     *       "tratamiento": "Medicamento para migraña",
     *       "fecha_consulta": "2025-09-05"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $consultas = ConsultaMedica::all();
        return response()->json($consultas);
    }

    /**
     * Crea una nueva consulta médica.
     *
     * @group Consulta Medica
     * @bodyParam cita_id integer opcional ID de la cita. Example: 1
     * @bodyParam motivo string required Motivo de la consulta. Example: Dolor de cabeza
     * @bodyParam diagnostico string opcional Diagnóstico de la consulta. Example: Migraña
     * @bodyParam tratamiento string opcional Tratamiento prescrito. Example: Medicamento para migraña
     * @bodyParam fecha_consulta date required Fecha de la consulta. Example: 2025-09-05
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "cita_id": 1,
     *   "motivo": "Dolor de cabeza",
     *   "diagnostico": "Migraña",
     *   "tratamiento": "Medicamento para migraña",
     *   "fecha_consulta": "2025-09-05"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
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

    /**
     * Obtiene una consulta médica específica por su ID.
     *
     * @group Consulta Medica
     * @urlParam id string required ID de la consulta médica. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "cita_id": 1,
     *   "motivo": "Dolor de cabeza",
     *   "diagnostico": "Migraña",
     *   "tratamiento": "Medicamento para migraña",
     *   "fecha_consulta": "2025-09-05"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Consulta médica no encontrada"
     * }
     */
    public function show(string $id)
    {
        $consulta = ConsultaMedica::findOrFail($id);
        return response()->json($consulta);
    }

    /**
     * Actualiza una consulta médica existente.
     *
     * @group Consulta Medica
     * @urlParam id string required ID de la consulta médica. Example: 1
     * @bodyParam cita_id integer opcional ID de la cita. Example: 1
     * @bodyParam motivo string opcional Motivo de la consulta. Example: Dolor de cabeza
     * @bodyParam diagnostico string opcional Diagnóstico de la consulta. Example: Migraña
     * @bodyParam tratamiento string opcional Tratamiento prescrito. Example: Medicamento para migraña
     * @bodyParam fecha_consulta date opcional Fecha de la consulta. Example: 2025-09-05
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "cita_id": 1,
     *   "motivo": "Dolor de cabeza",
     *   "diagnostico": "Migraña",
     *   "tratamiento": "Medicamento para migraña",
     *   "fecha_consulta": "2025-09-05"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Consulta médica no encontrada"
     * }
     */
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

    /**
     * Elimina una consulta médica existente.
     *
     * @group Consulta Medica
     * @urlParam id string required ID de la consulta médica. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Consulta médica eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Consulta médica no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $consulta = ConsultaMedica::findOrFail($id);
        $consulta->delete();

        return response()->json(['message' => 'Consulta médica eliminada']);
    }
}
