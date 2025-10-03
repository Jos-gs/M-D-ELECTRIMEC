<?php
// procesar_cotizacion.php

$csvFile = 'cotizaciones.csv';

// Recoger los datos del formulario
$nombres = trim($_POST['nombre'] ?? 'N/A');
$apellidos = trim($_POST['apellido'] ?? 'N/A');
$empresa = trim($_POST['empresa'] ?? 'N/A');
$email = trim($_POST['email'] ?? 'N/A');
$mensaje = trim($_POST['mensaje'] ?? 'N/A');
$fecha = date('Y-m-d H:i:s');

$data = [$fecha, $nombres, $apellidos, $empresa, $email, $mensaje];

// Crear el archivo con cabecera si no existe
if (!file_exists($csvFile)) {
    $header = ['Fecha', 'Nombres', 'Apellidos', 'Empresa', 'Email', 'Mensaje'];
    $file = fopen($csvFile, 'w');
    // Escribir cabecera con punto y coma
    fputcsv($file, $header, ';');
    fclose($file);
}

// Abrir y añadir la nueva fila de datos
$file = fopen($csvFile, 'a');
// **LA CORRECIÓN CLAVE ESTÁ AQUÍ: Añadir el punto y coma (';')**
fputcsv($file, $data, ';');
fclose($file);

// Redirigir al usuario
header('Location: index.php?status=success#contacto');
exit();
?>