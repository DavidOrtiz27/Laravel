<?php

namespace App\Http\Controllers;

use App\Models\OrdenExamen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdenExamenController extends Controller
{
    /**
     * Obtiene una lista de todas las órdenes de examen.
     *
     * @group Orden Examen
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "consulta_medica_id": 1,
     *       "examen_medico_id": 1,
     *       "fecha_solicitud": "2025-01-01",
     *       "resultado": "Resultado del examen"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $ordenes = OrdenExamen::all();
        return response()->json($ordenes);
    }

    /**
     * Crea una nueva orden de examen.
     *
     * @group Orden Examen
     * @bodyParam consulta_medica_id integer required ID de la consulta médica. Example: 1
     * @bodyParam examen_medico_id integer required ID del examen médico. Example: 1
     * @bodyParam fecha_solicitud date required Fecha de solicitud del examen. Example: 2025-01-01
     * @bodyParam resultado string opcional Resultado del examen. Example: Resultado del examen
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "consulta_medica_id": 1,
     *   "examen_medico_id": 1,
     *   "fecha_solicitud": "2025-01-01",
     *   "resultado": "Resultado del examen"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consulta_medica_id' => 'required|integer|exists:consultas_medicas,id',
            'examen_medico_id' => 'required|integer|exists:examenes_medicos,id',
            'fecha_solicitud' => 'required|date',
            'resultado' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $orden = OrdenExamen::create($request->all());
        return response()->json($orden);
    }

    /**
     * Obtiene una orden de examen específica por su ID.
     *
     * @group Orden Examen
     * @urlParam id string required ID de la orden de examen. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "consulta_medica_id": 1,
     *   "examen_medico_id": 1,
     *   "fecha_solicitud": "2025-01-01",
     *   "resultado": "Resultado del examen"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Orden de examen no encontrada"
     * }
     */
    public function show(string $id)
    {
        $orden = OrdenExamen::findOrFail($id);
        return response()->json($orden);
    }

    /**
     * Actualiza una orden de examen existente.
     *
     * @group Orden Examen
     * @urlParam id string required ID de la orden de examen. Example: 1
     * @bodyParam consulta_medica_id integer opcional ID de la consulta médica. Example: 1
     * @bodyParam examen_medico_id integer opcional ID del examen médico. Example: 1
     * @bodyParam fecha_solicitud date opcional Fecha de solicitud del examen. Example: 2025-01-01
     * @bodyParam resultado string opcional Resultado del examen. Example: Resultado del examen
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "consulta_medica_id": 1,
     *   "examen_medico_id": 1,
     *   "fecha_solicitud": "2025-01-01",
     *   "resultado": "Resultado del examen"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Orden de examen no encontrada"
     * }
     */
    public function update(Request $request, string $id)
    {
        $orden = OrdenExamen::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'consulta_medica_id' => 'integer|exists:consultas_medicas,id',
            'examen_medico_id' => 'integer|exists:examenes_medicos,id',
            'fecha_solicitud' => 'date',
            'resultado' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $orden->update($request->all());
        return response()->json($orden);
    }

    /**
     * Elimina una orden de examen existente.
     *
     * @group Orden Examen
     * @urlParam id string required ID de la orden de examen. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Orden de examen eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Orden de examen no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $orden = OrdenExamen::findOrFail($id);
        $orden->delete();

        return response()->json(['message' => 'Orden de examen eliminada']);
    }
}
