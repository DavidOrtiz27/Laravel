<?php
/**
 * Archivo de Testeo Completo para API EPS
 * Sistema de Citas Médicas
 * 
 * Este archivo prueba todos los endpoints de la API para verificar su funcionamiento
 */

class APITester {
    private $baseUrl = 'http://localhost:8000/api';
    private $testResults = [];
    
    public function __construct() {
        echo "🚀 Iniciando Testeo Completo de API EPS\n";
        echo "=====================================\n\n";
    }
    
    /**
     * Ejecuta una petición HTTP
     */
    private function makeRequest($method, $endpoint, $data = null, $headers = []) {
        $url = $this->baseUrl . $endpoint;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        if ($method === 'POST' || $method === 'PUT') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                $headers[] = 'Content-Type: application/json';
            }
        }
        
        if ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        }
        
        if ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return ['error' => $error, 'http_code' => 0];
        }
        

        
        return [
            'http_code' => $httpCode,
            'response' => $response,
            'data' => json_decode($response, true)
        ];
    }
    
    /**
     * Registra el resultado de una prueba
     */
    private function logTest($endpoint, $method, $expectedCode, $actualCode, $success, $notes = '') {
        $status = $success ? '✅' : '❌';
        $result = [
            'endpoint' => $endpoint,
            'method' => $method,
            'expected' => $expectedCode,
            'actual' => $actualCode,
            'success' => $success,
            'notes' => $notes
        ];
        
        $this->testResults[] = $result;
        
        echo sprintf(
            "%s %s %s - Esperado: %d, Obtenido: %d %s\n",
            $status,
            str_pad($method, 6),
            $endpoint,
            $expectedCode,
            $actualCode,
            $notes
        );
        
        return $success;
    }
    
    /**
     * Testea endpoints de Especialidades
     */
    public function testEspecialidades() {
        echo "\n🏥 Testeando Especialidades\n";
        echo "---------------------------\n";
        
        // GET - Listar especialidades
        $response = $this->makeRequest('GET', '/especialidades');
        $this->logTest('/especialidades', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar especialidades');
        
        // POST - Crear especialidad
        $especialidadData = [
            'nombre' => 'Cardiología ' . time()
        ];
        $response = $this->makeRequest('POST', '/especialidades', $especialidadData);
        $this->logTest('/especialidades', 'POST', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Crear especialidad');
        
        if ($response['http_code'] === 200 && isset($response['data']['id'])) {
            $especialidadId = $response['data']['id'];
            
            // GET - Obtener especialidad específica
            $response = $this->makeRequest('GET', "/especialidades/{$especialidadId}");
            $this->logTest("/especialidades/{$especialidadId}", 'GET', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Obtener especialidad');
            
            // PUT - Actualizar especialidad
            $updateData = ['nombre' => 'Cardiología Actualizada'];
            $response = $this->makeRequest('PUT', "/especialidades/{$especialidadId}", $updateData);
            $this->logTest("/especialidades/{$especialidadId}", 'PUT', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Actualizar especialidad');
            
            // DELETE - Eliminar especialidad
            $response = $this->makeRequest('DELETE', "/especialidades/{$especialidadId}");
            $this->logTest("/especialidades/{$especialidadId}", 'DELETE', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Eliminar especialidad');
        }
    }
    
    /**
     * Testea endpoints de Ciudades
     */
    public function testCiudades() {
        echo "\n🏙️ Testeando Ciudades\n";
        echo "----------------------\n";
        
        // GET - Listar ciudades
        $response = $this->makeRequest('GET', '/ciudades');
        $this->logTest('/ciudades', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar ciudades');
        
        // POST - Crear ciudad
        $ciudadData = [
            'nombre' => 'Bogotá',
            'codigo' => 'BOG'
        ];
        $response = $this->makeRequest('POST', '/ciudades', $ciudadData);
        $this->logTest('/ciudades', 'POST', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Crear ciudad');
        
        if ($response['http_code'] === 200 && isset($response['data']['id'])) {
            $ciudadId = $response['data']['id'];
            
            // GET - Obtener ciudad específica
            $response = $this->makeRequest('GET', "/ciudades/{$ciudadId}");
            $this->logTest("/ciudades/{$ciudadId}", 'GET', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Obtener ciudad');
            
            // PUT - Actualizar ciudad
            $updateData = ['nombre' => 'Bogotá D.C.'];
            $response = $this->makeRequest('PUT', "/ciudades/{$ciudadId}", $updateData);
            $this->logTest("/ciudades/{$ciudadId}", 'PUT', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Actualizar ciudad');
            
            // DELETE - Eliminar ciudad
            $response = $this->makeRequest('DELETE', "/ciudades/{$ciudadId}");
            $this->logTest("/ciudades/{$ciudadId}", 'DELETE', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Eliminar ciudad');
        }
    }
    
    /**
     * Testea endpoints de Médicos
     */
    public function testMedicos() {
        echo "\n👨‍⚕️ Testeando Médicos\n";
        echo "----------------------\n";
        
        // GET - Listar médicos
        $response = $this->makeRequest('GET', '/medico');
        $this->logTest('/medico', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar médicos');
        
        // POST - Crear médico (requiere especialidad y ciudad existentes)
        $medicoData = [
            'nombre' => 'Dr. Juan Pérez',
            'documento' => (string)time(),
            'telefono' => '3001234567',
            'email' => 'juan.perez.' . time() . '@hospital.com',
            'especialidad_id' => 1,
            'ciudad_id' => 1
        ];
        $response = $this->makeRequest('POST', '/medico', $medicoData);
        $this->logTest('/medico', 'POST', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Crear médico');
        
        if ($response['http_code'] === 200 && isset($response['data']['id'])) {
            $medicoId = $response['data']['id'];
            
            // GET - Obtener médico específico
            $response = $this->makeRequest('GET', "/medico/{$medicoId}");
            $this->logTest("/medico/{$medicoId}", 'GET', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Obtener médico');
            
            // PUT - Actualizar médico
            $updateData = ['telefono' => '3009876543'];
            $response = $this->makeRequest('PUT', "/medico/{$medicoId}", $updateData);
            $this->logTest("/medico/{$medicoId}", 'PUT', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Actualizar médico');
            
            // DELETE - Eliminar médico
            $response = $this->makeRequest('DELETE', "/medico/{$medicoId}");
            $this->logTest("/medico/{$medicoId}", 'DELETE', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Eliminar médico');
        }
    }
    
    /**
     * Testea endpoints de Pacientes
     */
    public function testPacientes() {
        echo "\n👤 Testeando Pacientes\n";
        echo "------------------------\n";
        
        // GET - Listar pacientes
        $response = $this->makeRequest('GET', '/pacientes');
        $this->logTest('/pacientes', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar pacientes');
        
        // POST - Crear paciente
        $pacienteData = [
            'nombre' => 'María García',
            'documento' => '87654321',
            'telefono' => '3001112233',
            'email' => 'maria.garcia@email.com',
            'direccion' => 'Calle 123 #45-67',
            'ciudad_id' => 1
        ];
        $response = $this->makeRequest('POST', '/pacientes', $pacienteData);
        $this->logTest('/pacientes', 'POST', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Crear paciente');
        
        if ($response['http_code'] === 200 && isset($response['data']['id'])) {
            $pacienteId = $response['data']['id'];
            
            // GET - Obtener paciente específico
            $response = $this->makeRequest('GET', "/pacientes/{$pacienteId}");
            $this->logTest("/pacientes/{$pacienteId}", 'GET', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Obtener paciente');
            
            // PUT - Actualizar paciente
            $updateData = ['telefono' => '3004445566'];
            $response = $this->makeRequest('PUT', "/pacientes/{$pacienteId}", $updateData);
            $this->logTest("/pacientes/{$pacienteId}", 'PUT', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Actualizar paciente');
            
            // DELETE - Eliminar paciente
            $response = $this->makeRequest('DELETE', "/pacientes/{$pacienteId}");
            $this->logTest("/pacientes/{$pacienteId}", 'DELETE', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Eliminar paciente');
        }
    }
    
    /**
     * Testea endpoints de Citas
     */
    public function testCitas() {
        echo "\n📅 Testeando Citas\n";
        echo "--------------------\n";
        
        // GET - Listar citas
        $response = $this->makeRequest('GET', '/citas');
        $this->logTest('/citas', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar citas');
        
        // POST - Crear cita (requiere paciente, médico, especialidad y consultorio existentes)
        $citaData = [
            'paciente_id' => 1,
            'especialidad_id' => 1,
            'medico_id' => 1,
            'consultorio_id' => 1,
            'fecha' => '2025-01-15',
            'hora' => '14:30:00',
            'estado' => 'pendiente'
        ];
        $response = $this->makeRequest('POST', '/citas', $citaData);
        $this->logTest('/citas', 'POST', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Crear cita');
        
        if ($response['http_code'] === 200 && isset($response['data']['id'])) {
            $citaId = $response['data']['id'];
            
            // GET - Obtener cita específica
            $response = $this->makeRequest('GET', "/citas/{$citaId}");
            $this->logTest("/citas/{$citaId}", 'GET', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Obtener cita');
            
            // PUT - Actualizar cita
            $updateData = [
                'paciente_id' => 1,
                'especialidad_id' => 1,
                'medico_id' => 1,
                'consultorio_id' => 1,
                'estado' => 'confirmada'
            ];
            $response = $this->makeRequest('PUT', "/citas/{$citaId}", $updateData);
            $this->logTest("/citas/{$citaId}", 'PUT', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Actualizar cita');
            
            // DELETE - Eliminar cita
            $response = $this->makeRequest('DELETE', "/citas/{$citaId}");
            $this->logTest("/citas/{$citaId}", 'DELETE', 200, $response['http_code'], 
                $response['http_code'] === 200, 'Eliminar cita');
        }
    }
    
    /**
     * Testea endpoints de Reportes
     */
    public function testReportes() {
        echo "\n📊 Testeando Reportes\n";
        echo "----------------------\n";
        
        // GET - Citas por paciente
        $response = $this->makeRequest('GET', '/reportes/citas/1');
        $this->logTest('/reportes/citas/1', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Citas por paciente');
        
        // GET - Historial de paciente
        $response = $this->makeRequest('GET', '/reportes/historial/1');
        $this->logTest('/reportes/historial/1', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Historial de paciente');
        
        // GET - Recetas por consulta
        $response = $this->makeRequest('GET', '/reportes/recetas/1');
        $this->logTest('/reportes/recetas/1', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Recetas por consulta');
        
        // GET - Pagos por paciente
        $response = $this->makeRequest('GET', '/reportes/pagos/1');
        $this->logTest('/reportes/pagos/1', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Pagos por paciente');
        
        // GET - Pacientes por aseguradora
        $response = $this->makeRequest('GET', '/reportes/aseguradora/1/pacientes');
        $this->logTest('/reportes/aseguradora/1/pacientes', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Pacientes por aseguradora');
    }
    
    /**
     * Testea endpoints adicionales
     */
    public function testOtrosEndpoints() {
        echo "\n🔧 Testeando Otros Endpoints\n";
        echo "------------------------------\n";
        
        // Consultorios
        $response = $this->makeRequest('GET', '/consultorios');
        $this->logTest('/consultorios', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar consultorios');
        
        // Horarios
        $response = $this->makeRequest('GET', '/horarios');
        $this->logTest('/horarios', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar horarios');
        
        // Historias clínicas
        $response = $this->makeRequest('GET', '/historias-clinicas');
        $this->logTest('/historias-clinicas', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar historias clínicas');
        
        // Consultas médicas
        $response = $this->makeRequest('GET', '/consultas-medicas');
        $this->logTest('/consultas-medicas', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar consultas médicas');
        
        // Medicamentos
        $response = $this->makeRequest('GET', '/medicamentos');
        $this->logTest('/medicamentos', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar medicamentos');
        
        // Laboratorios
        $response = $this->makeRequest('GET', '/laboratorios');
        $this->logTest('/laboratorios', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar laboratorios');
        
        // Recetas médicas
        $response = $this->makeRequest('GET', '/recetas-medicas');
        $this->logTest('/recetas-medicas', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar recetas médicas');
        
        // Exámenes médicos
        $response = $this->makeRequest('GET', '/examenes-Medico');
        $this->logTest('/examenes-Medico', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar exámenes médicos');
        
        // Órdenes de examen
        $response = $this->makeRequest('GET', '/ordenes-examenes');
        $this->logTest('/ordenes-examenes', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar órdenes de examen');
        
        // Aseguradoras
        $response = $this->makeRequest('GET', '/aseguradoras');
        $this->logTest('/aseguradoras', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar aseguradoras');
        
        // Facturas
        $response = $this->makeRequest('GET', '/facturas');
        $this->logTest('/facturas', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar facturas');
        
        // Pagos
        $response = $this->makeRequest('GET', '/pagos');
        $this->logTest('/pagos', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar pagos');
        
        // Afiliaciones
        $response = $this->makeRequest('GET', '/afiliaciones');
        $this->logTest('/afiliaciones', 'GET', 200, $response['http_code'], 
            $response['http_code'] === 200, 'Listar afiliaciones');
    }
    
    /**
     * Ejecuta todas las pruebas
     */
    public function runAllTests() {
        $this->testEspecialidades();
        $this->testCiudades();
        $this->testMedicos();
        $this->testPacientes();
        $this->testCitas();
        $this->testReportes();
        $this->testOtrosEndpoints();
        
        $this->generateReport();
    }
    
    /**
     * Genera reporte final
     */
    private function generateReport() {
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "📋 REPORTE FINAL DE PRUEBAS\n";
        echo str_repeat("=", 60) . "\n";
        
        $totalTests = count($this->testResults);
        $successfulTests = count(array_filter($this->testResults, function($test) {
            return $test['success'];
        }));
        $failedTests = $totalTests - $successfulTests;
        
        echo "Total de pruebas: {$totalTests}\n";
        echo "✅ Exitosas: {$successfulTests}\n";
        echo "❌ Fallidas: {$failedTests}\n";
        echo "📊 Porcentaje de éxito: " . round(($successfulTests / $totalTests) * 100, 2) . "%\n\n";
        
        if ($failedTests > 0) {
            echo "🔍 PRUEBAS FALLIDAS:\n";
            echo str_repeat("-", 40) . "\n";
            foreach ($this->testResults as $test) {
                if (!$test['success']) {
                    echo "❌ {$test['method']} {$test['endpoint']} - Código: {$test['actual']}\n";
                }
            }
        }
        
        echo "\n🎯 RECOMENDACIONES:\n";
        echo str_repeat("-", 40) . "\n";
        if ($failedTests === 0) {
            echo "✅ ¡Excelente! Todos los endpoints están funcionando correctamente.\n";
        } else {
            echo "⚠️  Revisar los endpoints que fallaron para identificar problemas.\n";
            echo "🔧 Verificar que la base de datos tenga datos de prueba.\n";
            echo "📝 Revisar logs de Laravel para más detalles.\n";
        }
    }
}

// Ejecutar pruebas
if (php_sapi_name() === 'cli') {
    $tester = new APITester();
    $tester->runAllTests();
} else {
    echo "Este archivo debe ejecutarse desde la línea de comandos.\n";
    echo "Uso: php test_api_endpoints.php\n";
}
?>
