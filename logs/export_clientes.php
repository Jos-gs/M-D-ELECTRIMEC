<?php
session_start();
require __DIR__ . '/config.php';
if (empty($_SESSION['auth'])) { http_response_code(403); exit('No autorizado'); }

/* Cargar y filtrar igual que en el panel */
$logsBase = realpath(LOGS_DIR) ?: LOGS_DIR;
$files = glob(rtrim($logsBase,'/\\') . '/contacto-*.csv') ?: [];
rsort($files, SORT_NATURAL);

$rows = [];
foreach ($files as $f) {
  if (($h = fopen($f, 'r')) !== false) {
    while (($d = fgetcsv($h, 0, ';')) !== false) {
      if (count($d) >= 8) $rows[] = $d;
    }
    fclose($h);
  }
}
$q = trim($_GET['q'] ?? '');
if ($q !== '') {
  $qnorm = mb_strtolower($q, 'UTF-8');
  $rows = array_values(array_filter($rows, function($r) use ($qnorm){
    return strpos(mb_strtolower(implode(' ',$r),'UTF-8'), $qnorm) !== false;
  }));
}
usort($rows, function($a,$b){ return strcmp($b[0]??'', $a[0]??''); });

/* Exportar como tabla HTML con cabecera Excel */
$filename = 'clientes-' . date('Ymd-His') . '.xls';
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');
echo "\xEF\xBB\xBF"; // BOM UTF-8

echo '<table border="1">';
echo '<thead><tr>
<th>Fecha</th><th>Nombre</th><th>Empresa</th><th>Correo</th>
<th>Teléfono</th><th>Asunto</th><th>Mensaje</th><th>IP</th>
</tr></thead><tbody>';

foreach ($rows as $r) {
  echo '<tr>';
  for ($i=0;$i<8;$i++){
    $v = htmlspecialchars($r[$i] ?? '', ENT_QUOTES, 'UTF-8');
    echo "<td>{$v}</td>";
  }
  echo '</tr>';
}
echo '</tbody></table>';
