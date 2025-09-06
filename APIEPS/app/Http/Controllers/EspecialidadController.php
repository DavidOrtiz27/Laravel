<?php

namespace App\Http\Controllers;


use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspecialidadController extends Controller
{
    /**
     * Obtiene una lista de todas las especialidades.
     *
     * @group Especialidad
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre": "Cardiología"
     *     }
     *   ]
     * }
     *
     * @unauthenticated
     */
    public function index()
    {
        $Especialidad = Especialidad::all();
        return response()->json($Especialidad);
    }

    /**
     * Crea una nueva especialidad.
     *
     * @group Especialidad
     * @bodyParam nombre string required Nombre de la especialidad. Example: Cardiología
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Cardiología"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $especialidad = Especialidad::create($request->all());
        return response()->json($especialidad);
    }

    /**
     * Obtiene una especialidad específica por su ID.
     *
     * @group Especialidad
     * @urlParam id string required ID de la especialidad. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Cardiología"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Especialidad no encontrada"
     * }
     *
     * @unauthenticated
     */
    public function show(string $id)
    {
        $especialidad = Especialidad::findOrFail($id);
        return response()->json($especialidad);
    }

    /**
     * Actualiza una especialidad existente.
     *
     * @group Especialidad
     * @urlParam id string required ID de la especialidad. Example: 1
     * @bodyParam nombre string required Nombre de la especialidad. Example: Cardiología
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Cardiología"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Especialidad no encontrada"
     * }
     */
    public function update(Request $request, string $id)
    {
        $especialidad = Especialidad::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $especialidad->update($request->all());
        return response()->json($especialidad);
    }

    /**
     * Elimina una especialidad existente.
     *
     * @group Especialidad
     * @urlParam id string required ID de la especialidad. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Especialidad eliminada"
     * }
     * @response 400 scenario="Error" {
     *   "error": "No se puede eliminar, hay citas asociadas."
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Especialidad no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $especialidad = Especialidad::find($id);

        if ($especialidad->citas()->count() > 0) {
            return response()->json([
                'error' => 'No se puede eliminar, hay citas asociadas.'
            ], 400);
        }

        $especialidad->delete();

        return response()->json(['message' => 'Especialidad eliminada']);
    }
}
