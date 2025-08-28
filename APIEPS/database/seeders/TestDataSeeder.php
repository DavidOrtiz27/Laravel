<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ciudad;
use App\Models\Especialidad;
use App\Models\Consultorio;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Aseguradora;
use App\Models\Afiliacion;
use App\Models\HistoriaClinica;
use App\Models\ConsultaMedica;
use App\Models\Medicamento;
use App\Models\RecetaMedica;
use App\Models\Laboratorio;
use App\Models\ExamenMedico;
use App\Models\OrdenExamen;
use App\Models\Factura;
use App\Models\Pago;
use App\Models\Horario;

class TestDataSeeder extends Seeder
{
    /**
     * Ejecuta el seeder
     */
    public function run(): void
    {
        echo "🌱 Iniciando Poblado de Base de Datos de Prueba\n";
        echo "==============================================\n\n";

        try {
            // Limpiar tablas existentes (en orden inverso por dependencias)
            $this->cleanTables();
            
            // Crear datos en orden de dependencias
            $this->createCiudades();
            $this->createEspecialidades();
            $this->createConsultorios();
            $this->createMedicos();
            $this->createPacientes();
            $this->createCitas();
            $this->createAseguradoras();
            $this->createAfiliaciones();
            $this->createHistoriasClinicas();
            $this->createConsultasMedicas();
            $this->createMedicamentos();
            $this->createRecetasMedicas();
            $this->createLaboratorios();
            $this->createExamenesMedicos();
            $this->createOrdenesExamenes();
            $this->createFacturas();
            $this->createPagos();
            $this->createHorarios();
            
            echo "\n✅ Base de datos poblada exitosamente con datos de prueba!\n";
            
        } catch (Exception $e) {
            echo "\n❌ Error al poblar la base de datos: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * Limpia las tablas existentes
     */
    private function cleanTables(): void
    {
        echo "🧹 Limpiando tablas existentes...\n";
        
        // Deshabilitar verificación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        
        $tables = [
            'pagos', 'facturas', 'ordenes_examenes', 'examenes_Medico',
            'recetas_medicas', 'consultas_medicas', 'historias_clinicas',
            'citas', 'horarios', 'pacientes', 'medicos', 'consultorios',
            'especialidades', 'afiliaciones', 'aseguradoras', 'ciudades'
        ];
        
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        
        // Rehabilitar verificación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        
        echo "✅ Tablas limpiadas\n";
    }

    /**
     * Crea ciudades de prueba
     */
    private function createCiudades(): void
    {
        echo "🏙️ Creando ciudades...\n";
        
        $ciudades = [
            ['nombre' => 'Bogotá'],
            ['nombre' => 'Medellín'],
            ['nombre' => 'Cali'],
            ['nombre' => 'Barranquilla'],
            ['nombre' => 'Cartagena']
        ];
        
        foreach ($ciudades as $ciudad) {
            Ciudad::create($ciudad);
        }
        
        echo "✅ Ciudades creadas\n";
    }

    /**
     * Crea especialidades de prueba
     */
    private function createEspecialidades(): void
    {
        echo "🏥 Creando especialidades...\n";
        
        $especialidades = [
            ['nombre' => 'Medicina General'],
            ['nombre' => 'Cardiología'],
            ['nombre' => 'Dermatología'],
            ['nombre' => 'Ginecología'],
            ['nombre' => 'Pediatría']
        ];
        
        foreach ($especialidades as $especialidad) {
            Especialidad::create($especialidad);
        }
        
        echo "✅ Especialidades creadas\n";
    }

    /**
     * Crea consultorios de prueba
     */
    private function createConsultorios(): void
    {
        echo "🏢 Creando consultorios...\n";
        
        $consultorios = [
            ['nombre' => 'Consultorio 101', 'ciudad_id' => 1],
            ['nombre' => 'Consultorio 102', 'ciudad_id' => 1],
            ['nombre' => 'Consultorio 201', 'ciudad_id' => 2],
            ['nombre' => 'Consultorio 202', 'ciudad_id' => 2],
            ['nombre' => 'Consultorio 301', 'ciudad_id' => 3]
        ];
        
        foreach ($consultorios as $consultorio) {
            Consultorio::create($consultorio);
        }
        
        echo "✅ Consultorios creados\n";
    }

    /**
     * Crea médicos de prueba
     */
    private function createMedicos(): void
    {
        echo "👨‍⚕️ Creando médicos...\n";
        
        $medicos = [
            [
                'nombre' => 'Dr. Juan Pérez',
                'especialidad_id' => 1,
                'ciudad_id' => 1,
                'documento' => '12345678',
                'email' => 'juan.perez@hospital.com',
                'telefono' => '3001234567'
            ],
            [
                'nombre' => 'Dra. María García',
                'especialidad_id' => 2,
                'ciudad_id' => 1,
                'documento' => '87654321',
                'email' => 'maria.garcia@hospital.com',
                'telefono' => '3007654321'
            ],
            [
                'nombre' => 'Dr. Carlos López',
                'especialidad_id' => 3,
                'ciudad_id' => 2,
                'documento' => '11223344',
                'email' => 'carlos.lopez@hospital.com',
                'telefono' => '3001122334'
            ]
        ];
        
        foreach ($medicos as $medico) {
            Medico::create($medico);
        }
        
        echo "✅ Médicos creados\n";
    }

    /**
     * Crea pacientes de prueba
     */
    private function createPacientes(): void
    {
        echo "👤 Creando pacientes...\n";
        
        $pacientes = [
            [
                'nombre' => 'Ana Rodríguez',
                'documento' => '98765432',
                'direccion' => 'Calle 123 #45-67',
                'telefono' => '3009876543',
                'email' => 'ana.rodriguez@email.com',
                'ciudad_id' => 1
            ],
            [
                'nombre' => 'Luis Martínez',
                'documento' => '55667788',
                'direccion' => 'Carrera 78 #90-12',
                'telefono' => '3005566778',
                'email' => 'luis.martinez@email.com',
                'ciudad_id' => 2
            ],
            [
                'nombre' => 'Carmen Silva',
                'documento' => '33445566',
                'direccion' => 'Avenida 56 #78-90',
                'telefono' => '3003344556',
                'email' => 'carmen.silva@email.com',
                'ciudad_id' => 3
            ]
        ];
        
        foreach ($pacientes as $paciente) {
            Paciente::create($paciente);
        }
        
        echo "✅ Pacientes creados\n";
    }

    /**
     * Crea citas de prueba
     */
    private function createCitas(): void
    {
        echo "📅 Creando citas...\n";
        
        $citas = [
            [
                'paciente_id' => 1,
                'especialidad_id' => 1,
                'medico_id' => 1,
                'consultorio_id' => 1,
                'fecha' => '2025-01-15',
                'hora' => '09:00:00',
                'estado' => 'pendiente'
            ],
            [
                'paciente_id' => 2,
                'especialidad_id' => 2,
                'medico_id' => 2,
                'consultorio_id' => 2,
                'fecha' => '2025-01-16',
                'hora' => '10:00:00',
                'estado' => 'pendiente'
            ],
            [
                'paciente_id' => 3,
                'especialidad_id' => 3,
                'medico_id' => 3,
                'consultorio_id' => 3,
                'fecha' => '2025-01-17',
                'hora' => '11:00:00',
                'estado' => 'pendiente'
            ]
        ];
        
        foreach ($citas as $cita) {
            Cita::create($cita);
        }
        
        echo "✅ Citas creadas\n";
    }

    /**
     * Crea aseguradoras de prueba
     */
    private function createAseguradoras(): void
    {
        echo "🏥 Creando aseguradoras...\n";
        
        $aseguradoras = [
            [
                'nombre' => 'EPS Sanitas',
                'nit' => '900123456-7',
                'direccion' => 'Calle 100 #15-20',
                'telefono' => '6011234567',
                'ciudad_id' => 1
            ],
            [
                'nombre' => 'EPS Sura',
                'nit' => '900765432-1',
                'direccion' => 'Carrera 50 #25-30',
                'telefono' => '6017654321',
                'ciudad_id' => 2
            ],
            [
                'nombre' => 'EPS Famisanar',
                'nit' => '900987654-3',
                'direccion' => 'Avenida 68 #40-50',
                'telefono' => '6019876543',
                'ciudad_id' => 3
            ]
        ];
        
        foreach ($aseguradoras as $aseguradora) {
            Aseguradora::create($aseguradora);
        }
        
        echo "✅ Aseguradoras creadas\n";
    }

    /**
     * Crea afiliaciones de prueba
     */
    private function createAfiliaciones(): void
    {
        echo "📋 Creando afiliaciones...\n";
        
        $afiliaciones = [
            [
                'paciente_id' => 1,
                'aseguradora_id' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => '2025-12-31'
            ],
            [
                'paciente_id' => 2,
                'aseguradora_id' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => '2025-12-31'
            ],
            [
                'paciente_id' => 3,
                'aseguradora_id' => 3,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => '2025-12-31'
            ]
        ];
        
        foreach ($afiliaciones as $afiliacion) {
            Afiliacion::create($afiliacion);
        }
        
        echo "✅ Afiliaciones creadas\n";
    }

    /**
     * Crea historias clínicas de prueba
     */
    private function createHistoriasClinicas(): void
    {
        echo "📋 Creando historias clínicas...\n";
        
        $historias = [
            [
                'paciente_id' => 1,
                'fecha_creacion' => '2024-01-01',
                'observaciones' => 'Paciente sin antecedentes importantes'
            ],
            [
                'paciente_id' => 2,
                'fecha_creacion' => '2024-01-01',
                'observaciones' => 'Paciente con antecedentes cardíacos'
            ],
            [
                'paciente_id' => 3,
                'fecha_creacion' => '2024-01-01',
                'observaciones' => 'Paciente con alergias a medicamentos'
            ]
        ];
        
        foreach ($historias as $historia) {
            HistoriaClinica::create($historia);
        }
        
        echo "✅ Historias clínicas creadas\n";
    }

    /**
     * Crea consultas médicas de prueba
     */
    private function createConsultasMedicas(): void
    {
        echo "🏥 Creando consultas médicas...\n";
        
        $consultas = [
            [
                'cita_id' => 1,
                'motivo' => 'Dolor de cabeza frecuente',
                'diagnostico' => 'Cefalea tensional',
                'tratamiento' => 'Analgésicos y relajación',
                'fecha_consulta' => '2025-01-15'
            ],
            [
                'cita_id' => 2,
                'motivo' => 'Dolor en el pecho',
                'diagnostico' => 'Ansiedad',
                'tratamiento' => 'Terapia de relajación',
                'fecha_consulta' => '2025-01-16'
            ],
            [
                'cita_id' => 3,
                'motivo' => 'Erupción en la piel',
                'diagnostico' => 'Dermatitis de contacto',
                'tratamiento' => 'Cremas tópicas',
                'fecha_consulta' => '2025-01-17'
            ]
        ];
        
        foreach ($consultas as $consulta) {
            ConsultaMedica::create($consulta);
        }
        
        echo "✅ Consultas médicas creadas\n";
    }

    /**
     * Crea medicamentos de prueba
     */
    private function createMedicamentos(): void
    {
        echo "💊 Creando medicamentos...\n";
        
        $medicamentos = [
            [
                'nombre' => 'Paracetamol',
                'descripcion' => 'Analgésico y antipirético',
                'presentacion' => 'Tableta 500mg',
                'stock' => 100
            ],
            [
                'nombre' => 'Ibuprofeno',
                'descripcion' => 'Antiinflamatorio no esteroideo',
                'presentacion' => 'Tableta 400mg',
                'stock' => 75
            ],
            [
                'nombre' => 'Amoxicilina',
                'descripcion' => 'Antibiótico de amplio espectro',
                'presentacion' => 'Cápsula 500mg',
                'stock' => 50
            ]
        ];
        
        foreach ($medicamentos as $medicamento) {
            Medicamento::create($medicamento);
        }
        
        echo "✅ Medicamentos creados\n";
    }

    /**
     * Crea recetas médicas de prueba
     */
    private function createRecetasMedicas(): void
    {
        echo "📝 Creando recetas médicas...\n";
        
        $recetas = [
            [
                'consulta_medica_id' => 1,
                'medicamento_id' => 1,
                'dosis' => '500mg',
                'frecuencia' => 'Cada 8 horas',
                'duracion' => '5 días'
            ],
            [
                'consulta_medica_id' => 2,
                'medicamento_id' => 2,
                'dosis' => '400mg',
                'frecuencia' => 'Cada 12 horas',
                'duracion' => '7 días'
            ],
            [
                'consulta_medica_id' => 3,
                'medicamento_id' => 3,
                'dosis' => '500mg',
                'frecuencia' => 'Cada 8 horas',
                'duracion' => '10 días'
            ]
        ];
        
        foreach ($recetas as $receta) {
            RecetaMedica::create($receta);
        }
        
        echo "✅ Recetas médicas creadas\n";
    }

    /**
     * Crea laboratorios de prueba
     */
    private function createLaboratorios(): void
    {
        echo "🔬 Creando laboratorios...\n";
        
        $laboratorios = [
            [
                'nombre' => 'Laboratorio Central',
                'direccion' => 'Calle 80 #15-25',
                'telefono' => '6012345678',
                'ciudad_id' => 1
            ],
            [
                'nombre' => 'Laboratorio Norte',
                'direccion' => 'Carrera 60 #30-40',
                'telefono' => '6018765432',
                'ciudad_id' => 2
            ],
            [
                'nombre' => 'Laboratorio Sur',
                'direccion' => 'Avenida 40 #50-60',
                'telefono' => '6014567890',
                'ciudad_id' => 3
            ]
        ];
        
        foreach ($laboratorios as $laboratorio) {
            Laboratorio::create($laboratorio);
        }
        
        echo "✅ Laboratorios creados\n";
    }

    /**
     * Crea exámenes médicos de prueba
     */
    private function createExamenesMedicos(): void
    {
        echo "🔬 Creando exámenes médicos...\n";
        
        $examenes = [
            [
                'nombre' => 'Hemograma Completo',
                'descripcion' => 'Análisis de sangre completo',
                'tipo' => 'sangre'
            ],
            [
                'nombre' => 'Radiografía de Tórax',
                'descripcion' => 'Imagen del tórax',
                'tipo' => 'imagen'
            ],
            [
                'nombre' => 'Electrocardiograma',
                'descripcion' => 'Registro de actividad cardíaca',
                'tipo' => 'especializado'
            ]
        ];
        
        foreach ($examenes as $examen) {
            ExamenMedico::create($examen);
        }
        
        echo "✅ Exámenes médicos creados\n";
    }

    /**
     * Crea órdenes de examen de prueba
     */
    private function createOrdenesExamenes(): void
    {
        echo "📋 Creando órdenes de examen...\n";
        
        $ordenes = [
            [
                'consulta_medica_id' => 1,
                'examen_medico_id' => 1,
                'laboratorio_id' => 1,
                'fecha_orden' => '2025-01-15',
                'estado' => 'Pendiente'
            ],
            [
                'consulta_medica_id' => 2,
                'examen_medico_id' => 3,
                'laboratorio_id' => 2,
                'fecha_orden' => '2025-01-16',
                'estado' => 'Pendiente'
            ],
            [
                'consulta_medica_id' => 3,
                'examen_medico_id' => 2,
                'laboratorio_id' => 3,
                'fecha_orden' => '2025-01-17',
                'estado' => 'Pendiente'
            ]
        ];
        
        foreach ($ordenes as $orden) {
            OrdenExamen::create($orden);
        }
        
        echo "✅ Órdenes de examen creadas\n";
    }

    /**
     * Crea facturas de prueba
     */
    private function createFacturas(): void
    {
        echo "💰 Creando facturas...\n";
        
        $facturas = [
            [
                'paciente_id' => 1,
                'cita_id' => 1,
                'monto_total' => 50000,
                'fecha_emision' => '2025-01-15',
                'estado' => 'pagada'
            ],
            [
                'paciente_id' => 2,
                'cita_id' => 2,
                'monto_total' => 75000,
                'fecha_emision' => '2025-01-16',
                'estado' => 'pendiente'
            ],
            [
                'paciente_id' => 3,
                'cita_id' => 3,
                'monto_total' => 60000,
                'fecha_emision' => '2025-01-17',
                'estado' => 'pendiente'
            ]
        ];
        
        foreach ($facturas as $factura) {
            Factura::create($factura);
        }
        
        echo "✅ Facturas creadas\n";
    }

    /**
     * Crea pagos de prueba
     */
    private function createPagos(): void
    {
        echo "💳 Creando pagos...\n";
        
        $pagos = [
            [
                'factura_id' => 1,
                'monto' => 50000,
                'fecha_pago' => '2025-01-15',
                'metodo_pago' => 'tarjeta'
            ],
            [
                'factura_id' => 2,
                'monto' => 75000,
                'fecha_pago' => '2025-01-16',
                'metodo_pago' => 'Efectivo'
            ],
            [
                'factura_id' => 3,
                'monto' => 60000,
                'fecha_pago' => '2025-01-17',
                'metodo_pago' => 'transferencia'
            ]
        ];
        
        foreach ($pagos as $pago) {
            Pago::create($pago);
        }
        
        echo "✅ Pagos creados\n";
    }

    /**
     * Crea horarios de prueba
     */
    private function createHorarios(): void
    {
        echo "⏰ Creando horarios...\n";
        
        $horarios = [
            [
                'medico_id' => 1,
                'consultorio_id' => 1,
                'dia_semana' => 'lunes',
                'hora_inicio' => '08:00:00',
                'hora_fin' => '12:00:00'
            ],
            [
                'medico_id' => 2,
                'consultorio_id' => 2,
                'dia_semana' => 'martes',
                'hora_inicio' => '09:00:00',
                'hora_fin' => '13:00:00'
            ],
            [
                'medico_id' => 3,
                'consultorio_id' => 3,
                'dia_semana' => 'miercoles',
                'hora_inicio' => '10:00:00',
                'hora_fin' => '14:00:00'
            ]
        ];
        
        foreach ($horarios as $horario) {
            Horario::create($horario);
        }
        
        echo "✅ Horarios creados\n";
    }
}
