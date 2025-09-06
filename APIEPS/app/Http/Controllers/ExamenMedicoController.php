<?php

namespace App\Http\Controllers;

use App\Models\ExamenMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamenMedicoController extends Controller
{
    /**
     * Obtiene una lista de todos los exámenes médicos.
     *
     * @group Examen Medico
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "laboratorio_id": 1,
     *       "nombre": "Examen de sangre",
     *       "descripcion": "Análisis completo de sangre",
     *       "precio": 100.00
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $examenes = ExamenMedico::all();
        return response()->json($examenes);
    }

    /**
     * Crea un nuevo examen médico.
     *
     * @group Examen Medico
     * @bodyParam laboratorio_id integer required ID del laboratorio. Example: 1
     * @bodyParam nombre string required Nombre del examen médico. Example: Examen de sangre
     * @bodyParam descripcion string opcional Descripción del examen médico. Example: Análisis completo de sangre
     * @bodyParam precio numeric required Precio del examen médico. Example: 100.00
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "laboratorio_id": 1,
     *   "nombre": "Examen de sangre",
     *   "descripcion": "Análisis completo de sangre",
     *   "precio": 100.00
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
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

    /**
     * Obtiene un examen médico específico por su ID.
     *
     * @group Examen Medico
     * @urlParam id string required ID del examen médico. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "laboratorio_id": 1,
     *   "nombre": "Examen de sangre",
     *   "descripcion": "Análisis completo de sangre",
     *   "precio": 100.00
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Examen médico no encontrado"
     * }
     */
    public function show(string $id)
    {
        $examen = ExamenMedico::findOrFail($id);
        return response()->json($examen);
    }

    /**
     * Actualiza un examen médico existente.
     *
     * @group Examen Medico
     * @urlParam id string required ID del examen médico. Example: 1
     * @bodyParam laboratorio_id integer opcional ID del laboratorio. Example: 1
     * @bodyParam nombre string opcional Nombre del examen médico. Example: Examen de sangre
     * @bodyParam descripcion string opcional Descripción del examen médico. Example: Análisis completo de sangre
     * @bodyParam precio numeric opcional Precio del examen médico. Example: 100.00
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "laboratorio_id": 1,
     *   "nombre": "Examen de sangre",
     *   "descripcion": "Análisis completo de sangre",
     *   "precio": 100.00
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Examen médico no encontrado"
     * }
     */
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

    /**
     * Elimina un examen médico existente.
     *
     * @group Examen Medico
     * @urlParam id string required ID del examen médico. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Examen médico eliminado"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Examen médico no encontrado"
     * }
     */
    public function destroy(string $id)
    {
        $examen = ExamenMedico::findOrFail($id);
        $examen->delete();

        return response()->json(['message' => 'Examen médico eliminado']);
    }
}
