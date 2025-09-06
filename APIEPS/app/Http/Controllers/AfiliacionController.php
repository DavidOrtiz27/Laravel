<?php

namespace App\Http\Controllers;

use App\Models\Afiliacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AfiliacionController extends Controller
{
    /**
     * Grupo: Afiliacion
     * Obtiene una lista de todas las afiliaciones.
     *
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "paciente_id": 1,
     *       "aseguradora_id": 1,
     *       "fecha_inicio": "2025-01-01",
     *       "fecha_fin": "2025-12-31",
     *       "estado": "activo"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $afiliaciones = Afiliacion::all();
        return response()->json($afiliaciones);
    }

    /**
     * Grupo: Afiliacion
     * Crea una nueva afiliación.
     *
     * @bodyParam paciente_id integer required ID del paciente. Example: 1
     * @bodyParam aseguradora_id integer required ID de la aseguradora. Example: 1
     * @bodyParam fecha_inicio date required Fecha de inicio de la afiliación. Example: 2025-01-01
     * @bodyParam fecha_fin date opcional Fecha de fin de la afiliación. Example: 2025-12-31
     * @bodyParam estado string required Estado de la afiliación. Example: activo
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "aseguradora_id": 1,
     *   "fecha_inicio": "2025-01-01",
     *   "fecha_fin": "2025-12-31",
     *   "estado": "activo"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'aseguradora_id' => 'required|integer|exists:aseguradoras,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $afiliacion = Afiliacion::create($request->all());
        return response()->json($afiliacion);
    }

    /**
     * Grupo: Afiliacion
     * Obtiene una afiliación específica por su ID.
     *
     * @urlParam id string required ID de la afiliación. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "aseguradora_id": 1,
     *   "fecha_inicio": "2025-01-01",
     *   "fecha_fin": "2025-12-31",
     *   "estado": "activo"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Afiliación no encontrada"
     * }
     */
    public function show(string $id)
    {
        $afiliacion = Afiliacion::findOrFail($id);
        return response()->json($afiliacion);
    }

    /**
     * Grupo: Afiliacion
     * Actualiza una afiliación existente.
     *
     * @urlParam id string required ID de la afiliación. Example: 1
     * @bodyParam paciente_id integer opcional ID del paciente. Example: 1
     * @bodyParam aseguradora_id integer opcional ID de la aseguradora. Example: 1
     * @bodyParam fecha_inicio date opcional Fecha de inicio de la afiliación. Example: 2025-01-01
     * @bodyParam fecha_fin date opcional Fecha de fin de la afiliación. Example: 2025-12-31
     * @bodyParam estado string opcional Estado de la afiliación. Example: activo
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "aseguradora_id": 1,
     *   "fecha_inicio": "2025-01-01",
     *   "fecha_fin": "2025-12-31",
     *   "estado": "activo"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Afiliación no encontrada"
     * }
     */
    public function update(Request $request, string $id)
    {
        $afiliacion = Afiliacion::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'paciente_id' => 'integer|exists:pacientes,id',
            'aseguradora_id' => 'integer|exists:aseguradoras,id',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'nullable|date',
            'estado' => 'string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $afiliacion->update($request->all());
        return response()->json($afiliacion);
    }

    /**
     * Grupo: Afiliacion
     * Elimina una afiliación existente.
     *
     * @urlParam id string required ID de la afiliación. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Afiliación eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Afiliación no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $afiliacion = Afiliacion::findOrFail($id);
        $afiliacion->delete();

        return response()->json(['message' => 'Afiliación eliminada']);
    }
}
