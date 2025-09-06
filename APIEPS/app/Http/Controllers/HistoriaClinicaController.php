<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoriaClinicaController extends Controller
{
    /**
     * Obtiene una lista de todas las historias clínicas.
     *
     * @group Historia Clinica
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "paciente_id": 1,
     *       "antecedentes": "Historial de hipertensión",
     *       "alergias": "Penicilina",
     *       "observaciones": "Paciente estable"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $historias = HistoriaClinica::all();
        return response()->json($historias);
    }

    /**
     * Crea una nueva historia clínica.
     *
     * @group Historia Clinica
     * @bodyParam paciente_id integer required ID del paciente. Example: 1
     * @bodyParam antecedentes string opcional Antecedentes médicos del paciente. Example: Historial de hipertensión
     * @bodyParam alergias string opcional Alergias del paciente. Example: Penicilina
     * @bodyParam observaciones string opcional Observaciones generales. Example: Paciente estable
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "antecedentes": "Historial de hipertensión",
     *   "alergias": "Penicilina",
     *   "observaciones": "Paciente estable"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
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

    /**
     * Obtiene una historia clínica específica por su ID.
     *
     * @group Historia Clinica
     * @urlParam id string required ID de la historia clínica. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "antecedentes": "Historial de hipertensión",
     *   "alergias": "Penicilina",
     *   "observaciones": "Paciente estable"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Historia clínica no encontrada"
     * }
     */
    public function show(string $id)
    {
        $historia = HistoriaClinica::findOrFail($id);
        return response()->json($historia);
    }

    /**
     * Actualiza una historia clínica existente.
     *
     * @group Historia Clinica
     * @urlParam id string required ID de la historia clínica. Example: 1
     * @bodyParam paciente_id integer opcional ID del paciente. Example: 1
     * @bodyParam antecedentes string opcional Antecedentes médicos del paciente. Example: Historial de hipertensión
     * @bodyParam alergias string opcional Alergias del paciente. Example: Penicilina
     * @bodyParam observaciones string opcional Observaciones generales. Example: Paciente estable
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "antecedentes": "Historial de hipertensión",
     *   "alergias": "Penicilina",
     *   "observaciones": "Paciente estable"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Historia clínica no encontrada"
     * }
     */
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

    /**
     * Elimina una historia clínica existente.
     *
     * @group Historia Clinica
     * @urlParam id string required ID de la historia clínica. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Historia clínica eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Historia clínica no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $historia = HistoriaClinica::findOrFail($id);
        $historia->delete();

        return response()->json(['message' => 'Historia clínica eliminada']);
    }
}
