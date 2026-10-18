<!-- MODAL: AGENDAR CITA CON SELECCIÓN INTELIGENTE DE HORARIOS -->
<div id="modalNuevaReservaCliente" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl border border-slate-200/80 overflow-hidden transform transition-all flex flex-col max-h-[92vh]">
        
        <!-- Header del Modal con estilo Artisan Luxury -->
        <div class="bg-[#0b0c10] px-4 sm:px-6 py-4 sm:py-5 text-white flex items-center justify-between border-b border-[#c5a059]/30 shrink-0">
            <div class="flex items-center gap-3 sm:gap-3.5 min-w-0 mr-2">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl overflow-hidden border border-[#c5a059]/40 shadow-sm shrink-0">
                    <img src="{{ asset('images/barber-sidebar-logo.jpg') }}" alt="Emblema Barbershop" class="w-full h-full object-cover block">
                </div>
                <div class="min-w-0">
                    <h3 class="font-serif font-bold text-base sm:text-xl text-[#c5a059] tracking-tight truncate">Agendar Cita Personalizada</h3>
                    <p class="text-[11px] sm:text-xs text-slate-300 mt-0.5 line-clamp-1">Selecciona tu barbero, servicio y horario disponible en tiempo real.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalNuevaReservaCliente')" class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-slate-800 transition-colors cursor-pointer shrink-0" title="Cerrar ventana">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Formulario con scroll si es necesario -->
        <form id="formReservaCliente" action="{{ route('cliente.citas.store') }}" method="POST" class="p-4 sm:p-6 space-y-3.5 sm:space-y-4 overflow-y-auto flex-1">
            @csrf

            <!-- 1. Selección de Barbero -->
            <div>
                <label for="modalSelectBarbero" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-amber-100 text-amber-900 border border-amber-300/80 text-[10px] font-bold flex items-center justify-center">1</span>
                    <span>Elige tu Barbero Preferido <span class="text-amber-600">*</span></span>
                </label>
                <div class="relative">
                    <select name="id_barbero" id="modalSelectBarbero" required onchange="handleModalBarberoChange(this.value)"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-[#c5a059] focus:ring-2 focus:ring-[#c5a059]/20 text-sm text-slate-800 bg-slate-50/50 hover:bg-white focus:bg-white font-medium outline-none transition-all cursor-pointer shadow-2xs">
                        <option value="">-- Selecciona un profesional --</option>
                        @php
                            $barberosParaModal = $todosLosBarberos ?? $barberos;
                        @endphp
                        @if(isset($barberosParaModal))
                            @foreach($barberosParaModal as $barbero)
                                <option value="{{ $barbero->id_usuario }}" data-nombre="{{ $barbero->nombre }}">
                                    {{ $barbero->nombre }} ({{ $barbero->especialidad ?? 'Barbero Profesional' }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <!-- 2. Selección de Servicio -->
            <div>
                <label for="modalSelectServicio" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-amber-100 text-amber-900 border border-amber-300/80 text-[10px] font-bold flex items-center justify-center">2</span>
                    <span>Servicio del Barbero <span class="text-amber-600">*</span></span>
                </label>
                <div class="relative">
                    <select name="id_servicio" id="modalSelectServicio" required onchange="handleModalServicioChange()"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-[#c5a059] focus:ring-2 focus:ring-[#c5a059]/20 text-sm text-slate-800 bg-slate-50/50 hover:bg-white focus:bg-white font-medium outline-none transition-all cursor-pointer shadow-2xs">
                        <option value="">-- Primero selecciona un barbero --</option>
                    </select>
                </div>
                <p id="modalServicioHelper" class="text-[11px] text-slate-500 mt-1.5 font-medium">El listado muestra tarifas y duración exclusiva de cada corte o técnica.</p>
            </div>

            <!-- 3. Selección de Fecha -->
            <div>
                <label for="modalInputFecha" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-md bg-amber-100 text-amber-900 border border-amber-300/80 text-[10px] font-bold flex items-center justify-center">3</span>
                    <span>Fecha de la Cita <span class="text-amber-600">*</span></span>
                </label>
                <div class="relative">
                    <input type="date" name="fecha" id="modalInputFecha" 
                        min="{{ now()->toDateString() }}" 
                        value="{{ now()->toDateString() }}" 
                        required 
                        onchange="handleModalFechaChange()"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-[#c5a059] focus:ring-2 focus:ring-[#c5a059]/20 text-sm text-slate-800 bg-slate-50/50 hover:bg-white focus:bg-white font-medium outline-none transition-all cursor-pointer shadow-2xs">
                </div>
            </div>

            <!-- 4. Selección Interactiva de Horarios Disponibles -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-amber-100 text-amber-900 border border-amber-300/80 text-[10px] font-bold flex items-center justify-center">4</span>
                        <span>Horario Disponible <span class="text-amber-600">*</span></span>
                    </label>
                    <span id="modalSlotsStatusBadge" class="text-[11px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200/70"></span>
                </div>

                <!-- Input oculto que enviará la hora seleccionada -->
                <input type="hidden" name="hora" id="modalInputHora" required>

                <!-- Estado de Carga -->
                <div id="modalSlotsLoading" class="hidden py-6 text-center bg-slate-50 rounded-2xl border border-slate-200/80 shadow-2xs">
                    <div class="inline-block animate-spin w-6 h-6 border-2 border-[#c5a059] border-t-transparent rounded-full mb-2"></div>
                    <p class="text-xs text-slate-500 font-medium">Consultando horarios libres en tiempo real...</p>
                </div>

                <!-- Contenedor de Botones de Franjas Horarias -->
                <div id="modalSlotsGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 max-h-40 overflow-y-auto p-2.5 bg-slate-50/80 rounded-2xl border border-slate-200/90 shadow-2xs">
                    <div class="col-span-full py-4 text-center text-xs text-slate-400">
                        Selecciona un barbero, servicio y fecha para calcular los turnos disponibles.
                    </div>
                </div>

                <!-- Estado Vacío / Sin disponibilidad -->
                <div id="modalSlotsEmpty" class="hidden py-4 px-3 text-center bg-amber-50/80 rounded-2xl border border-amber-200/80 text-xs text-amber-900">
                    <i data-lucide="calendar-x" class="w-5 h-5 mx-auto mb-1 text-amber-600"></i>
                    <p class="font-bold">Sin disponibilidad en esta fecha</p>
                    <p class="text-[11px] text-amber-800/80 mt-0.5">El barbero tiene su agenda completa o está en receso. Intenta con otra fecha o profesional.</p>
                </div>

                <p id="modalHoraSeleccionadaTxt" class="text-xs font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200/80 p-2 rounded-xl mt-2 hidden flex items-center gap-1.5">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                    <span>Hora seleccionada: <strong id="modalHoraValDisplay" class="text-slate-900 font-arial font-bold text-xs"></strong></span>
                </p>
            </div>

            <!-- 5. Observaciones opcionales -->
            <div>
                <label for="modalInputObservacion" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold flex items-center justify-center">5</span>
                        <span>Instrucciones o notas para tu estilo</span>
                    </span>
                    <span class="text-[10px] font-semibold text-slate-400 lowercase">(opcional)</span>
                </label>
                <textarea name="observacion" id="modalInputObservacion" rows="2" maxlength="500" 
                    placeholder="Ej: Degradado bajo con navaja, perfilado de barba, recorte suave arriba..."
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-[#c5a059] focus:ring-2 focus:ring-[#c5a059]/20 text-sm text-slate-800 bg-slate-50/50 hover:bg-white focus:bg-white outline-none resize-none transition-all shadow-2xs"></textarea>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-end gap-2 sm:gap-3 shrink-0">
                <button type="button" onclick="closeModal('modalNuevaReservaCliente')"
                    class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" id="btnSubmitReservaCliente"
                    class="px-5 sm:px-6 py-2 sm:py-2.5 rounded-xl text-slate-950 gold-gradient gold-gradient-hover text-xs font-bold uppercase tracking-wider shadow-sm hover:shadow-md transition-all cursor-pointer flex items-center gap-2">
                    <i data-lucide="calendar-check" class="w-4 h-4"></i>
                    <span>Confirmar Reserva</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Catálogo de barberos y sus servicios disponible globalmente
    const barberosModalCatalog = @json(isset($todosLosBarberos) ? $todosLosBarberos : (isset($barberos) && method_exists($barberos, 'items') ? $barberos->items() : ($barberos ?? [])));

    // Abre el modal y preselecciona barbero y servicio si se pasan
    function seleccionarBarberoParaReserva(idBarbero, idServicio = null) {
        const selectBarbero = document.getElementById('modalSelectBarbero');
        if (selectBarbero) {
            selectBarbero.value = idBarbero;
            actualizarServiciosModal(idBarbero, idServicio);
            openModal('modalNuevaReservaCliente');
        }
    }

    function handleModalBarberoChange(idBarbero) {
        actualizarServiciosModal(idBarbero);
    }

    function handleModalServicioChange() {
        consultarHorariosDisponiblesModal();
    }

    function handleModalFechaChange() {
        consultarHorariosDisponiblesModal();
    }

    function actualizarServiciosModal(idBarbero, preselectServicioId = null) {
        const selectServicio = document.getElementById('modalSelectServicio');
        const helperText = document.getElementById('modalServicioHelper');
        const horaInput = document.getElementById('modalInputHora');
        
        horaInput.value = '';
        document.getElementById('modalHoraSeleccionadaTxt').classList.add('hidden');
        selectServicio.innerHTML = '';

        if (!idBarbero) {
            selectServicio.innerHTML = '<option value="">-- Primero selecciona un barbero --</option>';
            helperText.innerText = 'El listado muestra tarifas y duración exclusiva de cada corte o técnica.';
            limpiarGridHorarios('Selecciona un barbero, servicio y fecha para calcular los turnos disponibles.');
            return;
        }

        const barbero = barberosModalCatalog.find(b => b.id_usuario == idBarbero);

        if (!barbero || !barbero.servicios || barbero.servicios.length === 0) {
            selectServicio.innerHTML = '<option value="">-- Este barbero no tiene servicios asignados --</option>';
            helperText.innerHTML = '<span class="inline-flex items-center gap-1.5 text-amber-800 font-semibold bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200/80"><i data-lucide="alert-circle" class="w-3.5 h-3.5 text-amber-600"></i> Por favor selecciona otro profesional del equipo.</span>';
            if (window.lucide) { lucide.createIcons(); }
            limpiarGridHorarios('Este barbero no posee servicios configurados.');
            return;
        }

        selectServicio.innerHTML = '<option value="">-- Selecciona el servicio deseado --</option>';
        barbero.servicios.forEach(s => {
            const precioFormatted = new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 }).format(s.precio);
            const option = document.createElement('option');
            option.value = s.id_servicio;
            option.textContent = `${s.nombre} - ${precioFormatted} (${s.duracion_min ?? 45} min)`;
            if (preselectServicioId && s.id_servicio == preselectServicioId) {
                option.selected = true;
            }
            selectServicio.appendChild(option);
        });

        helperText.innerText = `${barbero.servicios.length} servicio(s) disponible(s) con ${barbero.nombre}.`;

        if (preselectServicioId) {
            consultarHorariosDisponiblesModal();
        } else {
            limpiarGridHorarios('Ahora elige el servicio para calcular la duración y horarios disponibles.');
        }
    }

    function limpiarGridHorarios(mensaje) {
        const grid = document.getElementById('modalSlotsGrid');
        const emptyState = document.getElementById('modalSlotsEmpty');
        const loading = document.getElementById('modalSlotsLoading');
        const badge = document.getElementById('modalSlotsStatusBadge');
        
        loading.classList.add('hidden');
        emptyState.classList.add('hidden');
        grid.classList.remove('hidden');
        badge.innerText = '';
        grid.innerHTML = `<div class="col-span-full py-4 text-center text-xs text-slate-400">${mensaje}</div>`;
    }

    function consultarHorariosDisponiblesModal() {
        const idBarbero = document.getElementById('modalSelectBarbero').value;
        const idServicio = document.getElementById('modalSelectServicio').value;
        const fecha = document.getElementById('modalInputFecha').value;

        const grid = document.getElementById('modalSlotsGrid');
        const loading = document.getElementById('modalSlotsLoading');
        const emptyState = document.getElementById('modalSlotsEmpty');
        const badge = document.getElementById('modalSlotsStatusBadge');
        const horaInput = document.getElementById('modalInputHora');

        horaInput.value = '';
        document.getElementById('modalHoraSeleccionadaTxt').classList.add('hidden');

        if (!idBarbero || !idServicio || !fecha) {
            return;
        }

        grid.classList.add('hidden');
        emptyState.classList.add('hidden');
        loading.classList.remove('hidden');
        badge.innerText = 'Buscando...';

        const url = `{{ route('cliente.horarios.disponibles') }}?id_barbero=${idBarbero}&id_servicio=${idServicio}&fecha=${fecha}`;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Error al cargar horarios');
            return response.json();
        })
        .then(data => {
            loading.classList.add('hidden');

            if (!data.slots || data.slots.length === 0) {
                emptyState.classList.remove('hidden');
                grid.classList.add('hidden');
                badge.innerText = '0 disponibles';
                return;
            }

            badge.innerText = `${data.total_disponibles} disponibles (${data.duracion_min} min/cita)`;
            grid.innerHTML = '';
            grid.classList.remove('hidden');

            data.slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'slot-btn py-2 px-2.5 rounded-xl text-xs font-semibold border border-slate-200 bg-white hover:border-amber-500 hover:bg-amber-50 text-slate-800 transition-all flex items-center justify-center gap-1 cursor-pointer';
                btn.innerHTML = `<span>${slot.formato}</span>`;
                btn.onclick = () => seleccionarSlotHora(slot.hora, slot.formato, btn);
                grid.appendChild(btn);
            });
        })
        .catch(err => {
            console.error(err);
            loading.classList.add('hidden');
            grid.classList.remove('hidden');
            grid.innerHTML = `<div class="col-span-full py-4 text-center text-xs text-rose-500 font-medium">Error al cargar horarios. Intenta nuevamente.</div>`;
        });
    }

    function seleccionarSlotHora(hora24, formato12, btnElement) {
        document.getElementById('modalInputHora').value = hora24;

        // Remover estilos activos de todos los botones de slot
        document.querySelectorAll('.slot-btn').forEach(b => {
            b.classList.remove('bg-slate-900', 'text-[#c5a059]', 'border-slate-900', 'shadow-xs');
            b.classList.add('bg-white', 'text-slate-800', 'border-slate-200');
        });

        // Aplicar estilo activo al botón seleccionado
        btnElement.classList.remove('bg-white', 'text-slate-800', 'border-slate-200');
        btnElement.classList.add('bg-slate-900', 'text-[#c5a059]', 'border-slate-900', 'shadow-xs');

        // Mostrar aviso de hora seleccionada
        const displayTxt = document.getElementById('modalHoraSeleccionadaTxt');
        const valDisplay = document.getElementById('modalHoraValDisplay');
        valDisplay.innerText = `${formato12} (${hora24})`;
        displayTxt.classList.remove('hidden');
    }

    // Validación antes del envío
    document.getElementById('formReservaCliente')?.addEventListener('submit', function(e) {
        const hora = document.getElementById('modalInputHora').value;
        if (!hora) {
            e.preventDefault();
            Swal.fire({
                title: "Selecciona una hora",
                text: "Por favor pulsa sobre uno de los horarios libres disponibles para tu cita.",
                icon: "info",
                confirmButtonColor: "#c5a059",
                confirmButtonText: "Entendido"
            });
        }
    });
</script>
@endpush
