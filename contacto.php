<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
  <title>M&D ELECTRICMEC S.A.C</title>
  <link rel="icon" href="images/logo.png" type="image/png">
  <link rel="shortcut icon" href="images/logo.png" type="image/png">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/contacto.css?v=1">
</head>
<body>

<header class="site-header">
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo.png" alt="M&D ELECTRICMEC Logo">
                <span>M&D ELECTRICMEC</span>
            </a>
        </div>
        <nav class="main-nav">
            <button class="menu-toggle" aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu">
                <li><a href="nosotros.php">Nosotros</a></li>
                <!-- <li class="has-submenu">
                    <a href="#">Negocios </a>
                    
                </li> -->
                <li><a href="proyectos.php">Proyectos</a></li>
                <!-- <li><a href="#">Noticias</a></li> -->
                <li><a href="contacto.php">Trabaja con Nosotros</a></li>
                <li><a class="btn intranet" href="/logs/intranet.php">Intranet ›</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
  <section class="contact-section">
    <div class="container contact-grid">
      <div class="contact-form">
        <form id="contact-form" action="enviar_contacto.php" method="post" class="form" autocomplete="off" novalidate>
          <h4 class="contact-title">Trabaja con Nosotros</h4>
          <div class="form-row">
            <label for="nombre">Nombre y apellido</label>
            <input id="nombre" name="nombre" type="text" required>
          </div>


          <div class="form-row">
            <label for="correo">Correo</label>
            <input id="correo" name="correo" type="email" required>
          </div>

          <div class="form-row">
            <label for="telefono">Teléfono</label>
            <input id="telefono" name="telefono" type="tel" pattern="^[\d ()-]{6,}$" required>
          </div>

          <div class="form-row">
            <label for="asunto">Asunto</label>
            <input id="asunto" name="asunto" type="text" required>
          </div>

          <div class="form-row">
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" rows="6" required></textarea>
          </div>

          <!-- Honeypot anti-bots -->
          <input type="text" name="website" class="hp-field" tabindex="-1" aria-hidden="true">

          <div class="form-row form-consent">
            <input id="consent" name="consent" type="checkbox" required>
            <label for="consent">Autorizo el uso de mis datos para contactarme. <a href="#" target="_blank" rel="noopener">Política de privacidad</a></label>
          </div>

          <button type="submit" class="btn btn-primary">Enviar mensaje</button>
          <p class="form-note">Respuesta estimada el mismo día hábil.</p>
        </form>
      </div>

      <div class="contact-info">
        <h1 class="contact-title">Contáctanos</h1>
        <p class="contact-lead">Tenemos la solución para tu proyecto. Completa el formulario y te responderemos.</p>

        <div class="contact-cards">
          <div class="contact-card">
            <i class="fas fa-phone"></i>
            <div>
              <h3>Teléfono</h3>
              <p><a href="tel:+51978270153">+51 978 270 153</a></p>
            </div>
          </div>
          <div class="contact-card">
            <i class="fas fa-envelope"></i>
            <div>
              <h3>Correo</h3>
              <p><a href="mailto:myd.electricmec@gmail.com">myd.electricmec@gmail.com</a></p>
            </div>
          </div>
          <div class="contact-card">
            <i class="fas fa-map-marker-alt"></i>
            <div>
              <h3>Dirección</h3>
              <p>Cal. 4 Mza. B Lote. 10 Dpto. 2 Int. a Asc. Villa trinidad - Villa el Salvador.</p>
            </div>
          </div>
          <div class="contact-card">
            <i class="fas fa-clock"></i>
            <div>
              <h3>Horario</h3>
              <p>Lun–Vie: 7:00am–5:00pm</p>
              <p>Sab: 7:00am–1:00pm</p>
            </div>
          </div>
        </div>

        <div class="contact-social">
          <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-square"></i></a>
        </div>

        <div class="contact-map">
          <iframe title="Ubicación M&D ELECTRICMEC" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d689.3080255536615!2d-76.95721004096804!3d-12.226935661501757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTLCsDEzJzM2LjgiUyA3NsKwNTcnMjUuOCJX!5e0!3m2!1ses!2spe!4v1759470337726!5m2!1ses!2spe"></iframe>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="images/logo.png" alt="M&D ELECTRICMEC Logo">
                <span>M&D ELECTRICMEC</span>
                <p>Mantenimiento y diseño eléctrico - mecánico</p>
            </div>
            <div class="footer-links">
                <h4>Navegación</h4>
                <ul>
                    <li><a href="nosotros.php">Nosotros</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Proyectos</a></li>
                    <li><a href="contacto.php">Trabaja con Nosotros</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Trabaja con Nosotros</h4>
                 <p><i class="fas fa-map-marker-alt"></i> Cal. 4 Mza. B Lote. 10 Dpto. 2 Int. a Asc. Villa trinidad - Villa el Salvador.</p>
                <p><i class="fas fa-envelope"></i> myd.electricmec@gmail.com</p>
                <p><i class="fas fa-phone"></i> +51 978 270 153</p>
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

<!-- JS -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function(){
  const form = document.getElementById('contact-form');
  if(!form) return;

  form.addEventListener('submit', async function(ev){
    ev.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const prev = btn ? btn.innerHTML : '';
    if(btn){ btn.disabled = true; btn.innerHTML = 'Enviando…'; }

    const fd = new FormData(form);
    try{
      const res = await fetch(form.action, { method:'POST', body: fd, headers:{'X-Requested-With':'fetch'} });
      const isJson = (res.headers.get('content-type')||'').includes('application/json');
      const data = isJson ? await res.json() : { ok:false, title:'Error', message:'Respuesta no válida del servidor.' };
      if(!res.ok || !data.ok) throw new Error(data.message || 'No se pudo enviar el mensaje.');

      await Swal.fire({
        icon:'success',
        title: data.title || 'Mensaje enviado',
        text:  data.message || 'Gracias. Te contactaremos pronto.',
        confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--secondary-color') || '#FF6600'
      });
      form.reset();
    }catch(err){
      console.error(err);
      Swal.fire({
        icon:'error',
        title:'No se pudo enviar',
        text: err.message || 'Intenta nuevamente o contáctanos por teléfono.',
        confirmButtonColor: getComputedStyle(document.documentElement).getPropertyValue('--secondary-color') || '#FF6600'
      });
    }finally{
      if(btn){ btn.disabled = false; btn.innerHTML = prev; }
    }
  });
})();
</script>
</body>
</html>
