<!-- MODAL: TARJETA DETALLADA DEL SERVICIO -->
<div id="modalDetalleServicioCliente" class="fixed inset-0 z-50 hidden bg-slate-950/75 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl border border-slate-200/90 overflow-hidden transform transition-all flex flex-col max-h-[92vh]">
        
        <!-- Header Visual / Imagen del Corte o Técnica -->
        <div class="relative w-full h-52 sm:h-60 bg-slate-950 overflow-hidden shrink-0">
            <!-- Imagen real del servicio -->
            <img id="modalServicioImg" 
                src="" 
                alt="Corte / Servicio" 
                class="w-full h-full object-cover hidden transition-transform duration-500 hover:scale-105"
                onerror="this.classList.add('hidden'); document.getElementById('modalServicioPlaceholder').classList.remove('hidden');">
            
            <!-- Placeholder cinemático si no tiene imagen -->
            <div id="modalServicioPlaceholder" class="w-full h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950 flex flex-col items-center justify-center text-amber-400 p-4 relative">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(245,158,11,0.15),transparent_70%)]"></div>
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-amber-400/30 shadow-xl flex items-center justify-center text-[#c5a059] backdrop-blur-md mb-2">
                    <i data-lucide="scissors" class="w-8 h-8 stroke-[1.75]"></i>
                </div>
                <span class="text-xs font-serif tracking-widest text-amber-200/80 uppercase font-semibold">Técnica Profesional</span>
            </div>

            <!-- Gradiente de contraste para legibilidad -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-black/40 pointer-events-none"></div>

            <!-- Título del Servicio superpuesto en la base de la imagen -->
            <div class="absolute bottom-3.5 left-4 right-4 z-10 text-white">
                <span class="text-[10px] uppercase font-bold tracking-widest text-amber-300/90 drop-shadow-xs block">Portafolio Exclusivo</span>
                <h3 id="modalServicioNombre" class="font-serif font-bold text-xl sm:text-2xl tracking-tight leading-tight drop-shadow-md text-white mt-0.5">
                    Nombre del Servicio
                </h3>
            </div>
        </div>

        <!-- Contenido y Ficha Técnica del Servicio -->
        <div class="p-5 sm:p-6 space-y-4 overflow-y-auto flex-1 bg-white">
            
            <!-- Profesional Responsable -->
            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50/80 border border-slate-200/70">
                <div class="flex items-center gap-3">
                    <div class="relative shrink-0">
                        <img id="modalServicioBarberoFoto" 
                            src="" 
                            alt="Barbero" 
                            class="w-11 h-11 rounded-xl object-cover border-2 border-amber-400/50 shadow-2xs hidden"
                            onerror="this.classList.add('hidden'); document.getElementById('modalServicioBarberoInitial').classList.remove('hidden');">
                        <div id="modalServicioBarberoInitial" class="w-11 h-11 rounded-xl bg-gradient-to-br from-slate-900 to-[#14151b] text-[#c5a059] border border-[#c5a059]/40 flex items-center justify-center font-bold text-base font-serif shadow-2xs">
                            B
                        </div>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Especialista Asignado</span>
                        <h4 id="modalServicioBarberoNombre" class="text-sm font-bold text-slate-900 leading-tight">Nombre del Barbero</h4>
                    </div>
                </div>
            </div>

            <!-- Ficha de Métricas Duales: Tarifa y Duración -->
            <div class="grid grid-cols-2 gap-3">
                <!-- Tarifa -->
                <div class="p-3.5 rounded-2xl bg-amber-50/40 border border-amber-200/70 flex flex-col justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800/80">Tarifa del Servicio</span>
                    <div class="mt-1 flex items-baseline gap-1">
                        <span id="modalServicioPrecio" class="text-xl sm:text-2xl font-extrabold text-amber-950 font-arial tabular-nums">
                            $0
                        </span>
                        <span class="text-[10px] font-bold text-amber-800">COP</span>
                    </div>
                </div>

                <!-- Duración Estimada -->
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Tiempo Estimado</span>
                    <div class="mt-1 flex items-center gap-1.5 text-slate-900">
                        <i data-lucide="clock" class="w-4 h-4 text-amber-600"></i>
                        <span id="modalServicioDuracion" class="text-xl sm:text-2xl font-extrabold font-arial tabular-nums">
                            45
                        </span>
                        <span class="text-xs font-semibold text-slate-500">minutos</span>
                    </div>
                </div>
            </div>

            <!-- Descripción del Servicio -->
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1.5">Detalles del Corte</span>
                <p id="modalServicioDescripcion" class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-slate-50/50 p-3.5 rounded-xl border border-slate-100 min-h-[4rem]">
                    Detalles del corte
                </p>
            </div>

        </div>

        <!-- Footer con Acciones -->
        <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-3 shrink-0">
            <button type="button" 
                    onclick="closeModal('modalDetalleServicioCliente')" 
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-slate-900 text-xs font-semibold hover:bg-white transition-all cursor-pointer">
                Cerrar
            </button>

            <button type="button" 
                    id="btnAgendarDesdeServicio" 
                    onclick="agendarDesdeTarjetaServicio()" 
                    class="flex-1 py-2.5 px-4 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-md shadow-amber-500/20 transition-all cursor-pointer active:scale-98">
                <i data-lucide="calendar-check" class="w-4 h-4"></i>
                <span>Agendar este Servicio</span>
            </button>
        </div>

    </div>
</div>

<script>
    let servicioActivoEnTarjeta = null;

    /**
     * Muestra la tarjeta detallada de un servicio seleccionado.
     */
    function verTarjetaServicio(servicioData, barberoNombre, barberoFoto) {
        servicioActivoEnTarjeta = servicioData;

        // Nombre y Descripción
        document.getElementById('modalServicioNombre').textContent = servicioData.nombre || 'Servicio';
        document.getElementById('modalServicioDescripcion').textContent = servicioData.descripcion && servicioData.descripcion.trim() !== '' 
            ? servicioData.descripcion 
            : 'Servicio personalizado con técnicas de alta barbería, perfilado y acabado prémium.';

        // Precio formateado
        const precioFormatted = new Intl.NumberFormat('es-CO', { 
            style: 'currency', 
            currency: 'COP', 
            maximumFractionDigits: 0 
        }).format(servicioData.precio || 0);
        document.getElementById('modalServicioPrecio').textContent = precioFormatted.replace('COP', '').trim();

        // Duración
        document.getElementById('modalServicioDuracion').textContent = servicioData.duracion_min || 45;

        // Barbero Asignado
        document.getElementById('modalServicioBarberoNombre').textContent = barberoNombre || 'Barbero Profesional';
        const initialDiv = document.getElementById('modalServicioBarberoInitial');
        const fotoImg = document.getElementById('modalServicioBarberoFoto');

        if (barberoFoto && barberoFoto.trim() !== '' && !barberoFoto.endsWith('/')) {
            fotoImg.src = barberoFoto;
            fotoImg.classList.remove('hidden');
            initialDiv.classList.add('hidden');
        } else {
            fotoImg.classList.add('hidden');
            initialDiv.classList.remove('hidden');
            initialDiv.textContent = (barberoNombre ? barberoNombre.charAt(0) : 'B').toUpperCase();
        }

        // Imagen del Corte / Servicio
        const imgElement = document.getElementById('modalServicioImg');
        const placeholder = document.getElementById('modalServicioPlaceholder');

        if (servicioData.imagen && servicioData.imagen.trim() !== '') {
            imgElement.src = servicioData.imagen;
            imgElement.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            imgElement.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        // Renderizar iconos de Lucide dinámicos
        if (window.lucide) {
            lucide.createIcons();
        }

        // Abrir el modal con la función global
        if (typeof openModal === 'function') {
            openModal('modalDetalleServicioCliente');
        } else {
            document.getElementById('modalDetalleServicioCliente').classList.remove('hidden');
        }
    }

    /**
     * Pasa de la tarjeta del servicio directamente al modal de agendamiento.
     */
    function agendarDesdeTarjetaServicio() {
        if (!servicioActivoEnTarjeta) return;

        const idBarbero = servicioActivoEnTarjeta.id_barbero;
        const idServicio = servicioActivoEnTarjeta.id_servicio;

        if (typeof closeModal === 'function') {
            closeModal('modalDetalleServicioCliente');
        } else {
            document.getElementById('modalDetalleServicioCliente').classList.add('hidden');
        }

        // Invoca el modal de reserva inteligente con barbero y servicio ya seleccionados
        if (typeof seleccionarBarberoParaReserva === 'function') {
            seleccionarBarberoParaReserva(idBarbero, idServicio);
        }
    }
</script>

