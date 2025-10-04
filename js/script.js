document.addEventListener('DOMContentLoaded', function() {

    // --- MOBILE MENU (HAMBURGER) LOGIC ---
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const icon = menuToggle.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Cerrar menú al hacer clic en un enlace
        const navLinks = document.querySelectorAll('.nav-menu a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                const icon = menuToggle.querySelector('i');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-times');
            });
        });

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                const icon = menuToggle.querySelector('i');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-times');
            }
        });
    }

    // --- MOBILE SUB-MENU LOGIC ---
    const submenus = document.querySelectorAll('.has-submenu > a');
    submenus.forEach(submenu => {
        submenu.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                this.parentElement.classList.toggle('open');
            }
        });
    });

    // --- ON-SCROLL FADE-IN ANIMATION LOGIC ---
    const elementsToAnimate = document.querySelectorAll('.about-text, .about-image, .team-card, .subsection-title, .mvv-card, .stat-item');
    
    if (elementsToAnimate.length > 0) {
        const fadeInObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    fadeInObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        elementsToAnimate.forEach(element => {
            element.classList.add('fade-in');
            fadeInObserver.observe(element);
        });
    }

    // --- PROJECTS PAGE MODAL (POP-UP) LOGIC ---
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

        // Mobile-specific modal improvements
        if (window.innerWidth <= 768) {
            // Prevent body scroll when modal is open
            const originalOpenModal = openModal;
            openModal = function(card) {
                document.body.style.overflow = 'hidden';
                originalOpenModal(card);
            };

            const originalCloseModal = closeModal;
            closeModal = function() {
                document.body.style.overflow = '';
                originalCloseModal();
            };

            // Add touch support for modal close
            modal.addEventListener('touchstart', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }
    }

    // --- HERO IMAGE CAROUSEL LOGIC ---
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');
    const carousel = document.querySelector('.hero-carousel');

    if (slides.length > 0) {
        let currentSlide = 0;
        let slideInterval;
        let startX = 0;
        let endX = 0;

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
            slideInterval = setInterval(nextSlide, 5000); // Changes every 5 seconds
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

        // Touch support for mobile carousel
        if (carousel) {
            carousel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });

            carousel.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                const diffX = startX - endX;
                
                if (Math.abs(diffX) > 50) { // Minimum swipe distance
                    if (diffX > 0) {
                        nextSlide();
                    } else {
                        goToSlide(currentSlide - 1);
                    }
                    resetInterval();
                }
            });
        }
        
        goToSlide(0);
        startCarousel();
    }
    
    // --- STATS COUNTER ANIMATION LOGIC ---
    const statsSection = document.querySelector('.stats-section');

    if (statsSection) {
        const animateCounters = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = statsSection.querySelectorAll('.stat-number span[data-target]');
                    
                    counters.forEach(counter => {
                        const target = +counter.getAttribute('data-target');
                        counter.innerText = '0'; // Reset to 0 before animating
                        let count = 0;
                        const increment = target / 100; // Animate in 100 steps

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
                    
                    observer.unobserve(statsSection); // Animate only once
                }
            });
        };

        const statsObserver = new IntersectionObserver(animateCounters, {
            threshold: 0.5
        });

        statsObserver.observe(statsSection);
    }

    // --- MOBILE PERFORMANCE OPTIMIZATIONS ---
    
    // Lazy loading for images on mobile
    if (window.innerWidth <= 768) {
        const images = document.querySelectorAll('img');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });

        images.forEach(img => {
            if (img.dataset.src) {
                imageObserver.observe(img);
            }
        });
    }

    // Smooth scrolling for mobile
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Handle orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(function() {
            // Recalculate carousel height if needed
            const carousel = document.querySelector('.hero-carousel');
            if (carousel && window.innerWidth <= 768) {
                carousel.style.height = '70vh';
            }
        }, 100);
    });

    // Prevent zoom on double tap for iOS
    let lastTouchEnd = 0;
    document.addEventListener('touchend', function(event) {
        const now = (new Date()).getTime();
        if (now - lastTouchEnd <= 300) {
            event.preventDefault();
        }
        lastTouchEnd = now;
    }, false);

});