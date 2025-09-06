<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AfiliacionController,
    AseguradoraController,
    CitaController,
    CiudadController,
    ConsultaMedicaController,
    ConsultorioController,
    EspecialidadController,
    ExamenMedicoController,
    FacturaController,
    HistoriaClinicaController,
    HorarioController,
    LaboratorioController,
    MedicamentoController,
    MedicoController,
    OrdenExamenController,
    PacienteController,
    PagoController,
    RecetaMedicaController,
    ReportesController,
    AuthController
};

/*
|--------------------------------------------------------------------------
| Endpoints Públicos (sin autenticación)
|--------------------------------------------------------------------------
*/
Route::post('registrar', [AuthController::class, 'registrar']);   // registra un usuario normal
Route::post('login', [AuthController::class, 'login']);

// Catálogos públicos
Route::get('especialidades', [EspecialidadController::class, 'index']);
Route::get('especialidades/{id}', [EspecialidadController::class, 'show']);

Route::get('ciudades', [CiudadController::class, 'index']);
Route::get('ciudades/{id}', [CiudadController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Endpoints Privados - Usuarios autenticados (role=user o admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {
    // Autenticación
    Route::post('logout', [AuthController::class, 'logout']);


    // Citas (un paciente gestiona sus citas)
    Route::get('citas', [CitaController::class, 'index']);
    Route::get('citas/{id}', [CitaController::class, 'show']);
    Route::post('citas', [CitaController::class, 'store']);
    Route::put('citas/{id}', [CitaController::class, 'update']);
    Route::delete('citas/{id}', [CitaController::class, 'destroy']);

    // Información del paciente autenticado
    Route::get('pacientes', [PacienteController::class, 'index']);
    Route::get('pacientes/{id}', [PacienteController::class, 'show']);

    // Reportes básicos (accesibles al propio paciente)
    Route::get('reportes/citas/{pacienteId}', [ReportesController::class, 'citasPorPaciente']);
    Route::get('reportes/historial/{pacienteId}', [ReportesController::class, 'historialPaciente']);
    Route::get('reportes/pagos/{pacienteId}', [ReportesController::class, 'pagosPorPaciente']);
});


/*
|--------------------------------------------------------------------------
| Endpoints Privados - Administradores (role=admin o superadmin)
|--------------------------------------------------------------------------
| Gestión de catálogos, CRUD completos, reportes avanzados
*/
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    // Especialidades
    Route::post('especialidades', [EspecialidadController::class, 'store']);
    Route::put('especialidades/{id}', [EspecialidadController::class, 'update']);
    Route::delete('especialidades/{id}', [EspecialidadController::class, 'destroy']);

    // CRUD completos
    Route::apiResource('medicos', MedicoController::class);
    Route::apiResource('afiliaciones', AfiliacionController::class);
    Route::apiResource('aseguradoras', AseguradoraController::class);
    Route::apiResource('consultas-medicas', ConsultaMedicaController::class);
    Route::apiResource('consultorios', ConsultorioController::class);
    Route::apiResource('examenes-medicos', ExamenMedicoController::class);
    Route::apiResource('facturas', FacturaController::class);
    Route::apiResource('historias-clinicas', HistoriaClinicaController::class);
    Route::apiResource('horarios', HorarioController::class);
    Route::apiResource('laboratorios', LaboratorioController::class);
    Route::apiResource('medicamentos', MedicamentoController::class);
    Route::apiResource('ordenes-examenes', OrdenExamenController::class);
    Route::apiResource('pagos', PagoController::class);
    Route::apiResource('recetas-medicas', RecetaMedicaController::class);

    // Gestión completa de pacientes (crear, editar, eliminar)
    Route::apiResource('pacientes', PacienteController::class)->except(['index','show']);

    // Reportes avanzados
    Route::get('reportes/recetas/{consultaId}', [ReportesController::class, 'recetasPorConsulta']);
    Route::get('reportes/aseguradora/{aseguradoraId}/pacientes', [ReportesController::class, 'pacientesPorAseguradora']);
});


/*
|--------------------------------------------------------------------------
| Endpoints Privados - Superadministradores (role=superadmin)
|--------------------------------------------------------------------------
| Acciones exclusivas de máxima jerarquía
*/
Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    Route::post('admin/register', [AuthController::class, 'registrarAdmin']);
});
