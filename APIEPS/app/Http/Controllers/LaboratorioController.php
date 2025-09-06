<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaboratorioController extends Controller
{
    /**
     * Obtiene una lista de todos los laboratorios.
     *
     * @group Laboratorio
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre": "Laboratorio Central",
     *       "direccion": "Calle Principal 123",
     *       "telefono": "555-0123"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $Laboratorio = Laboratorio::all();
        return response()->json($Laboratorio);
    }

    /**
     * Crea un nuevo laboratorio.
     *
     * @group Laboratorio
     * @bodyParam nombre string required Nombre del laboratorio. Example: Laboratorio Central
     * @bodyParam direccion string opcional Dirección del laboratorio. Example: Calle Principal 123
     * @bodyParam telefono string opcional Teléfono del laboratorio. Example: 555-0123
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Laboratorio Central",
     *   "direccion": "Calle Principal 123",
     *   "telefono": "555-0123"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $laboratorio = Laboratorio::create($request->all());
        return response()->json($laboratorio);
    }

    /**
     * Obtiene un laboratorio específico por su ID.
     *
     * @group Laboratorio
     * @urlParam id string required ID del laboratorio. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Laboratorio Central",
     *   "direccion": "Calle Principal 123",
     *   "telefono": "555-0123"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Laboratorio no encontrado"
     * }
     */
    public function show(string $id)
    {
        $laboratorio = Laboratorio::findOrFail($id);
        return response()->json($laboratorio);
    }

    /**
     * Actualiza un laboratorio existente.
     *
     * @group Laboratorio
     * @urlParam id string required ID del laboratorio. Example: 1
     * @bodyParam nombre string opcional Nombre del laboratorio. Example: Laboratorio Central
     * @bodyParam direccion string opcional Dirección del laboratorio. Example: Calle Principal 123
     * @bodyParam telefono string opcional Teléfono del laboratorio. Example: 555-0123
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Laboratorio Central",
     *   "direccion": "Calle Principal 123",
     *   "telefono": "555-0123"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Laboratorio no encontrado"
     * }
     */
    public function update(Request $request, string $id)
    {
        $laboratorio = Laboratorio::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $laboratorio->update($request->all());
        return response()->json($laboratorio);
    }

    /**
     * Elimina un laboratorio existente.
     *
     * @group Laboratorio
     * @urlParam id string required ID del laboratorio. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Laboratorio eliminado"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Laboratorio no encontrado"
     * }
     */
    public function destroy(string $id)
    {
        $laboratorio = Laboratorio::findOrFail($id);
        $laboratorio->delete();

        return response()->json(['message' => 'Laboratorio eliminado']);
    }
}
