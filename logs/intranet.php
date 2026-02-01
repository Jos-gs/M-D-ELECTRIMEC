<?php
session_start();
if (!empty($_SESSION['auth'])) { header('Location: /logs/panel.php'); exit; }
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
<base href="/logs/">
<title>Intranet — Acceso</title>
<link rel="icon" href="/images/logo.png" type="image/png">
<link rel="shortcut icon" href="/images/logo.png" type="image/png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/contacto.css">
<link rel="stylesheet" href="/logs/css/intranet.css">
</head>
<body>

<header class="site-header">
  <div class="container">
    <div class="logo">
      <a href="/">
        <img src="/images/logo.png" alt="M&D ELECTRICMEC Logo">
        <span>M&D ELECTRICMEC</span>
      </a>
    </div>
    <nav class="main-nav">
      <button class="menu-toggle" aria-label="Abrir menú"><i class="fas fa-bars"></i></button>
      <ul class="nav-menu">
        <li><a href="/nosotros">Nosotros</a></li>
        <!-- <li class="has-submenu"><a href="#">Negocios</a></li> -->
        <li><a href="/proyectos">Proyectos</a></li>
        <!-- <li><a href="#">Noticias</a></li> -->
        <li><a href="/contacto">Contacto</a></li>
        <li><a class="btn intranet" href="/logs/intranet.php">Intranet ›</a></li>
      </ul>
    </nav>
  </div>
</header>

<main>
  <section class="login-section">
    <div class="container login-grid">
      <div class="login-info">
        <h1 class="login-title">Intranet</h1>
        <p class="login-lead">Accede para ver los registros de contacto guardados.</p>

        <div class="login-cards">
          <div class="login-card">
            <i class="fas fa-lock"></i>
            <div>
              <h3>Seguro</h3>
              <p>Acceso protegido por sesión.</p>
            </div>
          </div>
          <div class="login-card">
            <i class="fas fa-database"></i>
            <div>
              <h3>Registros</h3>
              <p>Consulta y descarga CSV por fecha.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="login-form-wrap">
        <form class="login-form" method="post" action="/logs/login.php" autocomplete="off">
          <div class="form-row">
            <label for="user">Usuario</label>
            <input id="user" name="user" type="text" required>
          </div>
          <div class="form-row">
            <label for="pass">Contraseña</label>
            <input id="pass" name="pass" type="password" required>
          </div>

          <?php if (isset($_GET['e'])): ?>
            <div class="login-alert" role="alert">Credenciales inválidas. Inténtalo de nuevo.</div>
          <?php endif; ?>

          <button class="btn btn-primary" type="submit">Ingresar</button>
          <p class="form-note">¿Olvidaste tu clave? Contacta al administrador.</p>
        </form>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="/images/logo.png" alt="M&D ELECTRICMEC Logo">
                <span>M&D ELECTRICMEC</span>
                <p>Mantenimiento y diseño eléctrico - mecánico</p>
            </div>
            <div class="footer-links">
                <h4>Navegación</h4>
                <ul>
                    <li><a href="/nosotros">Nosotros</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="/proyectos">Proyectos</a></li>
                    <li><a href="/contacto">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Contacto</h4>
                 <p><i class="fas fa-map-marker-alt"></i> Cal. 4 Mza. B Lote. 10 Dpto. 2 Int. a Asc. Villa trinidad - Villa el Salvador.</p>
                <p><i class="fas fa-envelope"></i> myd.electricmec@gmail.com</p>
                <p><i class="fas fa-phone"></i> +51 928 612 796</p>
            </div>
            <div class="footer-social">
                 <h4>Síguenos</h4>
                 <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                 <a href="#" aria-label="Facebook"><i class="fab fa-facebook-square"></i></a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> M&D ELECTRICMEC S.A.C. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

</body>
</html>
