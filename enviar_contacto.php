<?php
// enviar_contacto.php — Registra log y luego intenta enviar correo.
declare(strict_types=1);
mb_internal_encoding('UTF-8');
date_default_timezone_set('America/Lima');

header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	jsonOut(false, 'Método no permitido', 'Usa POST.');
}

if (!empty($_POST['website'] ?? '')) {
	jsonOut(false, 'Solicitud rechazada', 'Detección anti-bots.');
}

$nombre 	= trim($_POST['nombre'] 	?? '');
$empresa 	= trim($_POST['empresa'] 	?? '');
$correo 	= trim($_POST['correo'] 	?? '');
$telefono = trim($_POST['telefono'] ?? '');
$asunto 	= trim($_POST['asunto'] 	?? '');
$mensaje 	= trim($_POST['mensaje'] 	?? '');
$consent 	= isset($_POST['consent']);

$err = [];
if ($nombre === '' || mb_strlen($nombre) < 2) 	 	 $err[] = 'Nombre inválido';
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) 	 $err[] = 'Correo inválido';
if ($telefono === '' || mb_strlen($telefono) < 6) 	 $err[] = 'Teléfono inválido';
if ($asunto === '' || mb_strlen($asunto) < 3) 	 	 $err[] = 'Asunto inválido';
if ($mensaje === '' || mb_strlen($mensaje) < 5) 	 $err[] = 'Mensaje inválido';
if (!$consent) 	 	 	 	 	 	 	 	 	 	 $err[] = 'Aceptar el consentimiento';
if ($err) jsonOut(false, 'Validación', implode('. ', $err).'.');

// ====================================================================
// PASO 1: REGISTRAR LOG (Guarda en /docs, al lado de este script)
// ====================================================================

// *** RUTA CORREGIDA: Apunta a /docs al mismo nivel ***
$logDir = __DIR__ . '/docs'; 
if (!is_dir($logDir)) @mkdir($logDir, 0775, true);
$logFile = $logDir . '/contacto-' . date('Ymd') . '.csv';

$csvRow = [
	date('Y-m-d H:i:s'), $nombre, $empresa, $correo, $telefono, $asunto,
	preg_replace('/\s+/', ' ', $mensaje), 
	$_SERVER['REMOTE_ADDR'] ?? ''
];

$logSuccess = @file_put_contents($logFile, implode(';', array_map('esc', $csvRow)) . PHP_EOL, FILE_APPEND);

if ($logSuccess === false) {
    jsonOut(false, 'Error de Archivo', 'El servidor no pudo guardar el registro. Verifica los permisos (CHMOD 775/777) de la carpeta /docs.');
}


// ====================================================================
// PASO 2: INTENTAR ENVIAR CORREO
// ====================================================================

$TO 	 	 = 'myd.electricmec@gmail.com'; 
$FROM 	 = 'no-reply@' . ($_SERVER['SERVER_NAME'] ?? 'localhost');
$SUBJECT = 'Contacto web: ' . $asunto;
$USE_SMTP = false; 

$bodyTxt =
"Nuevo mensaje desde el formulario
Nombre: 	 {$nombre}
Empresa: 	{$empresa}
Correo: 	 {$correo}
Teléfono: {$telefono}
Asunto: 	 {$asunto}
Mensaje:
{$mensaje}
IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/D') . "
Fecha: " . date('Y-m-d H:i:s') . "
";

$mailOk = false;

if (!$USE_SMTP) {
	// ------- mail() nativo -------
	$headers 	= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
	$headers .= "From: M&D ELECTRICMEC <{$FROM}>\r\n";
	$headers .= "Reply-To: {$correo}\r\n";
	$mailOk = @mail($TO, '=?UTF-8?B?'.base64_encode($SUBJECT).'?=', $bodyTxt, $headers);
}

jsonOut(true, 'Mensaje enviado', 'Gracias. Te contactaremos pronto.');


/* ===== Helpers Corregidos para PHP 7/8 ===== */
function jsonOut(bool $ok, string $title, string $message): void {
	http_response_code($ok ? 200 : 422); 
	header('Content-Type: application/json; charset=UTF-8');
	echo json_encode(['ok'=>$ok,'title'=>$title,'message'=>$message], JSON_UNESCAPED_UNICODE);
	exit;
}

// Función esc compatible con PHP 7/8
function esc(string $s): string {
	$s = str_replace(["\r","\n"], ' ', $s);
	$needs_quotes = (strpos($s, ';') !== false) || (strpos($s, '"') !== false);
	return $needs_quotes ? '"'.str_replace('"','""',$s).'"' : $s;
}