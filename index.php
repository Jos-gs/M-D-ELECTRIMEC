<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M&D ELECTRIMEC S.A.C</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo.png" alt="M&D ELECTRIMEC Logo">
                <span>M&D ELECTRIMEC</span>
            </a>
        </div>
        <nav class="main-nav">
            <button class="menu-toggle" aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu">
                <li><a href="nosotros.php">Nosotros</a></li>
                <li class="has-submenu">
                    <a href="#">Negocios </a>
                    
                </li>
                <li><a href="proyectos.php">Proyectos</a></li>
                <li><a href="#">Noticias</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
        <a class="btn intranet" href="#">Intranet ›</a>
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
            <h1>Especialistas en fabricación y montaje de equipos y plantas industriales</h1>
            <p>Somos una empresa metalmecánica especializada en la fabricación y montaje de equipos para los sectores cementero, minero, energético e industrial.</p>
            <a href="#contacto" class="btn cta">Contáctanos</a>
        </div>

        <button class="carousel-nav prev" aria-label="Anterior">&#10094;</button>
        <button class="carousel-nav next" aria-label="Siguiente">&#10095;</button>

        <div class="carousel-dots">
            <span class="dot active" data-slide="0"></span>
            <span class="dot" data-slide="1"></span>
            <span class="dot" data-slide="2"></span>
        </div>

    </section>
    <section id="nosotros" class="brochure">
        <div class="container">
            <div class="brochure-image">
                 <img src="images/img2.png" alt="Equipo de CORMEI trabajando">
            </div>
            <div class="brochure-content">
                <h2>Conoce un poco más de M&D ELECTRICMEC S.A.C.</h2>
                <p>En M&D ELECTRICMEC S.A.C., ubicada en Lima-Perú, somos una empresa comprometida con la excelencia en soluciones de diseño y mantenimiento eléctrico y mecánico, asi como servicios generales según las necesidades del cliente.</p>
            </div>
        </div>
    </section>

    <section id="negocios" class="services">
        <div class="container">
            <h2 class="section-title">Ofrecemos…</h2>
            <p class="section-subtitle">Un servicio de calidad y compromiso, respaldado por la flexibilidad que nos permite adaptarnos a las diversas necesidades de nuestros clientes.</p>
            <div class="cards">
                <article class="card">
                    <div class="card-icon"><i class="fas fa-cogs"></i></div>
                    <h3>Ingeniería</h3>
                    <p>Diseño y desarrollo de soluciones técnicas avanzadas, garantizando eficiencia y precisión.</p>
                    <!-- <a href="#" class="card-link">Conoce más →</a> -->
                </article>
                <article class="card">
                    <div class="card-icon"><i class="fas fa-industry"></i></div>
                    <h3>Fabricación</h3>
                    <p>Producción de alta calidad adaptada a las necesidades industriales, con capacidad para grandes proyectos.</p>
                    <!-- <a href="#" class="card-link">Conoce más →</a> -->
                </article>
                <article class="card">
                    <div class="card-icon"><i class="fas fa-tools"></i></div>
                    <h3>Montaje</h3>
                    <p>Instalación especializada de equipos y plantas industriales para máxima eficiencia y durabilidad.</p>
                    <!-- <a href="#" class="card-link">Conoce más →</a> -->
                </article>
                <article class="card">
                    <div class="card-icon"><i class="fas fa-hard-hat"></i></div>
                    <h3>Construcción</h3>
                    <p>Ejecución de proyectos en concreto armado, cumpliendo con los más altos estándares de calidad.</p>
                    <!-- <a href="#" class="card-link">Conoce más →</a> -->
                </article>
            </div>
        </div>
    </section>
    
    <section id="estadisticas" class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <article class="stat-item">
                    <div class="stat-number">
                        <span data-target="600">0</span><span class="stat-unit">TON</span>
                    </div>
                    <p>Capacidad de fabricación<br>mensual</p>
                </article>
                <article class="stat-item">
                    <div class="stat-number">
                        <span data-target="30">0</span><span class="stat-unit">MM</span>
                    </div>
                    <p>Horas hombre<br>trabajadas</p>
                </article>
                <article class="stat-item">
                    <div class="stat-number">
                        <span data-target="3">0</span><span class="stat-unit">Plantas</span>
                    </div>
                    <p>De fabricación<br>a nivel nacional</p>
                </article>
                <article class="stat-item">
                    <div class="stat-number">
                        <span data-target="60">0</span><span class="stat-unit">mil m²</span>
                    </div>
                    <p>De modernas<br>instalaciones</p>
                </article>
            </div>
        </div>
    </section>

    <section id="contacto" class="contact">
        <div class="container contact-layout">
            <div class="contact-info">
                <h2>Tenemos la solución para tu proyecto</h2>
                <p class="subtitle">¡Contáctanos y nos comunicaremos a la brevedad!</p>
                <div class="contact-details">
                    <p><i class="fas fa-map-marker-alt"></i> <strong>Av. Los Faisanes 284, Urb. La Campiña. Chorrillos, Lima.</strong></p>
                    <p><i class="fas fa-envelope"></i> myd.electricmec@gmail.com</p>
                    <p><i class="fas fa-phone"></i> +51 978 270 153</p>
                </div>
                 <div class="map-placeholder">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.583593060243!2d-77.0182226851865!3d-12.14150999140411!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105b804b9062a9d%3A0x88f5a2a2e4e69852!2sAv.%20los%20Faisanes%20284%2C%20Lima%2015054!5e0!3m2!1ses-419!2spe!4v1664057885885!5m2!1ses-419!2spe" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                 </div>
            </div>
            <div class="contact-form">
                <form action="#" method="post">
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
                <div class="client-logo">
                    <img src="images/e1.png" alt="Logo de Empresa Cliente 1">
                </div>
                <div class="client-logo">
                    <img src="images/e2.png" alt="Logo de Empresa Cliente 2">
                </div>
                <div class="client-logo">
                    <img src="images/e3.png" alt="Logo de Empresa Cliente 3">
                </div>
                <div class="client-logo">
                    <img src="images/e4.png" alt="Logo de Empresa Cliente 4">
                </div>
                <div class="client-logo">
                    <img src="images/e5.png" alt="Logo de Empresa Cliente 5">
                </div>
                <div class="client-logo">
                    <img src="images/e6.png" alt="Logo de Empresa Cliente 6">
                </div>
            </div>
        </div>
    </section>

</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="images/logo.png" alt="M&D ELECTRIMEC Logo">
                <span>M&D ELECTRIMEC</span>
                <p>Especialistas en mantenimiento e instalación de equipos eléctricos y mecánicos.</p>
            </div>
            <div class="footer-links">
                <h4>Navegación</h4>
                <ul>
                    <li><a href="nosotros.php">Nosotros</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Proyectos</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Contacto</h4>
                 <p><i class="fas fa-map-marker-alt"></i> Dirección de la Empresa, Ciudad</p>
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
            <p>&copy; <?php echo date('Y'); ?> M&D ELECTRIMEC S.A.C. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="js/script.js"></script>

</body>
</html>