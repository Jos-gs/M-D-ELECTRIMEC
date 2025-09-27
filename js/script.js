document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA DEL MENÚ MÓVIL (HAMBURGUESA) ---
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const icon = menuToggle.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
    }

    // --- LÓGICA PARA SUBMENÚS EN MÓVIL ---
    const submenus = document.querySelectorAll('.has-submenu > a');
    submenus.forEach(submenu => {
        submenu.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                this.parentElement.classList.toggle('open');
            }
        });
    });

    // --- LÓGICA PARA ANIMACIONES AL HACER SCROLL ---
    const elementsToAnimate = document.querySelectorAll('.about-text, .about-image, .team-card, .subsection-title, .mvv-card');
    
    if (elementsToAnimate.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        elementsToAnimate.forEach(element => {
            element.classList.add('fade-in');
            observer.observe(element);
        });
    }
});