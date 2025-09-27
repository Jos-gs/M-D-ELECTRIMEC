
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
                    <a href="#">Negocios <i class="fas fa-chevron-down"></i></a>
                    <ul class="submenu">
                        <li><a href="#">Ingeniería</a></li>
                        <li><a href="#">Fabricación</a></li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="proyectos.php">Proyectos </a>
                </li>
                <li><a href="#">Noticias</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
        <a class="btn intranet" href="#">Intranet ›</a>
    </div>
</header>

<main>

    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Especialistas en fabricación y montaje de equipos y plantas industriales</h1>
            <p>Somos una empresa metalmecánica especializada en la fabricación y montaje de equipos para los sectores cementero, minero, energético e industrial.</p>
            <a href="#contacto" class="btn cta">Contáctanos</a>
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
            <p class="section-subtitle">Un servicio de calidad y compromiso, respaldado por la flexibilidad que nos permite adaptarnos a las diversas necesidades de nuestros clientes. 
</p>
            <div class="cards">
                <article class="card">
                    <div class="card-icon"><i class="fas fa-cogs"></i></div>
                    <h3>Ingeniería</h3>
                    <p>Diseño y desarrollo de soluciones técnicas avanzadas, garantizando eficiencia y precisión.</p>
                    <a href="#" class="card-link">Conoce más &rarr;</a>
                </article>
                <article class="card">
                    <div class="card-icon"><i class="fas fa-industry"></i></div>
                    <h3>Fabricación</h3>
                    <p>Producción de alta calidad adaptada a las necesidades industriales, con capacidad para grandes proyectos.</p>
                    <a href="#" class="card-link">Conoce más &rarr;</a>
                </article>
                <article class="card">
                    <div class="card-icon"><i class="fas fa-tools"></i></div>
                    <h3>Montaje</h3>
                    <p>Instalación especializada de equipos y plantas industriales para máxima eficiencia y durabilidad.</p>
                    <a href="#" class="card-link">Conoce más &rarr;</a>
                </article>
                <article class="card">
                    <div class="card-icon"><i class="fas fa-hard-hat"></i></div>
                    <h3>Construcción</h3>
                    <p>Ejecución de proyectos en concreto armado, cumpliendo con los más altos estándares de calidad.</p>
                    <a href="#" class="card-link">Conoce más &rarr;</a>
                </article>
            </div>
        </div>
    </section>
    
    <section class="stats">
        <div class="container">
            <div class="stat">
                <h3><span class="big">600</span><span class="unit">TON</span></h3>
                <p>Capacidad de fabricación mensual</p>
            </div>
            <div class="stat">
                <h3><span class="big">30</span><span class="unit">MM</span></h3>
                <p>Horas hombre trabajadas</p>
            </div>
            <div class="stat">
                <h3><span class="big">3</span><span class="unit">Plantas</span></h3>
                <p>De fabricación a nivel nacional</p>
            </div>
            <div class="stat">
                <h3><span class="big">60</span><span class="unit">mil m²</span></h3>
                <p>De modernas instalaciones</p>
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
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3900.55184659952!2d-77.0195686851865!3d-12.14225599140194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105b81a3f7f8f9f%3A0x8e8e8e8e8e8e8e8e!2sAv.%20los%20Faisanes%20284%2C%20Chorrillos%2015056!5e0!3m2!1ses-419!2spe!4v1628544321987!5m2!1ses-419!2spe" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
        <p>Diversos trabajos en empresas de prestigio como: HAUG S.A, CORMEI S.A.C, INVERCEM S.A., GreenCorp, Grupo Klaus, Dijisa Sac. 
<br>Así como en Centros médicos, residenciales, entre otros. 
</p>
        
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
                <p><i class="fas fa-envelope"></i>myd.electricmec@gmail.com</p>
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
