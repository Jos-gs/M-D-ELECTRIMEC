<?php
session_start();
require __DIR__ . '/config.php';

if (empty($_SESSION['auth'])) {
    http_response_code(403);
    die(json_encode(['success' => false, 'message' => 'No autorizado']));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$tipo = $_POST['tipo'] ?? ''; // 'contacto' o 'cotizacion'
$fecha = $_POST['fecha'] ?? '';
$indice = intval($_POST['indice'] ?? -1);

if (empty($tipo) || empty($fecha) || $indice < 0) {
    http_response_code(400);
    die(json_encode(['success' => false, 'message' => 'Parámetros inválidos']));
}

header('Content-Type: application/json');

if ($tipo === 'contacto') {
    // Obtener los datos del registro a eliminar desde POST
    $datos_registro = json_decode($_POST['datos'] ?? '[]', true);
    
    if (empty($datos_registro) || count($datos_registro) < 8) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Datos del registro inválidos']));
    }
    
    // Eliminar de archivos CSV de contacto
    $logsBaseDirs = [
        __DIR__ . '/../docs',
        __DIR__
    ];
    
    $files_clientes = [];
    foreach ($logsBaseDirs as $dir) {
        $files_clientes = array_merge($files_clientes, glob(rtrim($dir,'/\\') . '/contacto-*.csv') ?: []);
    }
    $files_clientes = array_unique($files_clientes);
    rsort($files_clientes, SORT_NATURAL);
    
    $encontrado = false;
    foreach ($files_clientes as $file) {
        $rows = [];
        $file_handle = fopen($file, 'r');
        if ($file_handle !== false) {
            while (($data = fgetcsv($file_handle, 0, ';', '"', '\\')) !== false) {
                if (count($data) >= 8) {
                    // Comparar todos los campos para encontrar el registro exacto
                    $coincide = true;
                    for ($i = 0; $i < 8; $i++) {
                        if (($data[$i] ?? '') !== ($datos_registro[$i] ?? '')) {
                            $coincide = false;
                            break;
                        }
                    }
                    
                    if ($coincide && !$encontrado) {
                        $encontrado = true;
                        continue; // Saltar este registro
                    }
                    
                    $rows[] = $data;
                }
            }
            fclose($file_handle);
            
            if ($encontrado) {
                // Reescribir el archivo sin el registro eliminado
                $file_handle = fopen($file, 'w');
                if ($file_handle !== false) {
                    foreach ($rows as $row) {
                        fputcsv($file_handle, $row, ';', '"', '\\');
                    }
                    fclose($file_handle);
                    echo json_encode(['success' => true, 'message' => 'Registro eliminado correctamente']);
                    exit;
                }
            }
        }
    }
    
    if (!$encontrado) {
        http_response_code(404);
        die(json_encode(['success' => false, 'message' => 'Registro no encontrado']));
    }
    
} elseif ($tipo === 'cotizacion') {
    // Obtener los datos del registro a eliminar desde POST
    $datos_registro = json_decode($_POST['datos'] ?? '[]', true);
    
    if (empty($datos_registro)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'Datos del registro inválidos']));
    }
    
    // Eliminar de cotizaciones.csv
    $cotizaciones_file = __DIR__ . '/../cotizaciones.csv';
    
    if (!file_exists($cotizaciones_file)) {
        http_response_code(404);
        die(json_encode(['success' => false, 'message' => 'Archivo no encontrado']));
    }
    
    $rows = [];
    $file_handle = fopen($cotizaciones_file, 'r');
    if ($file_handle !== false) {
        $isHeader = true;
        $encontrado = false;
        while (($data = fgetcsv($file_handle, 0, ',', '"', '\\')) !== false) {
            if ($isHeader) {
                $isHeader = false;
                $rows[] = $data; // Mantener el encabezado
                continue;
            }
            
            // Comparar todos los campos para encontrar el registro exacto
            $coincide = true;
            $max_campos = min(count($data), count($datos_registro));
            for ($i = 0; $i < $max_campos; $i++) {
                if (($data[$i] ?? '') !== ($datos_registro[$i] ?? '')) {
                    $coincide = false;
                    break;
                }
            }
            
            if ($coincide && !$encontrado) {
                $encontrado = true;
                continue; // Saltar este registro
            }
            
            $rows[] = $data;
        }
        fclose($file_handle);
        
        if ($encontrado) {
            // Reescribir el archivo
            $file_handle = fopen($cotizaciones_file, 'w');
            if ($file_handle !== false) {
                foreach ($rows as $row) {
                    fputcsv($file_handle, $row, ',', '"', '\\');
                }
                fclose($file_handle);
                echo json_encode(['success' => true, 'message' => 'Registro eliminado correctamente']);
                exit;
            }
        } else {
            http_response_code(404);
            die(json_encode(['success' => false, 'message' => 'Registro no encontrado']));
        }
    }
    
    http_response_code(500);
    die(json_encode(['success' => false, 'message' => 'Error al procesar el archivo']));
} else {
    http_response_code(400);
    die(json_encode(['success' => false, 'message' => 'Tipo de registro inválido']));
}

