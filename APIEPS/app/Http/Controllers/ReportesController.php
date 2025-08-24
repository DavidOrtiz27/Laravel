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
    public function citasPorPaciente($pacienteId)
    {
        $citas = Cita::with(['medico', 'especialidad'])
            ->where('paciente_id', $pacienteId)
            ->get();

        return response()->json($citas);
    }

    public function historialPaciente($pacienteId)
    {
        $historia = Paciente::with(['historiaClinica', 'consultasMedicas'])
            ->where('id', $pacienteId)
            ->first();

        return response()->json($historia);
    }

    public function recetasPorConsulta($consultaId)
    {
        $recetas = RecetaMedica::with('medicamento')
            ->where('consulta_medica_id', $consultaId)
            ->get();

        return response()->json($recetas);
    }

    public function pagosPorPaciente($pacienteId)
    {
        $pagos = Pago::whereHas('factura', function ($query) use ($pacienteId) {
            $query->where('paciente_id', $pacienteId);
        })
            ->with('factura')
            ->get();

        return response()->json($pagos);
    }


    public function pacientesPorAseguradora($aseguradoraId)
    {
        $aseguradora = Aseguradora::with('pacientes')
            ->where('id', $aseguradoraId)
            ->first();

        return response()->json($aseguradora);
    }
}
