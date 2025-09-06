<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacienteController extends Controller
{
    /**
     * Obtiene una lista de todos los pacientes.
     *
     * @group Paciente
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre": "John Doe",
     *       "documento": "12345678",
     *       "telefono": "1234567890",
     *       "email": "john@example.com",
     *       "ciudad_id": 1
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $Paciente = Paciente::all();
        return response()->json($Paciente);
    }

    /**
     * Crea un nuevo paciente.
     *
     * @group Paciente
     * @bodyParam nombre string required Nombre del paciente. Example: John Doe
     * @bodyParam documento string required Número de documento del paciente. Example: 12345678
     * @bodyParam telefono string opcional Número de teléfono del paciente. Example: 1234567890
     * @bodyParam email string opcional Correo electrónico del paciente. Example: john@example.com
     * @bodyParam ciudad_id integer required ID de la ciudad del paciente. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "John Doe",
     *   "documento": "12345678",
     *   "telefono": "1234567890",
     *   "email": "john@example.com",
     *   "ciudad_id": 1
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'documento' => 'required|string|max:50|unique:pacientes',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100|unique:pacientes',
            'ciudad_id' => 'required|integer|exists:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $paciente = Paciente::create($request->all());
        return response()->json($paciente);
    }

    /**
     * Obtiene un paciente específico por su ID.
     *
     * @group Paciente
     * @urlParam id string required ID del paciente. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "John Doe",
     *   "documento": "12345678",
     *   "telefono": "1234567890",
     *   "email": "john@example.com",
     *   "ciudad_id": 1
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Paciente no encontrado"
     * }
     */
    public function show(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    /**
     * Actualiza un paciente existente.
     *
     * @group Paciente
     * @urlParam id string required ID del paciente. Example: 1
     * @bodyParam nombre string opcional Nombre del paciente. Example: John Doe
     * @bodyParam documento string opcional Número de documento del paciente. Example: 12345678
     * @bodyParam telefono string opcional Número de teléfono del paciente. Example: 1234567890
     * @bodyParam email string opcional Correo electrónico del paciente. Example: john@example.com
     * @bodyParam ciudad_id integer opcional ID de la ciudad del paciente. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "John Doe",
     *   "documento": "12345678",
     *   "telefono": "1234567890",
     *   "email": "john@example.com",
     *   "ciudad_id": 1
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Paciente no encontrado"
     * }
     */
    public function update(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string',
            'documento' => 'string|unique:pacientes,documento,' . $id, // <- aquí
            'telefono' => 'nullable|string',
            'email' => 'nullable|email|unique:pacientes,email,' . $id, // <- y aquí
            'ciudad_id' => 'integer|exists:ciudades,id'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $paciente->update($request->all());
        return response()->json($paciente);
    }

    /**
     * Elimina un paciente existente.
     *
     * @group Paciente
     * @urlParam id string required ID del paciente. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Paciente eliminado"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Paciente no encontrado"
     * }
     */
    public function destroy(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return response()->json(['message' => 'Paciente eliminado']);
    }
}
