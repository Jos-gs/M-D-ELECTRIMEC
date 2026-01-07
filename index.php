<?php
// Script para contar visitas
$contador_file = 'contador_visitas.txt';
$conteo_actual = file_exists($contador_file) ? (int)file_get_contents($contador_file) : 0;
$conteo_actual++;
file_put_contents($contador_file, $conteo_actual);
?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
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
                <li><a href="proyectos.php">Proyectos</a></li>
                <li><a href="contacto.php">Trabaja con Nosotros</a></li>
                <li><a class="btn intranet" href="/logs/intranet.php">Intranet ›</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <section class="hero-carousel">
        <div class="carousel-slides">
            <div class="slide active" style="background-image: url('images/hero-bg1.png');"></div>
            <div class="slide" style="background-image: url('images/hero-bg2.png');"></div>
            <div class="slide" style="background-image: url('images/hero-bg3.png');"></div>
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>M&D ELECTRICMEC</h1>
            <h2>MANTENIMIENTO Y DISEÑO ELÉCTRICO - MECÁNICO</h2>
            <p>Gracias a la experiencia obtenida en diversos proyectos, contamos con una estructura sólida y flexible que nos permite adaptarnos al mercado y brindar un servicio de calidad.</p>
            <a href="#contacto" class="btn cta">Contáctanos</a>
        </div>
        <button class="carousel-nav prev" aria-label="Anterior">❮</button>
        <button class="carousel-nav next" aria-label="Siguiente">❯</button>
        <div class="carousel-dots">
            <span class="dot active" data-slide="0"></span>
            <span class="dot" data-slide="1"></span>
            <span class="dot" data-slide="2"></span>
        </div>
    </section>

    <section id="nosotros" class="brochure">
        <div class="container">
            <div class="brochure-image">
                 <img src="images/img2.png" alt="Equipo de M&D ELECTRICMEC trabajando">
            </div>
            <div class="brochure-content">
                <h2>Conoce un poco más de M&D ELECTRICMEC S.A.C.</h2>
                <p>El equipo de M&D ELECTRICMEC S.A.C.,es el responsable de liderar la dirección estratégica de la organización. Con una visión clara y un enfoque orientado a resultados, guía la toma de decisiones clave para el crecimiento de la empresa y garantiza que cada proyecto cumpla con los más altos estándares de calidad.</p>
            </div>
        </div>
    </section>
    
    <section id="estadisticas" class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <article class="stat-item">
                    <div class="stat-number">
                        <span class="stat-prefix">Más de</span>
                        <div class="stat-value-wrapper">
                            <span data-target="280">0</span>
                        </div>
                    </div>
                    <p>Servicios<br>realizados</p>
                </article>
                <article class="stat-item">
                    <div class="stat-number">
                        <span class="stat-prefix">Más de</span>
                        <div class="stat-value-wrapper">
                            <span data-target="15000">0</span>
                            <span class="stat-unit">HH</span>
                        </div>
                    </div>
                    <p>Horas hombre<br>trabajadas</p>
                </article>
            </div>
        </div>
    </section>

    <section id="contacto" class="contact">
        <div class="container contact-layout">
            <div class="contact-info">
                <h2>Cotiza con nosotros...</h2>
                <p class="subtitle">¡Contáctanos y nos comunicaremos a la brevedad!</p>
                <div class="contact-details">
                    <p><i class="fas fa-envelope"></i> myd.electricmec@gmail.com</p>
                    <p><i class="fas fa-phone"></i> +51 978 270 153</p>
                </div>
            </div>
            <div class="contact-form">
                <form action="procesar_cotizacion.php" method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombres<span>*</span></label>
                            <input type="text" id="nombre" name="nombre" placeholder="Escribe tus nombres" required />
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellidos<span>*</span></label>
                            <input type="text" id="apellido" name="apellido" placeholder="Escribe tus apellidos" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="empresa">Empresa<span>*</span></label>
                        <input type="text" id="empresa" name="empresa" placeholder="Nombre de tu empresa" required />
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span>*</span></label>
                        <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required />
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje<span>*</span></label>
                        <textarea id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje" required></textarea>
                    </div>
                    <button type="submit" class="btn submit">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </section>

    <section class="clients">
        <div class="container">
            <h2>Hemos realizado…</h2>
            <p>Diversos trabajos en empresas de prestigio como: HAUG S.A, CORMEI S.A.C, INVERCEM S.A., GreenCorp, Grupo Klaus, Dijisa Sac. <br>Así como en Centros médicos, residenciales, entre otros.</p>
            <div class="client-logos">
                <div class="client-logo"><img src="images/e1.png" alt="Logo de Empresa Cliente 1"></div>
                <div class="client-logo"><img src="images/e2.png" alt="Logo de Empresa Cliente 2"></div>
                <div class="client-logo"><img src="images/e3.png" alt="Logo de Empresa Cliente 3"></div>
                <div class="client-logo"><img src="images/e4.png" alt="Logo de Empresa Cliente 4"></div>
                <div class="client-logo"><img src="images/e5.png" alt="Logo de Empresa Cliente 5"></div>
                <div class="client-logo"><img src="images/e6.png" alt="Logo de Empresa Cliente 6"></div>
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
            <p>© <?php echo date('Y'); ?> M&D ELECTRICMEC S.A.C. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="js/script.js"></script>

<!-- Botón flotante de WhatsApp -->
<a href="https://wa.me/51978270153" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Contáctanos por WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

</body>
</html>