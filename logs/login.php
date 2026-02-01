<?php
session_start();
require __DIR__ . '/config.php';

$user = trim($_POST['user'] ?? '');
$pass = $_POST['pass'] ?? '';

if ($user === APP_USER && password_verify($pass, APP_PASS_HASH)) {
  $_SESSION['auth'] = true;
  header('Location: /logs/panel.php'); exit;
}
header('Location: /logs/intranet.php?e=1'); exit;
