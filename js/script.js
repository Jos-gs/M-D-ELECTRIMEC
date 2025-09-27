document.addEventListener('DOMContentLoaded', function() {

    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    // Funcionalidad del menú hamburguesa
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            
            // Cambiar icono de hamburguesa a "X"
            const icon = menuToggle.querySelector('i');
            if (navMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }

    // Funcionalidad de los submenús en móvil
    const submenus = document.querySelectorAll('.has-submenu > a');

    submenus.forEach(submenu => {
        submenu.addEventListener('click', function(e) {
            // Prevenir la navegación si la pantalla es pequeña (para abrir el submenú)
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('open');
                
                // Cerrar otros submenús abiertos
                document.querySelectorAll('.has-submenu').forEach(otherSub => {
                    if (otherSub !== parent) {
                        otherSub.classList.remove('open');
                    }
                });
            }
        });
    });

});

document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA DEL MENÚ MÓVIL ---
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

    // --- ANIMACIONES AL HACER SCROLL ---
    const elementsToAnimate = document.querySelectorAll('.about-text, .about-image, .team-card, .subsection-title');

    elementsToAnimate.forEach(el => {
        el.classList.add('fade-in');
    });

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
        observer.observe(element);
    });

});

document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA DEL MENÚ MÓVIL ---
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

    // --- LÓGICA PARA LA VENTANA EMERGENTE (MODAL) ---
    const projectCards = document.querySelectorAll('.project-card');
    const modal = document.getElementById('project-modal');
    
    // Solo busca los elementos del modal si el modal existe en la página
    if (modal) {
        const modalImg = document.getElementById('modal-img');
        const modalTitle = document.getElementById('modal-title');
        const modalDescription = document.getElementById('modal-description');
        const closeButton = document.querySelector('.close-button');

        function openModal(card) {
            const title = card.getAttribute('data-title');
            const image = card.getAttribute('data-image');
            const description = card.getAttribute('data-description');
            
            modalImg.src = image;
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            
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
            if (event.target == modal) {
                closeModal();
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA DEL MENÚ MÓVIL (Existente) ---
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

    // --- LÓGICA PARA LA VENTANA EMERGENTE (MODAL) ---
    const projectCards = document.querySelectorAll('.project-card');
    const modal = document.getElementById('project-modal');
    
    if (modal) {
        const modalImg = document.getElementById('modal-img');
        const modalTitle = document.getElementById('modal-title');
        const modalDescription = document.getElementById('modal-description');
        const closeButton = document.querySelector('.close-button');

        function openModal(card) {
            const title = card.getAttribute('data-title');
            const image = card.getAttribute('data-image');
            const descriptionHTML = card.getAttribute('data-description'); // Leemos el HTML
            
            modalImg.src = image;
            modalTitle.textContent = title;
            modalDescription.innerHTML = descriptionHTML; // Usamos innerHTML para interpretar las etiquetas <ul> y <li>
            
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
            if (event.target == modal) {
                closeModal();
            }
        });
    }
});