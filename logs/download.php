<?php
// download.php
session_start();
// Asume que config.php está en el mismo directorio (/logs)
require __DIR__ . '/config.php';

// Proteger la descarga si el usuario no está autenticado
if (empty($_SESSION['auth'])) { die('Acceso denegado. Por favor, inicie sesión.'); }

$fileName = $_GET['f'] ?? '';

// ====================================================================
// CORRECCIÓN DE RUTA CRÍTICA: panel.php y download.php están en /logs,
// y /docs está un nivel arriba.
// ====================================================================
$baseDir = __DIR__ . '/../docs/';
// Usamos basename() para prevenir ataques de path traversal (ej: ../../../etc/passwd)
$filePath = $baseDir . basename($fileName);

// Validar que el archivo exista y no esté vacío
if (empty($fileName) || !file_exists($filePath)) {
    // Si falla, es útil saber dónde lo buscó para el diagnóstico
    die('Archivo no encontrado o ruta incorrecta. Se buscó en: ' . htmlspecialchars($filePath));
}

// Configurar encabezados para forzar la descarga del archivo CSV
header('Content-Description: File Transfer');
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));

// Leer el archivo y enviarlo al navegador
readfile($filePath);
exit;