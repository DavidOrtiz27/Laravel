<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicamentoController extends Controller
{
    /**
     * Listar todos los medicamentos
     *
     * Obtiene una lista de todos los medicamentos registrados en el sistema.
     *
     * @group Medicamento
     * @response 200 scenario="Éxito" {
     *     "data": [
     *         {
     *             "id": 1,
     *             "nombre": "Paracetamol",
     *             "descripcion": "Analgésico y antipirético",
     *             "dosis": "500mg",
     *             "presentacion": "Tabletas",
     *             "created_at": "2025-09-05T12:00:00.000000Z",
     *             "updated_at": "2025-09-05T12:00:00.000000Z"
     *         }
     *     ]
     * }
     */
    public function index()
    {
        $Medicamento = Medicamento::all();
        return response()->json($Medicamento);
    }

    /**
     * Crear nuevo medicamento
     *
     * Registra un nuevo medicamento en el sistema.
     *
     * @group Medicamento
     * @bodyParam nombre string required Nombre del medicamento. Example: Paracetamol
     * @bodyParam descripcion string Descripción del medicamento. Example: Analgésico y antipirético
     * @bodyParam dosis string Dosis recomendada del medicamento. Example: 500mg
     * @bodyParam presentacion string Presentación del medicamento. Example: Tabletas
     * @response 200 scenario="Éxito" {
     *     "id": 1,
     *     "nombre": "Paracetamol",
     *     "descripcion": "Analgésico y antipirético",
     *     "dosis": "500mg",
     *     "presentacion": "Tabletas",
     *     "created_at": "2025-09-05T12:00:00.000000Z",
     *     "updated_at": "2025-09-05T12:00:00.000000Z"
     * }
     * @response 400 scenario="Error de validación" {
     *     "nombre": ["El campo nombre es obligatorio"]
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'dosis' => 'nullable|string|max:100',
            'presentacion' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $medicamento = Medicamento::create($request->all());
        return response()->json($medicamento);
    }

    /**
     * Obtener medicamento específico
     *
     * Muestra la información detallada de un medicamento específico.
     *
     * @group Medicamento
     * @urlParam id required El ID del medicamento. Example: 1
     * @response 200 scenario="Éxito" {
     *     "id": 1,
     *     "nombre": "Paracetamol",
     *     "descripcion": "Analgésico y antipirético",
     *     "dosis": "500mg",
     *     "presentacion": "Tabletas",
     *     "created_at": "2025-09-05T12:00:00.000000Z",
     *     "updated_at": "2025-09-05T12:00:00.000000Z"
     * }
     * @response 404 scenario="No encontrado" {
     *     "message": "No query results for model [App\\Models\\Medicamento]."
     * }
     */
    public function show(string $id)
    {
        $medicamento = Medicamento::findOrFail($id);
        return response()->json($medicamento);
    }

    /**
     * Actualizar medicamento
     *
     * Actualiza la información de un medicamento existente.
     *
     * @group Medicamento
     * @urlParam id required El ID del medicamento. Example: 1
     * @bodyParam nombre string Nombre del medicamento. Example: Paracetamol
     * @bodyParam descripcion string Descripción del medicamento. Example: Analgésico y antipirético
     * @bodyParam dosis string Dosis recomendada del medicamento. Example: 500mg
     * @bodyParam presentacion string Presentación del medicamento. Example: Tabletas
     * @response 200 scenario="Éxito" {
     *     "id": 1,
     *     "nombre": "Paracetamol",
     *     "descripcion": "Analgésico y antipirético actualizado",
     *     "dosis": "500mg",
     *     "presentacion": "Tabletas",
     *     "created_at": "2025-09-05T12:00:00.000000Z",
     *     "updated_at": "2025-09-05T12:00:00.000000Z"
     * }
     * @response 400 scenario="Error de validación" {
     *     "nombre": ["El formato del nombre es inválido"]
     * }
     * @response 404 scenario="No encontrado" {
     *     "message": "No query results for model [App\\Models\\Medicamento]."
     * }
     */
    public function update(Request $request, string $id)
    {
        $medicamento = Medicamento::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'dosis' => 'nullable|string|max:100',
            'presentacion' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $medicamento->update($request->all());
        return response()->json($medicamento);
    }

    /**
     * Eliminar medicamento
     *
     * Elimina un medicamento específico del sistema.
     *
     * @group Medicamento
     * @urlParam id required El ID del medicamento. Example: 1
     * @response 200 scenario="Éxito" {
     *     "message": "Medicamento eliminado"
     * }
     * @response 404 scenario="No encontrado" {
     *     "message": "No query results for model [App\\Models\\Medicamento]."
     * }
     */
    public function destroy(string $id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->delete();

        return response()->json(['message' => 'Medicamento eliminado']);
    }
}
