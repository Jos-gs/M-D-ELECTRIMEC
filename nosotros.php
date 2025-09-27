
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
    
    <link rel="stylesheet" href="css/nosotros.css">
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
    <section id="nosotros" class="about-us-section">
        <div class="container">
            <div class="about-intro">
                <div class="about-text">
                    <h1 class="main-title">Especialistas en Soluciones Eléctricas y Mecánicas</h1>
                    <p class="subtitle">En <strong>M&D ELECTRIMEC S.A.C</strong>, somos una empresa en crecimiento dedicada al mantenimiento e instalación de equipos eléctricos y mecánicos. Nuestra estructura ágil nos permite adaptarnos y ofrecer un servicio eficiente y de máxima calidad.</p>
                </div>
                <div class="about-image">
                    <img src="images/img1.png" alt="Equipo de M&D ELECTRIMEC trabajando">
                </div>
            </div>

            <h2 class="subsection-title">Nuestro Equipo Directivo</h2>

            <div class="team-grid">
                <article class="team-card">
                    <div class="team-photo">
                        <img src="https://placehold.co/400x400/ff6600/FFFFFF?text=DMV" alt="Daniel Mas Ventura">
                    </div>
                    <h3 class="team-name">Daniel Mas Ventura</h3>
                    <p class="team-role">Gerente General</p>
                    <p class="team-description">Líder con visión estratégica, responsable del crecimiento de la empresa y la supervisión de proyectos clave, aportando su amplia experiencia en campo.</p>
                    <div class="team-social">
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                    </div>
                </article>

                <article class="team-card">
                    <div class="team-photo">
                        <img src="https://placehold.co/400x400/ff6600/FFFFFF?text=OMV" alt="Orlita Mas Ventura">
                    </div>
                    <h3 class="team-name">Orlita Mas Ventura</h3>
                    <p class="team-role">Directora Financiera</p>
                    <p class="team-description">Pieza fundamental en la gestión financiera y contable, garantizando la solidez y sustentabilidad de la empresa a través de un riguroso control de costos.</p>
                    <div class="team-social">
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                    </div>
                </article>

                <article class="team-card">
                    <div class="team-photo">
                        <img src="https://placehold.co/400x400/ff6600/FFFFFF?text=DNS" alt="Diani Sanchez Chusho">
                    </div>
                    <h3 class="team-name">Diani Sanchez Chusho</h3>
                    <p class="team-role">Encargada de Marketing</p>
                    <p class="team-description">Impulsa nuestra presencia en el mercado, desarrollando estrategias efectivas para fortalecer la marca y captar nuevas oportunidades de negocio.</p>
                    <div class="team-social">
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                    </div>
                </article>

                <article class="team-card">
                    <div class="team-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="team-name">Equipo de Operaciones</h3>
                    <p class="team-role">Ejecución de Proyectos</p>
                    <p class="team-description">El corazón de nuestros proyectos. Responsables de la ejecución, supervisión y calidad en cada instalación y mantenimiento que realizamos.</p>
                    <div class="team-social">
                        <a href="#" aria-label="Proyectos"><i class="fas fa-briefcase"></i></a>
                    </div>
                </article>
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
