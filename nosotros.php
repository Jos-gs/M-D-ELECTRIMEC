<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <base href="/">
    <title>Nosotros - M&D ELECTRICMEC S.A.C</title>
    <link rel="icon" href="/images/logo.png" type="image/png">
    <link rel="shortcut icon" href="/images/logo.png" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="/css/style.css">
    
    <link rel="stylesheet" href="/css/nosotros.css">
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
            <button class="menu-toggle" aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav-menu">
                <li><a href="/nosotros">Nosotros</a></li>
                <!-- <li class="has-submenu">
                    <a href="#">Negocios </a>
                    
                </li> -->
                <li><a href="/proyectos">Proyectos</a></li>
                <!-- <li><a href="#">Noticias</a></li> -->
                <li><a href="/contacto">Trabaja con Nosotros</a></li>
            </ul>
        </nav>
    </div>
</header>
<main>
    <section id="nosotros" class="about-us-section">
        <div class="container">
            <div class="about-intro">
                <div class="about-text">
                    <h3 class="subtitle">En <strong>M&D ELECTRICMEC S.A.C</strong>, somos una empresa con trayectoria en el mantenimiento, diseño e instalación de equipos eléctricos y mecánicos. Nuestra estructura ágil nos permite adaptarnos y ofrecer un servicio eficiente y de máxima calidad.</h3>
                </div>
                <div class="about-image">
                    <img src="/images/img1.png" alt="Equipo de M&D ELECTRICMEC trabajando">
                </div>
            </div>

            <div class="mvv-section">
                <div class="mvv-grid">
                    <div class="mvv-card">
                        <div class="mvv-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Nuestra Misión</h3>
                        <p>Brindar soluciones integrales y de alta calidad en mantenimiento e instalación de equipos, garantizando la seguridad, eficiencia y satisfacción total de nuestros clientes a través de un equipo comprometido.</p>
                    </div>

                    <div class="mvv-card">
                        <div class="mvv-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3>Nuestra Visión</h3>
                        <p>Ser la empresa líder y referente en el sector electromecánico a nivel nacional, reconocida por nuestra innovación, confiabilidad y por construir relaciones a largo plazo con nuestros clientes, contribuyendo al desarrollo industrial del país.</p>
                    </div>

                </div>
            </div>
            <h2 class="subsection-title">Nuestros Valores</h2>
            <div class="team-grid">
                <article class="team-card">
                    <div class="team-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h3 class="team-name">Rigor técnico</h3>
                    <p class="team-description">Ejecutamos cada servicio bajo criterios de ingeniería, normativa vigente y buenas prácticas del sector eléctrico y mecánico, asegurando trabajos confiables y técnicamente sustentados.</p>
                </article>

                <article class="team-card">
                    <div class="team-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="team-name">Mantenimiento con enfoque preventivo</h3>
                    <p class="team-description">Promovemos soluciones que priorizan la continuidad operativa, reduciendo fallas, paradas no programadas y riesgos mediante una adecuada planificación y ejecución del mantenimiento.</p>
                </article>

                <article class="team-card">
                    <div class="team-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="team-name">Seguridad operativa</h3>
                    <p class="team-description">La seguridad es parte integral de nuestro trabajo. Aplicamos procedimientos seguros para proteger a las personas, los equipos y las instalaciones en cada intervención.</p>
                </article>
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
                    <li><a href="/contacto">Trabaja con Nosotros</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Trabaja con Nosotros</h4>
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
<script src="/js/script.js"></script>

<!-- Botón flotante de WhatsApp -->
<a href="https://wa.me/51928612796" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Contáctanos por WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

</body>
</html>