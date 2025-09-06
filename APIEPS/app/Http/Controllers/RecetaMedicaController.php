<?php

namespace App\Http\Controllers;

use App\Models\RecetaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecetaMedicaController extends Controller
{
    /**
     * Obtiene una lista de todas las recetas médicas.
     *
     * @group Receta Medica
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "consulta_medica_id": 1,
     *       "fecha": "2025-01-01",
     *       "indicaciones": "Tomar medicamento cada 8 horas"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $recetas = RecetaMedica::all();
        return response()->json($recetas);
    }

    /**
     * Crea una nueva receta médica.
     *
     * @group Receta Medica
     * @bodyParam consulta_medica_id integer required ID de la consulta médica. Example: 1
     * @bodyParam fecha date required Fecha de la receta. Example: 2025-01-01
     * @bodyParam indicaciones string opcional Indicaciones médicas. Example: Tomar medicamento cada 8 horas
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "consulta_medica_id": 1,
     *   "fecha": "2025-01-01",
     *   "indicaciones": "Tomar medicamento cada 8 horas"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consulta_medica_id' => 'required|integer|exists:consultas_medicas,id',
            'fecha' => 'required|date',
            'indicaciones' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $receta = RecetaMedica::create($request->all());
        return response()->json($receta);
    }

    /**
     * Obtiene una receta médica específica por su ID.
     *
     * @group Receta Medica
     * @urlParam id string required ID de la receta médica. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "consulta_medica_id": 1,
     *   "fecha": "2025-01-01",
     *   "indicaciones": "Tomar medicamento cada 8 horas"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Receta médica no encontrada"
     * }
     */
    public function show(string $id)
    {
        $receta = RecetaMedica::findOrFail($id);
        return response()->json($receta);
    }

    /**
     * Actualiza una receta médica existente.
     *
     * @group Receta Medica
     * @urlParam id string required ID de la receta médica. Example: 1
     * @bodyParam consulta_medica_id integer opcional ID de la consulta médica. Example: 1
     * @bodyParam fecha date opcional Fecha de la receta. Example: 2025-01-01
     * @bodyParam indicaciones string opcional Indicaciones médicas. Example: Tomar medicamento cada 8 horas
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "consulta_medica_id": 1,
     *   "fecha": "2025-01-01",
     *   "indicaciones": "Tomar medicamento cada 8 horas"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Receta médica no encontrada"
     * }
     */
    public function update(Request $request, string $id)
    {
        $receta = RecetaMedica::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'consulta_medica_id' => 'integer|exists:consultas_medicas,id',
            'fecha' => 'date',
            'indicaciones' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $receta->update($request->all());
        return response()->json($receta);
    }

    /**
     * Elimina una receta médica existente.
     *
     * @group Receta Medica
     * @urlParam id string required ID de la receta médica. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Receta médica eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Receta médica no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $receta = RecetaMedica::findOrFail($id);
        $receta->delete();

        return response()->json(['message' => 'Receta médica eliminada']);
    }
}
