<?php

use App\Http\Controllers\AfiliacionController;
use App\Http\Controllers\AseguradoraController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ConsultaMedicaController;
use App\Http\Controllers\ConsultorioController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\ExamenMedicoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\OrdenExamenController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RecetaMedicaController;
use App\Http\Controllers\ReportesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('registrar',[AuthController::class,'registrar']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::post('especialidades',[EspecialidadController::class,'store']);
    Route::post('logout',[AuthController::class,'logout']);
});



// ---------------------------
// Especialidades
// ---------------------------
Route::get('especialidades',[EspecialidadController::class,'index']);
Route::get('especialidades/{id}',[EspecialidadController::class,'show']);
Route::put('especialidades/{id}', [EspecialidadController::class, 'update']);
Route::delete('especialidades/{id}',[EspecialidadController::class,'destroy']);

// ---------------------------/
// Médicos
// ---------------------------
Route::get('medico',[MedicoController::class,'index']);
Route::get('medico/{id}',[MedicoController::class,'show']);
Route::post('medico',[MedicoController::class,'store']);
Route::put('medico/{id}', [MedicoController::class, 'update']);
Route::delete('medico/{id}',[MedicoController::class,'destroy']);

// ---------------------------
// Pacientes
// ---------------------------
Route::get('pacientes',[PacienteController::class,'index']);
Route::get('pacientes/{id}',[PacienteController::class,'show']);
Route::post('pacientes',[PacienteController::class,'store']);
Route::put('pacientes/{id}', [PacienteController::class, 'update']);
Route::delete('pacientes/{id}',[PacienteController::class,'destroy']);

// ---------------------------
// Citas
// ---------------------------
Route::get('citas',[CitaController::class,'index']);
Route::get('citas/{id}',[CitaController::class,'show']);
Route::post('citas',[CitaController::class,'store']);
Route::put('citas/{id}', [CitaController::class, 'update']);
Route::delete('citas/{id}', [CitaController::class, 'destroy']);

// ---------------------------
// Afiliaciones
// ---------------------------
Route::get('afiliaciones', [AfiliacionController::class, 'index']);
Route::get('afiliaciones/{id}', [AfiliacionController::class, 'show']);
Route::post('afiliaciones', [AfiliacionController::class, 'store']);
Route::put('afiliaciones/{id}', [AfiliacionController::class, 'update']);
Route::delete('afiliaciones/{id}', [AfiliacionController::class, 'destroy']);

// ---------------------------
// Aseguradoras
// ---------------------------
Route::get('aseguradoras', [AseguradoraController::class, 'index']);
Route::get('aseguradoras/{id}', [AseguradoraController::class, 'show']);
Route::post('aseguradoras', [AseguradoraController::class, 'store']);
Route::put('aseguradoras/{id}', [AseguradoraController::class, 'update']);
Route::delete('aseguradoras/{id}', [AseguradoraController::class, 'destroy']);

// ---------------------------
// Ciudades
// ---------------------------
Route::get('ciudades', [CiudadController::class, 'index']);
Route::get('ciudades/{id}', [CiudadController::class, 'show']);
Route::post('ciudades', [CiudadController::class, 'store']);
Route::put('ciudades/{id}', [CiudadController::class, 'update']);
Route::delete('ciudades/{id}', [CiudadController::class, 'destroy']);

// ---------------------------
// Consultas Médicas
// ---------------------------
Route::get('consultas-medicas', [ConsultaMedicaController::class, 'index']);
Route::get('consultas-medicas/{id}', [ConsultaMedicaController::class, 'show']);
Route::post('consultas-medicas', [ConsultaMedicaController::class, 'store']);
Route::put('consultas-medicas/{id}', [ConsultaMedicaController::class, 'update']);
Route::delete('consultas-medicas/{id}', [ConsultaMedicaController::class, 'destroy']);

// ---------------------------
// Consultorios
// ---------------------------
Route::get('consultorios', [ConsultorioController::class, 'index']);
Route::get('consultorios/{id}', [ConsultorioController::class, 'show']);
Route::post('consultorios', [ConsultorioController::class, 'store']);
Route::put('consultorios/{id}', [ConsultorioController::class, 'update']);
Route::delete('consultorios/{id}', [ConsultorioController::class, 'destroy']);

// ---------------------------
// Exámenes Médicos
// ---------------------------
Route::get('examenes-Medico', [ExamenMedicoController::class, 'index']);
Route::get('examenes-Medico/{id}', [ExamenMedicoController::class, 'show']);
Route::post('examenes-Medico', [ExamenMedicoController::class, 'store']);
Route::put('examenes-Medico/{id}', [ExamenMedicoController::class, 'update']);
Route::delete('examenes-Medico/{id}', [ExamenMedicoController::class, 'destroy']);

// ---------------------------
// Facturas
// ---------------------------
Route::get('facturas', [FacturaController::class, 'index']);
Route::get('facturas/{id}', [FacturaController::class, 'show']);
Route::post('facturas', [FacturaController::class, 'store']);
Route::put('facturas/{id}', [FacturaController::class, 'update']);
Route::delete('facturas/{id}', [FacturaController::class, 'destroy']);

// ---------------------------
// Historias Clínicas
// ---------------------------
Route::get('historias-clinicas', [HistoriaClinicaController::class, 'index']);
Route::get('historias-clinicas/{id}', [HistoriaClinicaController::class, 'show']);
Route::post('historias-clinicas', [HistoriaClinicaController::class, 'store']);
Route::put('historias-clinicas/{id}', [HistoriaClinicaController::class, 'update']);
Route::delete('historias-clinicas/{id}', [HistoriaClinicaController::class, 'destroy']);

// ---------------------------
// Horarios
// ---------------------------
Route::get('horarios', [HorarioController::class, 'index']);
Route::get('horarios/{id}', [HorarioController::class, 'show']);
Route::post('horarios', [HorarioController::class, 'store']);
Route::put('horarios/{id}', [HorarioController::class, 'update']);
Route::delete('horarios/{id}', [HorarioController::class, 'destroy']);

// ---------------------------
// Laboratorios
// ---------------------------
Route::get('laboratorios', [LaboratorioController::class, 'index']);
Route::get('laboratorios/{id}', [LaboratorioController::class, 'show']);
Route::post('laboratorios', [LaboratorioController::class, 'store']);
Route::put('laboratorios/{id}', [LaboratorioController::class, 'update']);
Route::delete('laboratorios/{id}', [LaboratorioController::class, 'destroy']);

// ---------------------------
// Medicamentos
// ---------------------------
Route::get('medicamentos', [MedicamentoController::class, 'index']);
Route::get('medicamentos/{id}', [MedicamentoController::class, 'show']);
Route::post('medicamentos', [MedicamentoController::class, 'store']);
Route::put('medicamentos/{id}', [MedicamentoController::class, 'update']);
Route::delete('medicamentos/{id}', [MedicamentoController::class, 'destroy']);

// ---------------------------
// Órdenes de Examen
// ---------------------------
Route::get('ordenes-examenes', [OrdenExamenController::class, 'index']);
Route::get('ordenes-examenes/{id}', [OrdenExamenController::class, 'show']);
Route::post('ordenes-examenes', [OrdenExamenController::class, 'store']);
Route::put('ordenes-examenes/{id}', [OrdenExamenController::class, 'update']);
Route::delete('ordenes-examenes/{id}', [OrdenExamenController::class, 'destroy']);

// ---------------------------
// Pagos
// ---------------------------
Route::get('pagos', [PagoController::class, 'index']);
Route::get('pagos/{id}', [PagoController::class, 'show']);
Route::post('pagos', [PagoController::class, 'store']);
Route::put('pagos/{id}', [PagoController::class, 'update']);
Route::delete('pagos/{id}', [PagoController::class, 'destroy']);

// ---------------------------
// Recetas Médicas
// ---------------------------
Route::get('recetas-medicas', [RecetaMedicaController::class, 'index']);
Route::get('recetas-medicas/{id}', [RecetaMedicaController::class, 'show']);
Route::post('recetas-medicas', [RecetaMedicaController::class, 'store']);
Route::put('recetas-medicas/{id}', [RecetaMedicaController::class, 'update']);
Route::delete('recetas-medicas/{id}', [RecetaMedicaController::class, 'destroy']);


// ---------------------------
// Reportes
// ---------------------------


// Citas de un paciente
Route::get('reportes/citas/{pacienteId}', [ReportesController::class, 'citasPorPaciente']);

// Historial clínico de un paciente
Route::get('reportes/historial/{pacienteId}', [ReportesController::class, 'historialPaciente']);

// Recetas médicas por consulta
Route::get('reportes/recetas/{consultaId}', [ReportesController::class, 'recetasPorConsulta']);

// Pagos realizados por un paciente
Route::get('reportes/pagos/{pacienteId}', [ReportesController::class, 'pagosPorPaciente']);

// Pacientes afiliados a una aseguradora
Route::get('reportes/aseguradora/{aseguradoraId}/pacientes', [ReportesController::class, 'pacientesPorAseguradora']);


