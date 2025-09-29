<?php
session_start();
// Asegúrate de que config.php exista en el mismo directorio (/logs)
require __DIR__ . '/config.php'; 
if (empty($_SESSION['auth'])) { header('Location: intranet.php'); exit; }

/* Compat PHP 7 */
if (!function_exists('str_starts_with')) {
	function str_starts_with($h,$n){ return strpos($h,$n)===0; }
}

// *** RUTAS CORREGIDAS: El padre es /, y el log está en /docs ***
$logsBaseDirs = [
    __DIR__ . '/../docs', // Carpeta /docs (Un nivel arriba del script)
    __DIR__ // Carpeta actual /logs (Para leer logs guardados anteriormente)
];

// Creamos la carpeta principal si no existe
if (!is_dir($logsBaseDirs[0])) @mkdir($logsBaseDirs[0], 0775, true);


/* Cargar CSV contacto-YYYYMMDD.csv desde ambas carpetas */
$files = [];
foreach ($logsBaseDirs as $dir) {
    $files = array_merge($files, glob(rtrim($dir,'/\\') . '/contacto-*.csv') ?: []);
}

// Filtramos duplicados si por error se guardó en ambas carpetas
$files = array_unique($files);
rsort($files, SORT_NATURAL); 

$rows = [];
// Bucle para CONSOLIDAR todos los registros de todos los archivos
foreach ($files as $f) {
	if (($h = fopen($f, 'r')) !== false) {
		// Separador punto y coma (;)
		while (($d = fgetcsv($h, 0, ';')) !== false) { 
			if (count($d) >= 8) $rows[] = $d; 
		}
		fclose($h);
	}
}

/* Filtros y lógica (sin cambios) */
$q = trim($_GET['q'] ?? '');
$filtered_rows = $rows; 
if ($q !== '') {
	$qnorm = mb_strtolower($q, 'UTF-8');
	$filtered_rows = array_values(array_filter($filtered_rows, function($r) use ($qnorm){
		return strpos(mb_strtolower(implode(' ', $r),'UTF-8'), $qnorm) !== false;
	}));
}

$fdate = trim($_GET['fdate'] ?? '');
if ($fdate !== '') {
	$filtered_rows = array_values(array_filter($filtered_rows, function($r) use ($fdate){
		return strpos($r[0]??'', $fdate) === 0; 
	}));
}

usort($filtered_rows, function($a,$b){ return strcmp($b[0]??'', $a[0]??''); });

$total = count($rows);
$hoy = date('Y-m-d'); $mes = date('Y-m');
$hoyCnt=0; $mesCnt=0; $uniq=[];
foreach($rows as $r){
	$f = substr($r[0],0,10);
	if ($f===$hoy) $hoyCnt++;
	if (substr($f,0,7)===$mes) $mesCnt++;
	if (!empty($r[3])) $uniq[strtolower($r[3])] = 1;
}
$uniqCnt = count($uniq);

$unique_dates = [];
foreach ($rows as $r) {
    if (!empty($r[0])) {
        $unique_dates[substr($r[0], 0, 10)] = 1;
    }
}
krsort($unique_dates); 

// Obtener solo los nombres de archivo en la ruta /docs (la ruta principal) para descargar
$downloadFiles = glob(rtrim($logsBaseDirs[0],'/\\') . '/contacto-*.csv') ?: [];
$file_names = array_map('basename', $downloadFiles);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Clientes — Intranet</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/panel.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.modal {
    display: none; position: fixed; z-index: 100; left: 0; top: 0; width: 100%; 
    height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);
}
.modal-content {
    background-color: #fefefe; margin: 10% auto; padding: 20px; border: 1px solid #888;
    width: 90%; max-width: 400px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}
.close {
    color: #aaa; float: right; font-size: 28px; font-weight: bold;
}
.close:hover, .close:focus {
    color: #000; text-decoration: none; cursor: pointer;
}
.modal-content h2 { color: var(--primary-color, #003366); font-family: var(--font-heading, 'Montserrat'); margin-top: 0; }
.file-list a { 
    display: flex; align-items: center; gap: 8px; padding: 8px 0; border-bottom: 1px solid #eee; 
    text-decoration: none; color: #003366; transition: color 0.2s;
}
.file-list a:hover { color: #FF6600; }
</style>

</head>
<body>
<div class="c-wrap container">
	<div class="c-top">
		<div>
			<h1 class="c-title">Clientes</h1>
			<p class="c-sub">Consolidado de registros del formulario.</p>
		</div>
		<div class="c-act">
			<form class="c-search" method="get">
				<i class="fa-solid fa-magnifying-glass"></i>
				<input type="search" name="q" placeholder="Buscar nombre, empresa, correo…" value="<?= htmlspecialchars($q,ENT_QUOTES,'UTF-8') ?>">
				<?php if ($q!=='' || $fdate!==''): ?><a class="btn-clean" href="panel.php">Limpiar</a><?php endif; ?>
			</form>
            <a class="btn-primary" href="export_clientes.php<?= $q!==''?('?q='.urlencode($q)) : '' ?>"><i class="fa-solid fa-file-excel"></i> Descargar Excel</a>
			<button class="btn-secondary" onclick="document.getElementById('filesModal').style.display='block';"><i class="fa-solid fa-folder-open"></i> Archivos</button>
			<a class="btn-secondary" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
		</div>
	</div>

	<div class="c-kpis">
		<div class="kpi">
			<div class="kpi-ico k1"><i class="fa-solid fa-users"></i></div>
			<div class="kpi-body"><span class="kpi-label">Total</span><span class="kpi-num"><?= number_format($total) ?></span></div>
		</div>
		<div class="kpi">
			<div class="kpi-ico k2"><i class="fa-solid fa-calendar-day"></i></div>
			<div class="kpi-body"><span class="kpi-label">Hoy</span><span class="kpi-num"><?= $hoyCnt ?></span></div>
		</div>
		<div class="kpi">
			<div class="kpi-ico k3"><i class="fa-solid fa-calendar"></i></div>
			<div class="kpi-body"><span class="kpi-label">Este mes</span><span class="kpi-num"><?= $mesCnt ?></span></div>
		</div>
		<div class="kpi">
			<div class="kpi-ico k4"><i class="fa-solid fa-envelope"></i></div>
			<div class="kpi-body"><span class="kpi-label">Correos únicos</span><span class="kpi-num"><?= $uniqCnt ?></span></div>
		</div>
	</div>

    <div class="c-filter-date">
        <form method="get" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
            <label for="fdate">Filtrar por Fecha:</label>
            <select name="fdate" id="fdate" onchange="this.form.submit()" style="padding: 8px; border-radius: 6px; border: 1px solid #ccc;">
                <option value="">-- Todas las Fechas --</option>
                <?php foreach($unique_dates as $date => $val): ?>
                    <option value="<?= htmlspecialchars($date) ?>" <?= $date === $fdate ? 'selected' : '' ?>>
                        <?= htmlspecialchars($date) ?> (<?= date('d/M', strtotime($date)) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ($fdate !== ''): ?>
                <a href="panel.php<?= $q!==''?('?q='.urlencode($q)) : '' ?>" class="btn-clean" style="padding: 5px 10px;">Limpiar Filtro</a>
            <?php endif; ?>
            <?php if ($q !== ''): /* Mantiene el filtro de búsqueda si existe */ ?>
                <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
            <?php endif; ?>
        </form>
    </div>

    <div class="c-tablewrap">
        <table class="c-table">
            <thead>
                <tr>
                    <th>Fecha</th><th>Nombre</th><th>Empresa</th><th>Correo</th>
                    <th>Teléfono</th><th>Asunto</th><th>Mensaje</th><th>IP</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($filtered_rows)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px; color: #888;">No hay registros disponibles con los filtros actuales.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($filtered_rows as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r[0]??'',ENT_QUOTES,'UTF-8') ?></td>
                        <td><?= htmlspecialchars($r[1]??'',ENT_QUOTES,'UTF-8') ?></td>
                        <td><span class="chip"><?= htmlspecialchars($r[2]??'',ENT_QUOTES,'UTF-8') ?></span></td>
                        <td><a class="mail" href="mailto:<?= htmlspecialchars($r[3]??'',ENT_QUOTES,'UTF-8') ?>"><?= htmlspecialchars($r[3]??'',ENT_QUOTES,'UTF-8') ?></a></td>
                        <td><?= htmlspecialchars($r[4]??'',ENT_QUOTES,'UTF-8') ?></td>
                        <td><?= htmlspecialchars($r[5]??'',ENT_QUOTES,'UTF-8') ?></td>
                        <td class="msg" title="<?= htmlspecialchars($r[6]??'',ENT_QUOTES,'UTF-8') ?>"><?= htmlspecialchars($r[6]??'',ENT_QUOTES,'UTF-8') ?></td>
                        <td><?= htmlspecialchars($r[7]??'',ENT_QUOTES,'UTF-8') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if (empty($rows) && empty($filtered_rows)): ?>
        <div class="c-empty" style="margin-top: 16px;">
            <div class="ico">📭</div>
            <p>No se encontraron archivos CSV en las carpetas <code>/docs</code> o <code>/logs</code> o no se pudieron leer.</p>
            <p><a class="btn-primary" href="../contacto.php">Crear un registro</a></p>
        </div>
    <?php endif; ?>
    
	<footer class="c-foot">Intranet M&D ELECTRIMEC</footer>
</div>

<div id="filesModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('filesModal').style.display='none'">×</span>
        <h2><i class="fa-solid fa-folder-open"></i> Archivos CSV</h2>
        <p>Seleccione un archivo para descargarlo. Los logs se encuentran en la carpeta <code>/docs</code>.</p>
        <div class="file-list">
            <?php if (empty($file_names)): ?>
                <p>No se encontraron archivos CSV en la carpeta /docs.</p>
            <?php else: ?>
                <p>⚠️ Asegúrate de tener el archivo <code>download.php</code> para descargar.</p>
                <?php foreach($file_names as $file): ?>
                    <a href="download.php?f=<?= urlencode($file) ?>"><i class="fa-solid fa-file-csv"></i> <?= htmlspecialchars($file) ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Cierra el modal si el usuario hace clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById('filesModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>