<?php

namespace App\Http\Controllers;

use App\Models\Aseguradora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AseguradoraController extends Controller
{
    /**
     * Obtiene una lista de todas las aseguradoras.
     *
     * @group Aseguradora
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre": "Aseguradora Example",
     *       "nit": "123456789",
     *       "direccion": "Calle Principal 123",
     *       "telefono": "1234567890",
     *       "email": "contacto@aseguradora.com",
     *       "ciudad": "1"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $aseguradoras = Aseguradora::all();
        return response()->json($aseguradoras);
    }

    /**
     * Crea una nueva aseguradora.
     *
     * @group Aseguradora
     * @bodyParam nombre string required Nombre de la aseguradora. Example: Aseguradora Example
     * @bodyParam nit string required NIT de la aseguradora. Example: 123456789
     * @bodyParam direccion string opcional Dirección de la aseguradora. Example: Calle Principal 123
     * @bodyParam telefono string opcional Teléfono de la aseguradora. Example: 1234567890
     * @bodyParam email string opcional Email de la aseguradora. Example: contacto@aseguradora.com
     * @bodyParam ciudad string opcional ID de la ciudad. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Aseguradora Example",
     *   "nit": "123456789",
     *   "direccion": "Calle Principal 123",
     *   "telefono": "1234567890",
     *   "email": "contacto@aseguradora.com",
     *   "ciudad": "1"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'nit' => 'required|string|max:50|unique:aseguradoras,nit',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'ciudad' => 'nullable|string|unique:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $aseguradora = Aseguradora::create($request->all());
        return response()->json($aseguradora);
    }

    /**
     * Obtiene una aseguradora específica por su ID.
     *
     * @group Aseguradora
     * @urlParam id string required ID de la aseguradora. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Aseguradora Example",
     *   "nit": "123456789",
     *   "direccion": "Calle Principal 123",
     *   "telefono": "1234567890",
     *   "email": "contacto@aseguradora.com",
     *   "ciudad": "1"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Aseguradora no encontrada"
     * }
     */
    public function show(string $id)
    {
        $aseguradora = Aseguradora::findOrFail($id);
        return response()->json($aseguradora);
    }

    /**
     * Actualiza una aseguradora existente.
     *
     * @group Aseguradora
     * @urlParam id string required ID de la aseguradora. Example: 1
     * @bodyParam nombre string opcional Nombre de la aseguradora. Example: Aseguradora Example
     * @bodyParam nit string opcional NIT de la aseguradora. Example: 123456789
     * @bodyParam direccion string opcional Dirección de la aseguradora. Example: Calle Principal 123
     * @bodyParam telefono string opcional Teléfono de la aseguradora. Example: 1234567890
     * @bodyParam email string opcional Email de la aseguradora. Example: contacto@aseguradora.com
     * @bodyParam ciudad string opcional ID de la ciudad. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Aseguradora Example",
     *   "nit": "123456789",
     *   "direccion": "Calle Principal 123",
     *   "telefono": "1234567890",
     *   "email": "contacto@aseguradora.com",
     *   "ciudad": "1"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Aseguradora no encontrada"
     * }
     */
    public function update(Request $request, string $id)
    {
        $aseguradora = Aseguradora::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'nit' => 'string|max:50|unique:aseguradoras,nit,' . $id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'ciudad' => 'nullable|string|unique:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $aseguradora->update($request->all());
        return response()->json($aseguradora);
    }

    /**
     * Elimina una aseguradora existente.
     *
     * @group Aseguradora
     * @urlParam id string required ID de la aseguradora. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Aseguradora eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Aseguradora no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $aseguradora = Aseguradora::findOrFail($id);
        $aseguradora->delete();

        return response()->json(['message' => 'Aseguradora eliminada']);
    }
}
