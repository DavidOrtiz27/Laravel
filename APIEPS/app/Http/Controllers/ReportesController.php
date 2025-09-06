<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Pago;
use App\Models\RecetaMedica;
use App\Models\Aseguradora;

class ReportesController extends Controller
{
    /**
     * Obtiene todas las citas de un paciente específico.
     *
     * @group Reportes
     * @urlParam pacienteId integer required ID del paciente. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "paciente_id": 1,
     *       "medico": {
     *         "id": 1,
     *         "nombre": "Dr. Juan Pérez"
     *       },
     *       "especialidad": {
     *         "id": 1,
     *         "nombre": "Cardiología"
     *       },
     *       "fecha": "2025-09-05"
     *     }
     *   ]
     * }
     */
    public function citasPorPaciente($pacienteId)
    {
        $citas = Cita::with(['medico', 'especialidad'])
            ->where('paciente_id', $pacienteId)
            ->get();

        return response()->json($citas);
    }

    /**
     * Obtiene el historial clínico completo de un paciente.
     *
     * @group Reportes
     * @urlParam pacienteId integer required ID del paciente. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Juan García",
     *   "historia_clinica": {
     *     "id": 1,
     *     "antecedentes": "Hipertensión"
     *   },
     *   "consultas_medicas": [
     *     {
     *       "id": 1,
     *       "fecha": "2025-09-05",
     *       "diagnostico": "Gripe"
     *     }
     *   ]
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Paciente no encontrado"
     * }
     */
    public function historialPaciente($pacienteId)
    {
        $historia = Paciente::with(['historiaClinica', 'consultasMedicas'])
            ->where('id', $pacienteId)
            ->first();

        return response()->json($historia);
    }

    /**
     * Obtiene todas las recetas médicas asociadas a una consulta.
     *
     * @group Reportes
     * @urlParam consultaId integer required ID de la consulta médica. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "consulta_medica_id": 1,
     *       "medicamento": {
     *         "id": 1,
     *         "nombre": "Paracetamol",
     *         "dosis": "500mg"
     *       },
     *       "indicaciones": "Tomar cada 8 horas"
     *     }
     *   ]
     * }
     */
    public function recetasPorConsulta($consultaId)
    {
        $recetas = RecetaMedica::with('medicamento')
            ->where('consulta_medica_id', $consultaId)
            ->get();

        return response()->json($recetas);
    }

    /**
     * Obtiene todos los pagos realizados por un paciente.
     *
     * @group Reportes
     * @urlParam pacienteId integer required ID del paciente. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "data": [
     *     {
     *       "id": 1,
     *       "monto": 150.00,
     *       "fecha": "2025-09-05",
     *       "factura": {
     *         "id": 1,
     *         "numero": "F001-0001",
     *         "total": 150.00
     *       }
     *     }
     *   ]
     * }
     */
    public function pagosPorPaciente($pacienteId)
    {
        $pagos = Pago::whereHas('factura', function ($query) use ($pacienteId) {
            $query->where('paciente_id', $pacienteId);
        })
            ->with('factura')
            ->get();

        return response()->json($pagos);
    }


    /**
     * Obtiene todos los pacientes afiliados a una aseguradora específica.
     *
     * @group Reportes
     * @urlParam aseguradoraId integer required ID de la aseguradora. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "nombre": "Seguros ABC",
     *   "pacientes": [
     *     {
     *       "id": 1,
     *       "nombre": "Juan García",
     *       "numero_afiliado": "AF001"
     *     }
     *   ]
     * }
     * @response 404 scenario="Not found" {
     *   "message": "Aseguradora no encontrada"
     * }
     */
    public function pacientesPorAseguradora($aseguradoraId)
    {
        $aseguradora = Aseguradora::with('pacientes')
            ->where('id', $aseguradoraId)
            ->first();

        return response()->json($aseguradora);
    }
}
