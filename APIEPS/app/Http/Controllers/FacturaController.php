<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacturaController extends Controller
{
    // Listar todas las Factura
    /**
     * Obtiene una lista de todas las facturas.
     *
     * @group Factura
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "paciente_id": 1,
     *       "cita_id": 1,
     *       "monto_total": 150.00,
     *       "fecha_emision": "2025-09-05",
     *       "estado": "pagada"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $Factura = Factura::all();
        return response()->json($Factura);
    }

    // Crear nueva factura

    /**
     * Crea una nueva factura.
     *
     * @group Factura
     * @bodyParam paciente_id integer required ID del paciente. Example: 1
     * @bodyParam cita_id integer required ID de la cita. Example: 1
     * @bodyParam monto_total numeric required Monto total de la factura. Example: 150.00
     * @bodyParam fecha_emision date required Fecha de emisión de la factura. Example: 2025-09-05
     * @bodyParam estado string required Estado de la factura. Example: pagada
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "cita_id": 1,
     *   "monto_total": 150.00,
     *   "fecha_emision": "2025-09-05",
     *   "estado": "pagada"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'cita_id' => 'required|integer|exists:citas,id',
            'monto_total' => 'required',
            'fecha_emision' => 'required|date',
            'estado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $factura = Factura::create($request->all());
        return response()->json($factura);
    }

    // Listar factura por ID

    /**
     * Obtiene una factura específica por su ID.
     *
     * @group Factura
     * @urlParam id string required ID de la factura. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "cita_id": 1,
     *   "monto_total": 150.00,
     *   "fecha_emision": "2025-09-05",
     *   "estado": "pagada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Factura no encontrada"
     * }
     */
    public function show(string $id)
    {
        $factura = Factura::findOrFail($id);
        return response()->json($factura);
    }

    // Actualizar factura

    /**
     * Actualiza una factura existente.
     *
     * @group Factura
     * @urlParam id string required ID de la factura. Example: 1
     * @bodyParam paciente_id integer opcional ID del paciente. Example: 1
     * @bodyParam cita_id integer opcional ID de la cita. Example: 1
     * @bodyParam monto_total numeric required Monto total de la factura. Example: 150.00
     * @bodyParam fecha_emision date opcional Fecha de emisión de la factura. Example: 2025-09-05
     * @bodyParam estado string required Estado de la factura. Example: pagada
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "cita_id": 1,
     *   "monto_total": 150.00,
     *   "fecha_emision": "2025-09-05",
     *   "estado": "pagada"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Factura no encontrada"
     * }
     */
    public function update(Request $request, string $id)
    {
        $factura = Factura::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'paciente_id' => 'integer|exists:pacientes,id',
            'cita_id' => 'integer|exists:citas,id',
            'monto_total' => 'required',
            'fecha_emision' => 'date',
            'estado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $factura->update($request->all());
        return response()->json($factura);
    }

    // Eliminar factura

    /**
     * Elimina una factura existente.
     *
     * @group Factura
     * @urlParam id string required ID de la factura. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Factura eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Factura no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();

        return response()->json(['message' => 'Factura eliminada']);
    }
}
