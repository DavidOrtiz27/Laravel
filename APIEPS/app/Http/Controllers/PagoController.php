<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagoController extends Controller
{
    /**
     * Obtiene una lista de todos los pagos.
     *
     * @group Pago
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "factura_id": 1,
     *       "fecha_pago": "2025-01-01",
     *       "monto": 100.00,
     *       "metodo_pago": "tarjeta"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $Pago = Pago::all();
        return response()->json($Pago);
    }

    /**
     * Crea un nuevo pago.
     *
     * @group Pago
     * @bodyParam factura_id integer required ID de la factura. Example: 1
     * @bodyParam fecha_pago date required Fecha del pago. Example: 2025-01-01
     * @bodyParam monto numeric required Monto del pago. Example: 100.00
     * @bodyParam metodo_pago string required Método de pago utilizado. Example: tarjeta
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "factura_id": 1,
     *   "fecha_pago": "2025-01-01",
     *   "monto": 100.00,
     *   "metodo_pago": "tarjeta"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'factura_id' => 'required|integer|exists:facturas,id',
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $pago = Pago::create($request->all());
        return response()->json($pago);
    }

    /**
     * Obtiene un pago específico por su ID.
     *
     * @group Pago
     * @urlParam id string required ID del pago. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "factura_id": 1,
     *   "fecha_pago": "2025-01-01",
     *   "monto": 100.00,
     *   "metodo_pago": "tarjeta"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Pago no encontrado"
     * }
     */
    public function show(string $id)
    {
        $pago = Pago::findOrFail($id);
        return response()->json($pago);
    }

    /**
     * Actualiza un pago existente.
     *
     * @group Pago
     * @urlParam id string required ID del pago. Example: 1
     * @bodyParam factura_id integer opcional ID de la factura. Example: 1
     * @bodyParam fecha_pago date opcional Fecha del pago. Example: 2025-01-01
     * @bodyParam monto numeric opcional Monto del pago. Example: 100.00
     * @bodyParam metodo_pago string opcional Método de pago utilizado. Example: tarjeta
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "factura_id": 1,
     *   "fecha_pago": "2025-01-01",
     *   "monto": 100.00,
     *   "metodo_pago": "tarjeta"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Pago no encontrado"
     * }
     */
    public function update(Request $request, string $id)
    {
        $pago = Pago::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'factura_id' => 'integer|exists:facturas,id',
            'fecha_pago' => 'date',
            'monto' => 'numeric|min:0',
            'metodo_pago' => 'string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $pago->update($request->all());
        return response()->json($pago);
    }

    /**
     * Elimina un pago existente.
     *
     * @group Pago
     * @urlParam id string required ID del pago. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Pago eliminado"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Pago no encontrado"
     * }
     */
    public function destroy(string $id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return response()->json(['message' => 'Pago eliminado']);
    }
}
