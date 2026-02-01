<?php
session_start();
// Asegúrate de que config.php exista en el mismo directorio (/logs)
require __DIR__ . '/config.php'; 
if (empty($_SESSION['auth'])) { header('Location: /logs/intranet.php'); exit; }

/* ==========================================================================
   CARGA DE DATOS PARA LA PRIMERA TABLA ("CLIENTES")
   ========================================================================== */
$logsBaseDirs = [
    __DIR__ . '/../docs', // Carpeta /docs (Un nivel arriba del script)
    __DIR__ // Carpeta actual /logs (Para leer logs guardados anteriormente)
];
if (!is_dir($logsBaseDirs[0])) @mkdir($logsBaseDirs[0], 0775, true);

$files_clientes = [];
foreach ($logsBaseDirs as $dir) {
    $files_clientes = array_merge($files_clientes, glob(rtrim($dir,'/\\') . '/contacto-*.csv') ?: []);
}
$files_clientes = array_unique($files_clientes);
rsort($files_clientes, SORT_NATURAL); 

$rows_clientes = [];
foreach ($files_clientes as $f) {
    if (($h = fopen($f, 'r')) !== false) {
        while (($d = fgetcsv($h, 0, ';', '"', '\\')) !== false) { 
            if (count($d) >= 8) $rows_clientes[] = $d; 
        }
        fclose($h);
    }
}

/* Filtros y lógica para "CLIENTES" */
$q = trim($_GET['q'] ?? '');
$filtered_clientes = $rows_clientes; 
if ($q !== '') {
    // Usar mb_strtolower si está disponible, sino usar strtolower
    $qnorm = function_exists('mb_strtolower') ? mb_strtolower($q, 'UTF-8') : strtolower($q);
    $filtered_clientes = array_values(array_filter($filtered_clientes, function($r) use ($qnorm){
        $text = implode(' ', $r);
        $textLower = function_exists('mb_strtolower') ? mb_strtolower($text, 'UTF-8') : strtolower($text);
        return strpos($textLower, $qnorm) !== false;
    }));
}
$fdate = trim($_GET['fdate'] ?? '');
if ($fdate !== '') {
    $filtered_clientes = array_values(array_filter($filtered_clientes, function($r) use ($fdate){
        return strpos($r[0]??'', $fdate) === 0; 
    }));
}
usort($filtered_clientes, function($a,$b){ return strcmp($b[0]??'', $a[0]??''); });

/* KPIs para "CLIENTES" */
$total = count($rows_clientes);
$hoy = date('Y-m-d'); $mes = date('Y-m');
$hoyCnt=0; $mesCnt=0; $uniq=[];
foreach($rows_clientes as $r){
    $f = substr($r[0],0,10);
    if ($f===$hoy) $hoyCnt++;
    if (substr($f,0,7)===$mes) $mesCnt++;
    if (!empty($r[3])) $uniq[strtolower($r[3])] = 1;
}
$uniqCnt = count($uniq);
$unique_dates = [];
foreach ($rows_clientes as $r) {
    if (!empty($r[0])) {
        $unique_dates[substr($r[0], 0, 10)] = 1;
    }
}
krsort($unique_dates);
$downloadFiles = glob(rtrim($logsBaseDirs[0],'/\\') . '/contacto-*.csv') ?: [];
$file_names = array_map('basename', $downloadFiles);


/* ==========================================================================
   NUEVO: CARGA DE DATOS PARA LA SEGUNDA TABLA ("COTIZACIONES")
   ========================================================================== */
$cotizaciones_file = __DIR__ . '/../cotizaciones.csv'; // Ruta al archivo de cotizaciones
$rows_cotizaciones = [];
if (file_exists($cotizaciones_file) && ($handle = fopen($cotizaciones_file, 'r')) !== false) {
    $isHeader = true; // Para saltar la primera fila (cabecera)
    while (($data = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
        if ($isHeader) {
            $isHeader = false;
            continue;
        }
        $rows_cotizaciones[] = $data;
    }
    fclose($handle);
}
// Ordenar cotizaciones por fecha (la más reciente primero)
usort($rows_cotizaciones, function($a, $b) {
    return strcmp($b[0] ?? '', $a[0] ?? '');
});

$contador_file = __DIR__ . '/../contador_visitas.txt';
$conteo_actual = file_exists($contador_file) ? (int)file_get_contents($contador_file) : 0;

/* ==========================================================================
   ESTADÍSTICAS PARA EL DASHBOARD
   ========================================================================== */

// Registros por día (últimos 30 días)
$registros_por_dia = [];
$fecha_limite = date('Y-m-d', strtotime('-30 days'));
for ($i = 0; $i < 30; $i++) {
    $fecha = date('Y-m-d', strtotime("-$i days"));
    $registros_por_dia[$fecha] = 0;
}
foreach ($rows_clientes as $r) {
    $fecha = substr($r[0] ?? '', 0, 10);
    if ($fecha >= $fecha_limite && isset($registros_por_dia[$fecha])) {
        $registros_por_dia[$fecha]++;
    }
}
$registros_por_dia = array_reverse($registros_por_dia);

// Registros por hora del día
$registros_por_hora = array_fill(0, 24, 0);
foreach ($rows_clientes as $r) {
    if (!empty($r[0])) {
        $hora = (int)substr($r[0], 11, 2);
        if ($hora >= 0 && $hora < 24) {
            $registros_por_hora[$hora]++;
        }
    }
}

// Top empresas (más contactos)
$empresas_count = [];
foreach ($rows_clientes as $r) {
    $empresa = trim($r[2] ?? '');
    if (!empty($empresa)) {
        $empresas_count[$empresa] = ($empresas_count[$empresa] ?? 0) + 1;
    }
}
arsort($empresas_count);
$top_empresas = array_slice($empresas_count, 0, 10, true);

// Registros por mes (últimos 12 meses)
$registros_por_mes = [];
for ($i = 0; $i < 12; $i++) {
    $mes = date('Y-m', strtotime("-$i months"));
    $registros_por_mes[$mes] = 0;
}
foreach ($rows_clientes as $r) {
    $fecha = substr($r[0] ?? '', 0, 10);
    $mes = substr($fecha, 0, 7);
    if (isset($registros_por_mes[$mes])) {
        $registros_por_mes[$mes]++;
    }
}
$registros_por_mes = array_reverse($registros_por_mes);

// Estadísticas de cotizaciones
$cotizaciones_hoy = 0;
$cotizaciones_mes = 0;
$hoy_cot = date('Y-m-d');
$mes_cot = date('Y-m');
foreach ($rows_cotizaciones as $cot) {
    $fecha_cot = substr($cot[0] ?? '', 0, 10);
    if ($fecha_cot === $hoy_cot) $cotizaciones_hoy++;
    if (substr($fecha_cot, 0, 7) === $mes_cot) $cotizaciones_mes++;
}

// Tasa de conversión (cotizaciones / contactos)
$tasa_conversion = $mesCnt > 0 ? round(($cotizaciones_mes / $mesCnt) * 100, 1) : 0;
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
<title>Clientes — Intranet</title>
<base href="/logs/">
<link rel="icon" href="/images/logo.png" type="image/png">
<link rel="shortcut icon" href="/images/logo.png" type="image/png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/logs/css/panel.css?v=<?= time() ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
<div class="c-wrap container" style="max-width: 100%; width: 100%; padding: 20px; box-sizing: border-box;">
    <div class="c-top">
        <div>
            <h1 class="c-title">Clientes</h1>
            <p class="c-sub">Consolidado de registros del formulario.</p>
        </div>
        <div class="c-act">
            <form class="c-search" method="get">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="q" placeholder="Buscar nombre, empresa, correo…" value="<?= htmlspecialchars($q,ENT_QUOTES,'UTF-8') ?>">
                <?php if ($q!=='' || $fdate!==''): ?><a class="btn-clean" href="/logs/panel.php">Limpiar</a><?php endif; ?>
            </form>
            <a class="btn-primary" href="/logs/export_clientes.php<?= $q!==''?('?q='.urlencode($q)) : '' ?>"><i class="fa-solid fa-file-excel"></i> Descargar Excel</a>
            <button class="btn-secondary" onclick="document.getElementById('filesModal').style.display='block';"><i class="fa-solid fa-folder-open"></i> Archivos</button>
            <a class="btn-secondary" href="/logs/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        </div>
    </div>
    <div class="c-kpis">
        <div class="kpi"><div class="kpi-ico k1"><i class="fa-solid fa-users"></i></div><div class="kpi-body"><span class="kpi-label">Total</span><span class="kpi-num"><?= number_format($total) ?></span></div></div>
        <div class="kpi"><div class="kpi-ico k2"><i class="fa-solid fa-calendar-day"></i></div><div class="kpi-body"><span class="kpi-label">Hoy</span><span class="kpi-num"><?= $hoyCnt ?></span></div></div>
        <div class="kpi"><div class="kpi-ico k3"><i class="fa-solid fa-calendar"></i></div><div class="kpi-body"><span class="kpi-label">Este mes</span><span class="kpi-num"><?= $mesCnt ?></span></div></div>
        <div class="kpi"><div class="kpi-ico k4"><i class="fa-solid fa-envelope"></i></div><div class="kpi-body"><span class="kpi-label">Correos únicos</span><span class="kpi-num"><?= $uniqCnt ?></span></div></div>
        <div class="kpi"><div class="kpi-ico k5"><i class="fa-solid fa-eye"></i></div><div class="kpi-body"><span class="kpi-label">Visitas totales</span><span class="kpi-num"><?= number_format($conteo_actual) ?></span></div></div>
    </div>

    <!-- Dashboard de Análisis -->
    <div class="dashboard-section">
        <div class="dashboard-header">
            <h2><i class="fa-solid fa-chart-line"></i> Análisis de Datos</h2>
            <p>Visualización y estadísticas de los registros de contacto y cotizaciones</p>
        </div>

        <div class="dashboard-grid">
            <!-- Gráfico de Registros por Día (últimos 30 días) -->
            <div class="dashboard-card">
                <h3><i class="fa-solid fa-chart-line"></i> Registros por Día (30 días)</h3>
                <div class="chart-container">
                    <canvas id="chartRegistrosDia" data-chart='<?= json_encode($registros_por_dia, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'></canvas>
                </div>
            </div>

            <!-- Gráfico de Registros por Hora -->
            <div class="dashboard-card">
                <h3><i class="fa-solid fa-clock"></i> Registros por Hora del Día</h3>
                <div class="chart-container">
                    <canvas id="chartRegistrosHora" data-chart='<?= json_encode($registros_por_hora, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'></canvas>
                </div>
            </div>

            <!-- Gráfico de Registros por Mes -->
            <div class="dashboard-card">
                <h3><i class="fa-solid fa-calendar-alt"></i> Registros por Mes (12 meses)</h3>
                <div class="chart-container chart-container-large">
                    <canvas id="chartRegistrosMes" data-chart='<?= json_encode($registros_por_mes, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'></canvas>
                </div>
            </div>

            <!-- Top Empresas -->
            <div class="dashboard-card">
                <h3><i class="fa-solid fa-building"></i> Top 10 Empresas</h3>
                <?php if (empty($top_empresas)): ?>
                    <p style="color: #888; text-align: center; padding: 20px;">No hay datos de empresas disponibles.</p>
                <?php else: ?>
                    <ul class="top-empresas-list">
                        <?php foreach($top_empresas as $empresa => $count): ?>
                            <li>
                                <span class="empresa-nombre"><?= htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="empresa-count"><?= $count ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <canvas id="chartTopEmpresas" data-chart='<?= json_encode($top_empresas, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>' style="display: none;"></canvas>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comparación de Estadísticas -->
        <div class="dashboard-card" style="margin-top: 2rem;">
            <h3><i class="fa-solid fa-balance-scale"></i> Comparación de Métricas</h3>
            <div class="stats-comparison">
                <div class="stat-comparison-item">
                    <div class="stat-value"><?= number_format($total) ?></div>
                    <div class="stat-label">Total Contactos</div>
                </div>
                <div class="stat-comparison-item">
                    <div class="stat-value"><?= count($rows_cotizaciones) ?></div>
                    <div class="stat-label">Total Cotizaciones</div>
                </div>
                <div class="stat-comparison-item">
                    <div class="stat-value"><?= $mesCnt ?></div>
                    <div class="stat-label">Contactos Este Mes</div>
                </div>
                <div class="stat-comparison-item">
                    <div class="stat-value"><?= $cotizaciones_mes ?></div>
                    <div class="stat-label">Cotizaciones Este Mes</div>
                </div>
                <div class="stat-comparison-item">
                    <div class="stat-value"><?= $tasa_conversion ?>%</div>
                    <div class="stat-label">Tasa de Conversión</div>
                </div>
                <div class="stat-comparison-item">
                    <div class="stat-value"><?= number_format($conteo_actual) ?></div>
                    <div class="stat-label">Visitas Totales</div>
                </div>
            </div>
        </div>
    </div>
    <div class="c-filter-date">
        <form method="get" class="filter-form">
            <label for="fdate">Filtrar por Fecha:</label>
            <select name="fdate" id="fdate" onchange="this.form.submit()">
                <option value="">-- Todas las Fechas --</option>
                <?php foreach($unique_dates as $date => $val): ?>
                    <option value="<?= htmlspecialchars($date) ?>" <?= $date === $fdate ? 'selected' : '' ?>><?= htmlspecialchars($date) ?> (<?= date('d/M', strtotime($date)) ?>)</option>
                <?php endforeach; ?>
            </select>
            <?php if ($fdate !== ''): ?><a href="/logs/panel.php<?= $q!==''?('?q='.urlencode($q)) : '' ?>" class="btn-clean">Limpiar Filtro</a><?php endif; ?>
            <?php if ($q !== ''): ?><input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>"><?php endif; ?>
        </form>
    </div>
    <div class="c-tablewrap">
        <div class="table-header-inline">
            <h3>Registros de Contacto</h3>
            <span class="stat-badge">Mostrando: <strong><?= count($filtered_clientes) ?></strong> de <?= number_format($total) ?></span>
        </div>
        <table class="c-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($filtered_clientes)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 20px; color: #888;">No hay registros de clientes.</td></tr>
                <?php else: ?>
                    <?php foreach($filtered_clientes as $idx => $r): ?>
                    <tr data-tipo="contacto" data-fecha="<?= htmlspecialchars(substr($r[0]??'', 0, 10), ENT_QUOTES, 'UTF-8') ?>" data-indice="<?= $idx ?>">
                        <td><?= htmlspecialchars($r[0]??'',ENT_QUOTES,'UTF-8') ?></td>
                        <td><?= htmlspecialchars($r[1]??'',ENT_QUOTES,'UTF-8') ?></td>
                        <td><span class="chip"><?= htmlspecialchars($r[2]??'',ENT_QUOTES,'UTF-8') ?: '-' ?></span></td>
                        <td><a class="mail" href="mailto:<?= htmlspecialchars($r[3]??'',ENT_QUOTES,'UTF-8') ?>"><?= htmlspecialchars($r[3]??'',ENT_QUOTES,'UTF-8') ?></a></td>
                        <td><?= htmlspecialchars($r[4]??'',ENT_QUOTES,'UTF-8') ?></td>
                        <td class="acciones">
                            <button class="btn-ver" data-tipo="contacto" data-indice="<?= $idx ?>" data-datos='<?= htmlspecialchars(json_encode($r, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                <i class="fa-solid fa-eye"></i> Ver
                            </button>
                            <button class="btn-eliminar" data-tipo="contacto" data-fecha="<?= htmlspecialchars(substr($r[0]??'', 0, 10), ENT_QUOTES, 'UTF-8') ?>" data-indice="<?= $idx ?>" data-datos='<?= htmlspecialchars(json_encode($r, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="table-container">
        <div class="table-header">
            <div>
                <h2>Cotiza con nosotros</h2>
                <p class="table-subtitle">Registros de solicitudes de cotización</p>
            </div>
            <div class="table-stats">
                <span class="stat-badge">Total: <strong><?= count($rows_cotizaciones) ?></strong></span>
            </div>
        </div>
        <div class="c-tablewrap">
            <table class="c-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows_cotizaciones)): ?>
                        <tr><td colspan="6" style="text-align: center; padding: 20px; color: #888;">No hay registros de cotizaciones.</td></tr>
                    <?php else: ?>
                        <?php foreach($rows_cotizaciones as $idx => $cotizacion): ?>
                        <tr data-tipo="cotizacion" data-indice="<?= $idx ?>">
                            <td><?= htmlspecialchars($cotizacion[0] ?? '') ?></td>
                            <td><?= htmlspecialchars($cotizacion[1] ?? '') . ' ' . htmlspecialchars($cotizacion[2] ?? '') ?></td>
                            <td><span class="chip"><?= htmlspecialchars($cotizacion[3] ?? '') ?: '-' ?></span></td>
                            <td><a class="mail" href="mailto:<?= htmlspecialchars($cotizacion[4] ?? '') ?>"><?= htmlspecialchars($cotizacion[4] ?? '') ?></a></td>
                            <td>-</td>
                            <td class="acciones">
                                <button class="btn-ver" data-tipo="cotizacion" data-indice="<?= $idx ?>" data-datos='<?= htmlspecialchars(json_encode($cotizacion, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                    <i class="fa-solid fa-eye"></i> Ver
                                </button>
                                <button class="btn-eliminar" data-tipo="cotizacion" data-fecha="" data-indice="<?= $idx ?>" data-datos='<?= htmlspecialchars(json_encode($cotizacion, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (empty($rows_clientes) && empty($filtered_clientes)): ?>
        <div class="c-empty" style="margin-top: 16px;"><div class="ico">📭</div><p>No se encontraron archivos CSV.</p></div>
    <?php endif; ?>
    
    <footer class="c-foot">Intranet M&D ELECTRICMEC</footer>
</div>

<div id="filesModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('filesModal').style.display='none'">×</span>
        <h2><i class="fa-solid fa-folder-open"></i> Archivos CSV</h2>
        <p>Seleccione un archivo para descargarlo.</p>
        <div class="file-list">
            <?php if (empty($file_names)): ?>
                <p>No se encontraron archivos CSV en la carpeta /docs.</p>
            <?php else: ?>
                <p>⚠️ Asegúrate de tener el archivo <code>download.php</code> para descargar.</p>
                <?php foreach($file_names as $file): ?>
                    <a href="/logs/download.php?f=<?= urlencode($file) ?>"><i class="fa-solid fa-file-csv"></i> <?= htmlspecialchars($file) ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="verModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fa-solid fa-eye"></i> Detalles del Registro</h2>
            <span class="close" onclick="document.getElementById('verModal').style.display='none'">&times;</span>
        </div>
        <div id="verModalContent"></div>
    </div>
</div>

<script src="/logs/js/panel.js?v=<?= time() ?>"></script>
</body>
</html>