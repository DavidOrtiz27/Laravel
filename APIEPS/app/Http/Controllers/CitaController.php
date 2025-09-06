<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    /**
     * Obtiene una lista de todas las citas.
     * @group Citas
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "paciente_id": 1,
     *       "especialidad_id": 1,
     *       "medico_id": 1,
     *       "consultorio_id": 1,
     *       "fecha": "2025-01-01",
     *       "hora": "10:00:00",
     *       "estado": "programada"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $Cita = Cita::all();
        return response()->json($Cita);
    }

    /**
     * Crea una nueva cita.
     * @group Citas
     * @bodyParam paciente_id integer required ID del paciente. Example: 1
     * @bodyParam especialidad_id integer required ID de la especialidad. Example: 1
     * @bodyParam medico_id integer required ID del médico. Example: 1
     * @bodyParam consultorio_id integer required ID del consultorio. Example: 1
     * @bodyParam fecha date required Fecha de la cita. Example: 2025-01-01
     * @bodyParam hora time required Hora de la cita. Example: 10:00:00
     * @bodyParam estado string required Estado de la cita. Example: programada
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "especialidad_id": 1,
     *   "medico_id": 1,
     *   "consultorio_id": 1,
     *   "fecha": "2025-01-01",
     *   "hora": "10:00:00",
     *   "estado": "programada"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'especialidad_id'=> 'required|integer|exists:especialidades,id',
            'medico_id' => 'required|integer|exists:medicos,id',
            'consultorio_id' => 'required|integer|exists:consultorios,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $cita = Cita::create($request->all());
        return response()->json($cita);
    }

    /**
     * Obtiene una cita específica por su ID.
     * @group Citas
     * @urlParam id string required ID de la cita. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "especialidad_id": 1,
     *   "medico_id": 1,
     *   "consultorio_id": 1,
     *   "fecha": "2025-01-01",
     *   "hora": "10:00:00",
     *   "estado": "programada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Cita no encontrada"
     * }
     */
    public function show(string $id)
    {
        $cita = Cita::findOrFail($id);
        return response()->json($cita);
    }

    /**
     * Actualiza una cita existente.
     * @group Citas
     * @urlParam id string required ID de la cita. Example: 1
     * @bodyParam paciente_id integer required ID del paciente. Example: 1
     * @bodyParam especialidad_id integer required ID de la especialidad. Example: 1
     * @bodyParam medico_id integer required ID del médico. Example: 1
     * @bodyParam consultorio_id integer required ID del consultorio. Example: 1
     * @bodyParam fecha date opcional Fecha de la cita. Example: 2025-01-01
     * @bodyParam hora time opcional Hora de la cita. Example: 10:00:00
     * @bodyParam estado string opcional Estado de la cita. Example: programada
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "paciente_id": 1,
     *   "especialidad_id": 1,
     *   "medico_id": 1,
     *   "consultorio_id": 1,
     *   "fecha": "2025-01-01",
     *   "hora": "10:00:00",
     *   "estado": "programada"
     * }
     * @response 400 scenario="Validation error" {
     *   "message": "Los datos proporcionados no son válidos"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Cita no encontrada"
     * }
     */
    public function update(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'especialidad_id' => 'required|integer|exists:especialidades,id',
            'medico_id' => 'required|integer|exists:medicos,id',
            'consultorio_id' => 'required|integer|exists:consultorios,id',
            'fecha' => 'date',
            'hora' => '',
            'estado' => 'string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $cita->update($request->all());
        return response()->json($cita);
    }

    /**
     * Elimina una cita existente.
     * @group Citas
     * @urlParam id string required ID de la cita. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "message": "Cita eliminada"
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Cita no encontrada"
     * }
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return response()->json(['message' => 'Cita eliminada']);
    }
}
