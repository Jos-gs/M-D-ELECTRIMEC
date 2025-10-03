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
    const elementsToAnimate = document.querySelectorAll('.about-text, .about-image, .team-card, .subsection-title, .mvv-card, .stat-item');
    
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

    // --- LÓGICA PARA LA VENTANA EMERGENTE (MODAL) DE PROYECTOS ---
    const projectCards = document.querySelectorAll('.project-card');
    const modal = document.getElementById('project-modal');
    
    if (modal && projectCards.length > 0) {
        const modalImg = document.getElementById('modal-img');
        const modalTitle = document.getElementById('modal-title');
        const modalDescription = document.getElementById('modal-description');
        const closeButton = document.querySelector('.close-button');

        function openModal(card) {
            const title = card.getAttribute('data-title');
            const image = card.getAttribute('data-image');
            const descriptionHTML = card.getAttribute('data-description');
            
            modalImg.src = image;
            modalTitle.textContent = title;
            modalDescription.innerHTML = descriptionHTML;
            
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        projectCards.forEach(card => {
            card.addEventListener('click', function(event) {
                event.preventDefault();
                openModal(this);
            });
        });

        if (closeButton) {
            closeButton.addEventListener('click', closeModal);
        }
        
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    // --- LÓGICA PARA EL CARRUSEL DE IMÁGENES DEL INICIO ---
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');

    if (slides.length > 0) {
        let currentSlide = 0;
        let slideInterval;

        const goToSlide = (n) => {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            currentSlide = (n + slides.length) % slides.length;

            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        };

        const nextSlide = () => {
            goToSlide(currentSlide + 1);
        };

        const startCarousel = () => {
            slideInterval = setInterval(nextSlide, 5000); // Cambia cada 5 segundos
        };

        const resetInterval = () => {
            clearInterval(slideInterval);
            startCarousel();
        };

        if (next && prev) {
            next.addEventListener('click', () => {
                nextSlide();
                resetInterval();
            });

            prev.addEventListener('click', () => {
                goToSlide(currentSlide - 1);
                resetInterval();
            });
        }
        
        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                const slideIndex = parseInt(e.target.getAttribute('data-slide'));
                goToSlide(slideIndex);
                resetInterval();
            });
        });
        
        goToSlide(0);
        startCarousel();
    }
    
    // --- LÓGICA PARA LA ANIMACIÓN DE CONTEO EN ESTADÍSTICAS ---
    const statsSection = document.querySelector('.stats-section');

    if (statsSection) {
        const animateCounters = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = statsSection.querySelectorAll('.stat-number span[data-target]');
                    
                    counters.forEach(counter => {
                        const target = +counter.getAttribute('data-target');
                        counter.innerText = '0'; // Reiniciar a 0
                        let count = 0;
                        const increment = target / 100;

                        const updateCount = () => {
                            if (count < target) {
                                count += increment;
                                counter.innerText = Math.ceil(Math.min(count, target));
                                requestAnimationFrame(updateCount);
                            } else {
                                counter.innerText = target;
                            }
                        };
                        updateCount();
                    });
                    
                    observer.unobserve(statsSection); // Animar solo una vez
                }
            });
        };

        const statsObserver = new IntersectionObserver(animateCounters, {
            threshold: 0.5
        });

        statsObserver.observe(statsSection);
    }

});