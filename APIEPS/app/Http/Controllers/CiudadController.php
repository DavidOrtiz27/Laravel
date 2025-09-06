<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CiudadController extends Controller
{
    /**
     * Obtiene una lista de todas las ciudades.
     *
     * @group Ciudad
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre": "Ciudad Example"
     *     }
     *   ]
     * }
     *
     * @unauthenticated
     */
    public function index()
    {
        $Ciudad = Ciudad::all();
        return response()->json($Ciudad);
    }

    /**
     * Crea una nueva ciudad.
     *
     * @group Ciudad
     * @bodyParam nombre string required Nombre de la ciudad. Example: Ciudad Example
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Ciudad Example"
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

        $ciudad = Ciudad::create($request->all());
        return response()->json($ciudad);
    }

    /**
     * Obtiene una ciudad específica por su ID.
     *
     * @group Ciudad
     * @urlParam id string required ID de la ciudad. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Ciudad Example"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Ciudad no encontrada"
     * }
     *
     * @unauthenticated
     */
    public function show(string $id)
    {
        $ciudad = Ciudad::findOrFail($id);
        return response()->json($ciudad);
    }

    /**
     * Actualiza una ciudad existente.
     *
     * @group Ciudad
     * @urlParam id string required ID de la ciudad. Example: 1
     * @bodyParam nombre string opcional Nombre de la ciudad. Example: Ciudad Example
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Ciudad Example"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Ciudad no encontrada"
     * }
     */
    public function update(Request $request, string $id)
    {
        $ciudad = Ciudad::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $ciudad->update($request->all());
        return response()->json($ciudad);
    }

    /**
     * Elimina una ciudad existente.
     *
     * @group Ciudad
     * @urlParam id string required ID de la ciudad. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Ciudad eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Ciudad no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $ciudad = Ciudad::findOrFail($id);
        $ciudad->delete();

        return response()->json(['message' => 'Ciudad eliminada']);
    }
}
