<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BARBERSHOP - Tu mejor versión comienza aquí</title>
    <meta name="description" content="Servicios de barbería premium. Tu estilo, nuestra prioridad.">

    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/barbershop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat-asistente.css') }}">
    <style>
        body, button, input, select, textarea, h1, h2, h3, h4, h5, h6, p, a, span {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif !important;
        }
    </style>

    <!-- Force Scroll to Top on Refresh -->
    <script>
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);

        // Clear hash from URL if present
        if (window.location.hash) {
            window.history.replaceState('', document.title, window.location.pathname + window.location.search);
        }
    </script>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-brand">
            <a href="#inicio">BARBER<span class="brand-accent">SHOP</span></a>
        </div>
        <ul class="nav-links">
            <li><a href="#inicio" class="active">Inicio</a></li>
            <li><a href="#servicios">Servicios</a></li>
            <li><a href="#galeria">Galería</a></li>
            <li><a href="#contacto">Contacto</a></li>
        </ul>
        
        <button class="nav-hamburger" id="nav-hamburger" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu" id="mobile-menu">
        <ul class="mobile-nav-links">
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#servicios">Servicios</a></li>
            <li><a href="#galeria">Galería</a></li>
            <li><a href="#contacto">Contacto</a></li>
        </ul>
    </div>

    <!-- Hero Section -->
    <section id="inicio" class="hero">
        <div class="hero-glow"></div>
        <div class="hero-content">
            <h1 class="hero-title">Tu mejor versión <br><span class="text-gradient">comienza aquí</span></h1>
            <p class="hero-subtitle">Experimenta el arte del cuidado personal. Combinamos técnicas clásicas con estilos
                modernos para ofrecerte un servicio de barbería de primer nivel.</p>
            <div class="hero-actions">
                <a href="{{ route('login') }}" class="btn btn-sand">
                    <i data-lucide="calendar"></i>
                    <span>Reservar Cita</span>
                </a>
                <a href="#servicios" class="btn-link">
                    <span>Explorar</span>
                    <div class="icon-circle">
                        <i data-lucide="arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="hero-image-wrapper">
            <div class="hero-image-inner">
                <div class="hero-image-overlay"></div>
                <img src="{{ asset('images/hero.jpg') }}" alt="Barbero profesional trabajando" class="hero-image">
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="services">
        <h2 class="section-title">Servicios de barbería</h2>
        <p class="section-subtitle">Descubre nuestra gama de servicios diseñados para realzar tu estilo personal con
            atención a cada detalle.</p>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-image">
                    <img src="{{ asset('images/corte-moderno.jpg') }}" alt="Corte de cabello moderno con fade">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Corte de Cabello</h3>
                    <p class="service-desc">Corte clásico o moderno con asesoría de estilo.</p>
                    <div class="service-price">23.000</div>
                </div>
            </div>

            <div class="service-card">
                <div class="service-image">
                    <img src="{{ asset('images/arreglo-barba.jpg') }}" alt="Arreglo de barba profesional con toalla">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Arreglo de Barba</h3>
                    <p class="service-desc">Perfilado, recorte y cuidado con toalla caliente.</p>
                    <div class="service-price">$30.000</div>
                </div>
            </div>

            <div class="service-card">
                <div class="service-image">
                    <img src="{{ asset('images/afeitado-clasico.jpg') }}" alt="Afeitado Clásico tradicional con navaja">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Afeitado Clásico</h3>
                    <p class="service-desc">Afeitado tradicional con navaja y espuma.</p>
                    <div class="service-price">$15.000</div>
                </div>
            </div>

            <div class="service-card">
                <div class="service-image">
                    <img src="{{ asset('images/asesoria-imagen.jpg') }}" alt="Asesoría de Imagen personalizada">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Asesoría de Imagen</h3>
                    <p class="service-desc">Consulta personalizada para tu mejor look.</p>
                    <div class="service-price">$115.000</div>
                </div>
            </div>

            <div class="service-card">
                <div class="service-image">
                    <img src="{{ asset('images/servicio-premium.jpg') }}" alt="Servicio Premium VIP">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Servicio Premium</h3>
                    <p class="service-desc">Corte, barba, masaje facial y bebida de cortesía.</p>
                    <div class="service-price">$60.000</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="galeria" class="gallery-section">
        <div class="gallery-content">
            <h2 class="gallery-title">Estilo en cada detalle</h2>
            <p class="gallery-subtitle">Nuestros espacios están diseñados para tu comodidad. Cada corte es una obra de
                arte y cada cliente es nuestra prioridad.</p>
        </div>
        <div class="gallery-grid">
            <img src="{{ asset('images/gallery_1.jpg') }}" alt="Herramientas de barbería" class="gallery-img img-large">
            <img src="{{ asset('images/gallery-2.jpg') }}" alt="Sillas de barbería vintage" class="gallery-img">
            <img src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600"
                alt="Detalle de afeitado profesional" class="gallery-img">
        </div>
    </section>

    <!-- Map Section -->
    <section id="contacto" class="map-section">
        <div class="map-content">
            <h2 class="map-title">Tu estilo, nuestra prioridad</h2>
            <p class="map-subtitle">Visítanos en nuestra ubicación céntrica. Un espacio donde la tradición se encuentra
                con el estilo moderno.</p>
        </div>
        <div class="map-wrapper">
            <div class="google-map-container">
                <iframe src="https://www.google.com/maps?q=Neiva,+Huila,+Colombia&output=embed" style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-top">
            <div class="footer-brand-section">
                <div class="footer-logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="6" cy="6" r="3" />
                        <circle cx="6" cy="18" r="3" />
                        <line x1="20" x2="8.12" y1="4" y2="15.88" />
                        <line x1="14.47" x2="20" y1="14.48" y2="20" />
                        <line x1="8.12" x2="12" y1="8.12" y2="12" />
                    </svg>
                </div>
                <p class="footer-desc">Redefiniendo el cuidado masculino con servicios de barbería de primera clase,
                    estilo atemporal y atención meticulosa para el hombre moderno.</p>
                <div class="social-links">
                    <a href="javascript:void(0)" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="footer-newsletter">
                <h4>Suscríbete</h4>
                <p>Únete a nuestra lista para recibir ofertas exclusivas y tips de cuidado.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Tu correo electrónico" required>
                    <button type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" x2="11" y1="2" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="footer-grid">
            <div class="footer-col">
                <h4>Navegación</h4>
                <ul class="footer-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#galeria">Galería</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Servicios</h4>
                <ul class="footer-links">
                    <li><a href="#servicios">Corte Clásico</a></li>
                    <li><a href="#servicios">Arreglo de Barba</a></li>
                    <li><a href="#servicios">Afeitado Premium</a></li>
                    <li><a href="#servicios">Asesoría de Imagen</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Contacto</h4>
                <ul class="footer-links contact-info">
                    <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg> <span>(57) 313 8763227</span></li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg> <span>info@barbershop.com</span></li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg> <span>Calle 83 A 2 a 10 , Neiva Huila</span></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Horario</h4>
                <ul class="footer-links schedule-info">
                    <li><span>Lun - Vie:</span> <span>9:00 AM - 8:00 PM</span></li>
                    <li><span>Sábados:</span> <span>9:00 AM - 6:00 PM</span></li>
                    <li><span class="closed">Domingos:</span> <span class="closed">Cerrado</span></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-copyright">
                <p>&copy; 2026 BARBERSHOP. Todos los derechos reservados.</p>
            </div>
            <div class="footer-legal">
                <a href="">Términos y Condiciones</a>
                <a href="">Política de Privacidad</a>
            </div>
            <div class="footer-dev">
                <a href="https://www.instagram.com/b__mauricio?stkn=MXhnZnJiYTJpYTY3dg==" target="_blank"
                    rel="noopener noreferrer">Develop: Brayan Mauricio Ramirez Vargas</a>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Navbar ScrollSpy Logic
        document.addEventListener("DOMContentLoaded", function () {
            const sections = document.querySelectorAll("section");
            const navLinks = document.querySelectorAll(".nav-links a");

            window.addEventListener("scroll", () => {
                let current = "";

                sections.forEach((section) => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (window.scrollY >= sectionTop - 250) {
                        current = section.getAttribute("id");
                    }
                });

                navLinks.forEach((link) => {
                    link.classList.remove("active");
                    if (current && link.getAttribute("href") === `#${current}`) {
                        link.classList.add("active");
                    }
                });
            });

            // Smooth scroll for nav links (optional, but improves UX)
            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Hamburger menu
            const hamburger = document.getElementById('nav-hamburger');
            const mobileMenu = document.getElementById('mobile-menu');

            hamburger.addEventListener('click', () => {
                hamburger.classList.toggle('is-active');
                mobileMenu.classList.toggle('is-open');
                document.body.classList.toggle('menu-open');
            });

            // Close mobile menu on link click
            document.querySelectorAll('.mobile-nav-links a').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    hamburger.classList.remove('is-active');
                    mobileMenu.classList.remove('is-open');
                    document.body.classList.remove('menu-open');
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth' });
                });
            });
        });
    </script>

    {{-- Widget Asistente Virtual con Conexión a WhatsApp Business --}}
    @include('partials.chat-asistente')
    <script src="{{ asset('js/chat-asistente.js') }}"></script>
</body>

</html>