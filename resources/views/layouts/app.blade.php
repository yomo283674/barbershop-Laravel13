<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Barbershop</title>

    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite / Tailwind CSS -->
    @vite(['resources/css/app.css'])

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --font-ui: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-display: 'Playfair Display', Georgia, serif;
            --color-bronze: #c5a059;
            --color-bronze-dark: #ad8a42;
        }
        body, button, input, select, textarea {
            font-family: var(--font-ui);
        }
        .font-serif {
            font-family: var(--font-display) !important;
        }
        .font-sans {
            font-family: var(--font-ui) !important;
        }
        .font-arial {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif !important;
        }
        .gold-gradient {
            background: linear-gradient(135deg, #d8ba78 0%, #c5a059 50%, #ab873e 100%) !important;
            box-shadow: 0 2px 10px -2px rgba(197, 160, 89, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.35) !important;
            border: 1px solid rgba(197, 160, 89, 0.4) !important;
        }
        .gold-gradient-hover:hover {
            background: linear-gradient(135deg, #e0c484 0%, #cfa85f 50%, #b58f43 100%) !important;
            box-shadow: 0 4px 16px 0 rgba(197, 160, 89, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.45) !important;
            transform: translateY(-0.5px);
        }
        .btn-barber-gold {
            background: linear-gradient(135deg, #d8ba78 0%, #c5a059 50%, #ab873e 100%) !important;
            color: #0f1015 !important;
            border: 1px solid rgba(197, 160, 89, 0.6) !important;
            box-shadow: 0 4px 14px -2px rgba(197, 160, 89, 0.4) !important;
            font-weight: 700 !important;
        }
        .btn-barber-gold:hover {
            background: linear-gradient(135deg, #e0c484 0%, #cfa85f 50%, #b58f43 100%) !important;
            box-shadow: 0 6px 18px 0 rgba(197, 160, 89, 0.55) !important;
            color: #000000 !important;
            transform: translateY(-0.5px);
        }
        .btn-barber-dark {
            background-color: #14151b !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 4px 14px -2px rgba(15, 16, 21, 0.35) !important;
            font-weight: 600 !important;
        }
        .btn-barber-dark:hover {
            background-color: #20222d !important;
            border-color: rgba(197, 160, 89, 0.5) !important;
            color: #d4b26f !important;
            transform: translateY(-0.5px);
        }
        #mainSidebar {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (min-width: 768px) {
            #mainSidebar.sidebar-open {
                margin-left: 0 !important;
                transform: none !important;
            }
            #mainSidebar.sidebar-closed {
                margin-left: -16rem !important;
                transform: none !important;
            }
        }

        @media (max-width: 767px) {
            #mainSidebar {
                margin-left: 0 !important;
            }
            #mainSidebar.sidebar-open {
                transform: translateX(0) !important;
            }
            #mainSidebar.sidebar-closed {
                transform: translateX(-100%) !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-[#f8fafc] flex overflow-hidden">

    <!-- Edge Hover Trigger Strip (Abre el sidebar al acercar el cursor al borde izquierdo cuando está cerrado) -->
    <div id="sidebarHoverTrigger" class="fixed inset-y-0 left-0 w-3 z-40 pointer-events-none" onmouseenter="showSidebar()"></div>

    <!-- Indicador pestaña cuando el sidebar está oculto -->
    <button type="button" 
            id="sidebarPeekTab" 
            onclick="showSidebar()" 
            onmouseenter="showSidebar()" 
            class="fixed top-24 left-0 z-40 bg-[#0b0c10] border border-l-0 border-[#1a1b22] text-amber-400 p-2 rounded-r-xl shadow-xl transition-all duration-300 hover:bg-[#17181f] hover:pl-3 cursor-pointer opacity-0 pointer-events-none flex items-center justify-center" 
            title="Abrir Menú">
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
    </button>

    <!-- Mobile Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/60 z-40 hidden md:hidden transition-opacity duration-300" onclick="hideSidebarImmediate()"></div>

    <!-- Sidebar Component (En desktop es relativo y en el flujo flex: nunca tapa el dashboard) -->
    @include('layouts.partials.sidebar')

    <!-- Main Content Area (Ajusta automáticamente su ancho en el flujo flex) -->
    <div id="mainContentArea" class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
        
        <!-- Topbar Component -->
        @include('layouts.partials.topbar')

        <!-- Breadcrumbs Bar -->
        @include('layouts.partials.breadcrumbs')

        <!-- Flash Notifications -->
        @include('layouts.partials.alert')

        <!-- Dynamic Page Content -->
        <main id="mainScrollContainer" class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-[#f8fafc]">
            @yield('content')
        </main>

        <!-- Restauración Inmediata de Scroll para Paginación (Pre-Paint) -->
        <script>
            (function() {
                try {
                    const raw = sessionStorage.getItem('barbershop_pagination_scroll');
                    if (!raw) return;
                    const data = JSON.parse(raw);
                    if (Date.now() - data.timestamp > 15000 || data.pathname !== window.location.pathname) {
                        sessionStorage.removeItem('barbershop_pagination_scroll');
                        return;
                    }
                    const main = document.getElementById('mainScrollContainer');
                    if (main && typeof data.targetScrollTop === 'number') {
                        main.scrollTop = data.targetScrollTop;
                    }
                } catch(e) {}
            })();
        </script>
    </div>

    <!-- Scripts -->
    <script>
        let sidebarHideTimer = null;

        function showSidebar() {
            clearTimeout(sidebarHideTimer);
            const sidebar = document.getElementById('mainSidebar');
            const peekTab = document.getElementById('sidebarPeekTab');
            const hoverTrigger = document.getElementById('sidebarHoverTrigger');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            if (sidebar) {
                sidebar.classList.remove('sidebar-closed');
                sidebar.classList.add('sidebar-open');
            }
            if (peekTab) {
                peekTab.classList.add('opacity-0', 'pointer-events-none');
                peekTab.classList.remove('opacity-100', 'pointer-events-auto');
            }
            if (hoverTrigger) {
                hoverTrigger.style.pointerEvents = 'none';
            }
            if (backdrop && window.innerWidth < 768) {
                backdrop.classList.remove('hidden');
            }
        }

        function hideSidebar() {
            clearTimeout(sidebarHideTimer);
            sidebarHideTimer = setTimeout(() => {
                hideSidebarImmediate();
            }, 250);
        }

        function hideSidebarImmediate() {
            clearTimeout(sidebarHideTimer);
            const sidebar = document.getElementById('mainSidebar');
            const peekTab = document.getElementById('sidebarPeekTab');
            const hoverTrigger = document.getElementById('sidebarHoverTrigger');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            if (sidebar) {
                sidebar.classList.remove('sidebar-open');
                sidebar.classList.add('sidebar-closed');
            }
            if (peekTab) {
                peekTab.classList.remove('opacity-0', 'pointer-events-none');
                peekTab.classList.add('opacity-100', 'pointer-events-auto');
            }
            if (hoverTrigger) {
                hoverTrigger.style.pointerEvents = 'auto';
            }
            if (backdrop) {
                backdrop.classList.add('hidden');
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            if (!sidebar) return;
            if (sidebar.classList.contains('sidebar-closed')) {
                showSidebar();
            } else {
                hideSidebarImmediate();
            }
        }

        // Global Modal Management
        window.openModal = function(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                if (window.lucide) {
                    lucide.createIcons();
                }
            }
        };

        window.closeModal = function(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
            }
        };

        // Initialize Lucide Icons & Responsive Sidebar initial state
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
            if (window.innerWidth < 768) {
                hideSidebarImmediate();
            }
        });

        window.addEventListener('resize', () => {
            const backdrop = document.getElementById('sidebarBackdrop');
            if (window.innerWidth >= 768 && backdrop) {
                backdrop.classList.add('hidden');
            }
        });

        // Global Escape key listener to close open modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal"]:not(.hidden)').forEach(modal => {
                    modal.classList.add('hidden');
                });
            }
        });

        // Reusable Barbershop Luxury Alert Mixin
        window.swalBarbershop = Swal.mixin({
            customClass: {
                popup: "rounded-3xl border border-stone-200/90 shadow-2xl p-6",
                title: "font-serif text-slate-900 font-bold text-xl",
                htmlContainer: "text-slate-600 text-sm",
                confirmButton: "btn btn-barber-gold",
                cancelButton: "btn btn-barber-dark"
            },
            buttonsStyling: false,
            heightAuto: false
        });

        // Global SweetAlert2 Confirmation Dialog
        window.confirmarEliminacion = function(event, form, options = {}) {
            if (event) event.preventDefault();

            window.swalBarbershop.fire({
                position: "center",
                title: options.title || "¿Estás seguro?",
                text: options.text || "¡No podrás revertir esto!",
                icon: options.icon || "warning",
                iconColor: options.iconColor || "#c5a059",
                showCancelButton: true,
                confirmButtonText: options.confirmText || "¡Sí, eliminar!",
                cancelButtonText: options.cancelText || "No, cancelar!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (form) form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel && options.showCancelAlert === true) {
                    window.swalBarbershop.fire({
                        position: "center",
                        title: options.cancelTitle || "Cancelado",
                        text: options.cancelTextMsg || "Tu registro sigue a salvo :)",
                        icon: options.cancelIcon || "error"
                    });
                }
            });
        };

        window.confirmarAccion = window.confirmarEliminacion;

        // Global Confirmation for Logout
        window.confirmarCerrarSesion = function(event, form) {
            if (event) event.preventDefault();
            if (typeof closeSettingsMenu === 'function') {
                closeSettingsMenu();
            }

            window.swalBarbershop.fire({
                position: "center",
                title: "¿Cerrar sesión?",
                text: "¿Estás seguro de que deseas finalizar tu sesión actual?",
                icon: "warning",
                iconColor: "#c5a059",
                showCancelButton: true,
                confirmButtonText: "Sí, cerrar sesión",
                cancelButtonText: "No, cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
        };

        // Global Confirmation for Appointment Cancellation
        window.confirmarCancelacionCita = function(event, form) {
            if (event) event.preventDefault();

            window.swalBarbershop.fire({
                position: "center",
                title: "¿Deseas cancelar esta cita?",
                text: "Ten presente que las cancelaciones están sujetas al tiempo mínimo de anticipación configurado.",
                icon: "warning",
                iconColor: "#c5a059",
                showCancelButton: true,
                confirmButtonText: "Sí, cancelar cita",
                cancelButtonText: "Conservar cita",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
        };

        /* ==========================================================================
           Reposicionamiento Inteligente del Scroll en Paginación (Enfoque A)
           ========================================================================== */
        (function() {
            function getMainContainer() {
                return document.getElementById('mainScrollContainer') || document.querySelector('main.overflow-y-auto') || document.querySelector('main');
            }

            function getOffsetRelativeToMain(el, main) {
                if (!el || !main) return 0;
                const mainRect = main.getBoundingClientRect();
                const elRect = el.getBoundingClientRect();
                // Margen superior de 16px para que el encabezado del bloque no quede pegado al topbar
                const computed = main.scrollTop + (elRect.top - mainRect.top) - 16;
                return Math.max(0, Math.round(computed));
            }

            function resolvePaginationTarget(link, main) {
                // 1. Selector explícito si el enlace o contenedor lo define
                const explicitSelector = link.getAttribute('data-scroll-target') || 
                                         link.closest('[data-scroll-target]')?.getAttribute('data-scroll-target');
                if (explicitSelector) {
                    const el = document.querySelector(explicitSelector);
                    if (el) return { el, selector: explicitSelector };
                }

                // 2. Tarjeta contenedora de la paginación
                const card = link.closest('.bg-white.rounded-3xl, .bg-white.rounded-2xl, [data-pagination-card]');
                if (card) {
                    const hasData = card.querySelector('table, #contenedorServicios, [data-pagination-content], .category-block') ||
                                    (card.querySelector('.grid') && !card.querySelector('.grid').contains(link));
                    
                    if (hasData) {
                        return { el: card, selector: card.id ? '#' + card.id : null };
                    } else if (card.previousElementSibling) {
                        const prev = card.previousElementSibling;
                        return { el: prev, selector: prev.id ? '#' + prev.id : null };
                    }
                    return { el: card, selector: card.id ? '#' + card.id : null };
                }

                // 3. Fallback: buscar tabla o catálogo principal en main
                const fallback = main.querySelector('table')?.closest('.bg-white') ||
                                 main.querySelector('#contenedorServicios')?.closest('.bg-white') ||
                                 main.querySelector('.grid')?.closest('.bg-white') ||
                                 main.querySelector('table');
                if (fallback) {
                    return { el: fallback, selector: fallback.id ? '#' + fallback.id : null };
                }

                return { el: null, selector: null };
            }

            function isPaginationLink(link) {
                if (!link || !link.href) return false;
                if (link.closest('[data-pagination-nav]') || link.closest('nav[role="navigation"]') || link.closest('.pagination')) {
                    return true;
                }
                try {
                    const url = new URL(link.href, window.location.origin);
                    if (url.origin === window.location.origin && url.pathname === window.location.pathname) {
                        if (url.searchParams.has('page') || url.searchParams.has('per_page')) {
                            return true;
                        }
                    }
                } catch(err) {
                    const href = link.getAttribute('href') || '';
                    if (href.includes('page=') || href.includes('per_page=')) return true;
                }
                return false;
            }

            // Captura de clics en enlaces de paginación antes de descargar la página
            document.addEventListener('click', function(e) {
                if (e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
                const link = e.target.closest('a');
                if (!link || !isPaginationLink(link)) return;

                const main = getMainContainer();
                if (!main) return;

                const target = resolvePaginationTarget(link, main);
                const offsetTop = target.el ? getOffsetRelativeToMain(target.el, main) : Math.max(0, Math.round(main.scrollTop));

                const payload = {
                    pathname: window.location.pathname,
                    targetScrollTop: offsetTop,
                    selector: target.selector,
                    timestamp: Date.now()
                };

                try {
                    sessionStorage.setItem('barbershop_pagination_scroll', JSON.stringify(payload));
                } catch(err) {}
            }, { capture: true });

            // Verificación y ajuste post-renderizado en DOMContentLoaded y Load
            function verifyPaginationScroll() {
                try {
                    const raw = sessionStorage.getItem('barbershop_pagination_scroll');
                    if (!raw) return;
                    const data = JSON.parse(raw);
                    sessionStorage.removeItem('barbershop_pagination_scroll');

                    if (Date.now() - data.timestamp > 15000 || data.pathname !== window.location.pathname) return;

                    const main = getMainContainer();
                    if (!main) return;

                    let finalScrollTop = data.targetScrollTop;

                    if (data.selector) {
                        const el = document.querySelector(data.selector);
                        if (el) {
                            finalScrollTop = getOffsetRelativeToMain(el, main);
                        }
                    }

                    if (typeof finalScrollTop === 'number') {
                        main.scrollTop = finalScrollTop;
                        requestAnimationFrame(() => {
                            if (data.selector) {
                                const el = document.querySelector(data.selector);
                                if (el) {
                                    const adjusted = getOffsetRelativeToMain(el, main);
                                    if (Math.abs(adjusted - main.scrollTop) > 4) {
                                        main.scrollTop = adjusted;
                                    }
                                }
                            }
                        });
                    }
                } catch(e) {}
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', verifyPaginationScroll);
            } else {
                verifyPaginationScroll();
            }
            window.addEventListener('load', verifyPaginationScroll);
        })();
    </script>
    @stack('scripts')
</body>
</html>
