<?php

namespace App\Http\Controllers;

use App\Models\Consultorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultorioController extends Controller
{
    /**
     * Obtiene una lista de todos los consultorios.
     *
     * @group Consultorio
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "ciudad_id": 1,
     *       "nombre": "Consultorio Principal",
     *       "direccion": "Calle 123",
     *       "telefono": "1234567890"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $Consultorio = Consultorio::all();
        return response()->json($Consultorio);
    }

    /**
     * Crea un nuevo consultorio.
     *
     * @group Consultorio
     * @bodyParam ciudad_id integer required ID de la ciudad. Example: 1
     * @bodyParam nombre string required Nombre del consultorio. Example: Consultorio Principal
     * @bodyParam direccion string opcional Dirección del consultorio. Example: Calle 123
     * @bodyParam telefono string opcional Teléfono del consultorio. Example: 1234567890
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "ciudad_id": 1,
     *   "nombre": "Consultorio Principal",
     *   "direccion": "Calle 123",
     *   "telefono": "1234567890"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ciudad_id' => 'required|integer|exists:ciudades,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $consultorio = Consultorio::create($request->all());
        return response()->json($consultorio);
    }

    /**
     * Obtiene un consultorio específico por su ID.
     *
     * @group Consultorio
     * @urlParam id string required ID del consultorio. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "ciudad_id": 1,
     *   "nombre": "Consultorio Principal",
     *   "direccion": "Calle 123",
     *   "telefono": "1234567890"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Consultorio no encontrado"
     * }
     */
    public function show(string $id)
    {
        $consultorio = Consultorio::findOrFail($id);
        return response()->json($consultorio);
    }

    /**
     * Actualiza un consultorio existente.
     *
     * @group Consultorio
     * @urlParam id string required ID del consultorio. Example: 1
     * @bodyParam ciudad_id integer opcional ID de la ciudad. Example: 1
     * @bodyParam nombre string opcional Nombre del consultorio. Example: Consultorio Principal
     * @bodyParam direccion string opcional Dirección del consultorio. Example: Calle 123
     * @bodyParam telefono string opcional Teléfono del consultorio. Example: 1234567890
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "ciudad_id": 1,
     *   "nombre": "Consultorio Principal",
     *   "direccion": "Calle 123",
     *   "telefono": "1234567890"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Consultorio no encontrado"
     * }
     */
    public function update(Request $request, string $id)
    {
        $consultorio = Consultorio::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ciudad_id' => 'integer|exists:ciudades,id',
            'nombre' => 'string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $consultorio->update($request->all());
        return response()->json($consultorio);
    }

    /**
     * Elimina un consultorio existente.
     *
     * @group Consultorio
     * @urlParam id string required ID del consultorio. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Consultorio eliminado"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Consultorio no encontrado"
     * }
     */
    public function destroy(string $id)
    {
        $consultorio = Consultorio::findOrFail($id);
        $consultorio->delete();

        return response()->json(['message' => 'Consultorio eliminado']);
    }
}
