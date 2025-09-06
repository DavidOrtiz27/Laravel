<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicoController extends Controller
{
    /**
     * Obtiene una lista de todos los médicos.
     *
     * @group Medico
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre": "Dr. Juan Pérez",
     *       "documento": "12345678",
     *       "telefono": "1234567890",
     *       "email": "juan.perez@example.com",
     *       "especialidad_id": 1,
     *       "ciudad_id": 1
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $medico = Medico::all();
        return response()->json($medico);
    }

    /**
     * Crea un nuevo médico.
     *
     * @group Medico
     * @bodyParam nombre string required Nombre del médico. Example: Dr. Juan Pérez
     * @bodyParam documento string required Número de documento del médico. Example: 12345678
     * @bodyParam telefono string opcional Número de teléfono del médico. Example: 1234567890
     * @bodyParam email string opcional Correo electrónico del médico. Example: juan.perez@example.com
     * @bodyParam especialidad_id integer required ID de la especialidad. Example: 1
     * @bodyParam ciudad_id integer required ID de la ciudad. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Dr. Juan Pérez",
     *   "documento": "12345678",
     *   "telefono": "1234567890",
     *   "email": "juan.perez@example.com",
     *   "especialidad_id": 1,
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
            'documento' => 'required|string|max:50|unique:medicos',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100|unique:medicos',
            'especialidad_id' => 'required|integer|exists:especialidades,id',
            'ciudad_id' => 'required|integer|exists:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $medico = Medico::create($request->all());
        return response()->json($medico);
    }

    /**
     * Obtiene un médico específico por su ID.
     *
     * @group Medico
     * @urlParam id string required ID del médico. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Dr. Juan Pérez",
     *   "documento": "12345678",
     *   "telefono": "1234567890",
     *   "email": "juan.perez@example.com",
     *   "especialidad_id": 1,
     *   "ciudad_id": 1
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Médico no encontrado"
     * }
     */
    public function show(string $id)
    {
        $medico = Medico::findOrFail($id);
        return response()->json($medico);
    }

    /**
     * Actualiza un médico existente.
     *
     * @group Medico
     * @urlParam id string required ID del médico. Example: 1
     * @bodyParam nombre string opcional Nombre del médico. Example: Dr. Juan Pérez
     * @bodyParam documento string opcional Número de documento del médico. Example: 12345678
     * @bodyParam telefono string opcional Número de teléfono del médico. Example: 1234567890
     * @bodyParam email string opcional Correo electrónico del médico. Example: juan.perez@example.com
     * @bodyParam especialidad_id integer opcional ID de la especialidad. Example: 1
     * @bodyParam ciudad_id integer opcional ID de la ciudad. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Dr. Juan Pérez",
     *   "documento": "12345678",
     *   "telefono": "1234567890",
     *   "email": "juan.perez@example.com",
     *   "especialidad_id": 1,
     *   "ciudad_id": 1
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Médico no encontrado"
     * }
     */
    public function update(Request $request, string $id)
    {
        $medico = Medico::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'documento' => 'string|max:50,',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'especialidad_id' => 'integer|exists:especialidades,id',
            'ciudad_id' => 'integer|exists:ciudades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $medico->update($request->all());
        return response()->json($medico);
    }

    /**
     * Elimina un médico existente.
     *
     * @group Medico
     * @urlParam id string required ID del médico. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Médico eliminado"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Médico no encontrado"
     * }
     */
    public function destroy(string $id)
    {
        $medico = Medico::findOrFail($id);
        $medico->delete();

        return response()->json(['message' => 'Médico eliminado']);
    }
}
