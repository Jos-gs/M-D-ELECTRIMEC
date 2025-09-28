<?php
// enviar_contacto.php — SMTP Gmail + JSON + fallback a logs
declare(strict_types=1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
mb_internal_encoding('UTF-8');
date_default_timezone_set('America/Lima');

header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
ini_set('display_errors','0');
error_reporting(E_ALL);

set_error_handler(function($s,$m,$f,$l){ jsonOut(false,'Error PHP',"$m @ $f:$l"); });
set_exception_handler(function($e){ jsonOut(false,'Excepción',$e->getMessage()); });

if ($_SERVER['REQUEST_METHOD'] !== 'POST') jsonOut(false,'Método no permitido','Usa POST.');
if (!empty($_POST['website'] ?? ''))       jsonOut(false,'Solicitud rechazada','Detección anti-bots.');

$nombre   = trim($_POST['nombre']   ?? '');
$empresa  = trim($_POST['empresa']  ?? '');
$correo   = trim($_POST['correo']   ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$asunto   = trim($_POST['asunto']   ?? '');
$mensaje  = trim($_POST['mensaje']  ?? '');
$consent  = isset($_POST['consent']);

$err=[];
if ($nombre==='' || mb_strlen($nombre)<2)       $err[]='Nombre inválido';
if (!filter_var($correo,FILTER_VALIDATE_EMAIL)) $err[]='Correo inválido';
if ($telefono==='' || mb_strlen($telefono)<6)    $err[]='Teléfono inválido';
if ($asunto==='' || mb_strlen($asunto)<3)        $err[]='Asunto inválido';
if ($mensaje==='' || mb_strlen($mensaje)<5)      $err[]='Mensaje inválido';
if (!$consent)                                   $err[]='Aceptar el consentimiento';
if ($err) jsonOut(false,'Validación',implode('. ',$err).'.');

// ===== Config =====
$TO         = 'gonsianjoss@gmail.com';                  // destinatario
$SMTP_USER  = 'gonsianjoss@gmail.com';                  // tu Gmail
$SMTP_PASS  = 'zgginrzayqffvnaw';          // 16 caracteres (App Password)
$FROM_EMAIL = $SMTP_USER;                               // remitente visible
$FROM_NAME  = 'M&D ELECTRIMEC';
$SUBJECT    = 'Contacto web: '.$asunto;

// ===== Cuerpo =====
$bodyTxt = "Nuevo mensaje desde el formulario

Nombre:   {$nombre}
Empresa:  {$empresa}
Correo:   {$correo}
Teléfono: {$telefono}
Asunto:   {$asunto}

Mensaje:
{$mensaje}

IP: ".($_SERVER['REMOTE_ADDR'] ?? 'N/D')."
Fecha: ".date('Y-m-d H:i:s')."
";

// ===== Envío =====
$ok = false;
  require __DIR__.'/vendor/autoload.php';
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
try{
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host       = 'smtp.gmail.com';
  $mail->SMTPAuth   = true;
  $mail->Username   = $SMTP_USER;
  $mail->Password   = $SMTP_PASS; // contraseña de aplicación
  $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port       = 587;

  $mail->setFrom($FROM_EMAIL, $FROM_NAME);
  $mail->addAddress($TO);
  $mail->addReplyTo($correo, $nombre);

  $mail->Subject = $SUBJECT;
  $mail->Body    = $bodyTxt;
  $mail->AltBody = $bodyTxt;

  $ok = $mail->send();
} catch (Throwable $e) {
  // Sin PHPMailer instalado o error -> intentar mail() (puede fallar en muchos hostings)
  $headers  = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
  $headers .= "From: {$FROM_NAME} <{$FROM_EMAIL}>\r\n";
  $headers .= "Reply-To: {$correo}\r\n";
  $ok = @mail($TO, '=?UTF-8?B?'.base64_encode($SUBJECT).'?=', $bodyTxt, $headers);
}

// Fallback a logs y respuesta amable para el usuario
if (!$ok) {
  $dir = __DIR__.'/logs';
  if (!is_dir($dir)) @mkdir($dir, 0775, true);
  $file = $dir.'/contacto-'.date('Ymd').'.csv';
  $row  = [date('Y-m-d H:i:s'),$nombre,$empresa,$correo,$telefono,$asunto,preg_replace('/\s+/',' ',$mensaje),$_SERVER['REMOTE_ADDR'] ?? ''];
  @file_put_contents($file, implode(';', array_map('esc',$row)).PHP_EOL, FILE_APPEND);
  jsonOut(true,'Mensaje registrado','Gracias. Te contactaremos pronto.');
}

// OK
jsonOut(true,'Mensaje enviado','Gracias. Te contactaremos pronto.');

// ===== Helpers =====
function jsonOut(bool $ok,string $title,string $message): void{
  http_response_code($ok?200:422);
  echo json_encode(['ok'=>$ok,'title'=>$title,'message'=>$message], JSON_UNESCAPED_UNICODE);
  exit;
}
function esc(string $s): string{
  $s = str_replace(["\r","\n"],' ',$s);
  return str_contains($s,';')||str_contains($s,'"') ? '"'.str_replace('"','""',$s).'"' : $s;
}
