@extends('layouts.app')

@section('title', 'Dashboard Administrador')
@section('breadcrumb', 'Dashboard')



@section('content')
@php
    $carbonFecha = \Carbon\Carbon::parse($fecha);
    $fechaAnterior = $carbonFecha->copy()->subDay()->toDateString();
    $fechaSiguiente = $carbonFecha->copy()->addDay()->toDateString();
    $esHoy = $fecha === now()->toDateString();
@endphp

<div class="space-y-6">


    <!-- Header Greeting & Date Navigation Form -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 font-serif">
                    Panel de Operaciones
                </h1>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $esHoy ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                    <span class="w-2 h-2 rounded-full {{ $esHoy ? 'bg-amber-500 animate-pulse' : 'bg-slate-400' }}"></span>
                    {{ $esHoy ? 'Jornada de Hoy' : 'Fecha Histórica' }}
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Gestión en tiempo real de citas, flujo de sala de espera, barberos y servicios activos.
            </p>
        </div>

        <!-- Formulario selector de fecha interactivo con navegación día a día -->
        <form method="GET" action="{{ route('admin.dashboard1') }}" class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
            <!-- Botón Día Anterior -->
            <a href="{{ route('admin.dashboard1', ['fecha' => $fechaAnterior]) }}" 
            class="p-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 text-slate-700 rounded-xl transition-all shadow-2xs hover:shadow-xs" 
            title="Día anterior ({{ \Carbon\Carbon::parse($fechaAnterior)->isoFormat('D MMM') }})">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </a>

            <!-- Selector de fecha nativo estilizado -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-amber-500">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </span>
                <input type="date" 
                    name="fecha" 
                    value="{{ $fecha }}" 
                    onchange="this.form.submit()"
                    class="pl-9 pr-3 py-2 bg-slate-50 hover:bg-white border border-slate-200/90 text-slate-800 rounded-xl text-xs sm:text-sm font-bold shadow-2xs outline-none focus:ring-2 focus:ring-amber-400/30 transition-all cursor-pointer">
            </div>

            <!-- Botón Día Siguiente -->
            <a href="{{ route('admin.dashboard1', ['fecha' => $fechaSiguiente]) }}" 
            class="p-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 text-slate-700 rounded-xl transition-all shadow-2xs hover:shadow-xs" 
            title="Día siguiente ({{ \Carbon\Carbon::parse($fechaSiguiente)->isoFormat('D MMM') }})">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>

            <!-- Botón Regresar a Hoy (si es otra fecha) -->
            @if(!$esHoy)
                <a href="{{ route('admin.dashboard1') }}" 
                class="px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/70 rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-1.5" 
                title="Regresar a hoy">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-amber-600"></i>
                    <span>Hoy</span>
                </a>
            @endif
        </form>
    </div>

    <!-- 4 KPI Stat Cards (100% Dinámicos desde BD) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Citas de la Fecha -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Citas de la Fecha</span>
                <span class="p-2.5 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="calendar-check-2" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">{{ $totalCitasHoy }}</h3>
                <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2.5 py-0.5 rounded-full">
                    <span class="font-arial font-bold">{{ $citasAceptadas }}</span>&nbsp;Aceptadas
                </span>
            </div>
            <div class="mt-2.5 flex items-center gap-2 text-xs text-slate-400">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                <span><span class="font-arial font-semibold text-slate-500">{{ $citasPendientes }}</span> pendientes de confirmar</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
        </div>

        <!-- Turnos en Sala -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Turnos en Sala</span>
                <span class="p-2.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="list-ordered" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">{{ $turnosEnSalaCount }}</h3>
                <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-100 border border-emerald-200 px-2.5 py-0.5 rounded-full">
                    <span class="font-arial font-bold">{{ $turnosEnAtencionCount }}</span>&nbsp;En Sillón
                </span>
            </div>
            <div class="mt-2.5 flex items-center gap-2 text-xs text-slate-400">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span><span class="font-arial font-semibold text-slate-500">{{ $turnosEnEsperaCount }}</span> clientes en sala de espera</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
        </div>

        <!-- Ingresos Proyectados -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ingresos Estimados</span>
                <span class="p-2.5 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="badge-dollar-sign" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">${{ number_format($ingresosEstimados, 0) }}</h3>
                <span class="inline-flex items-center text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200/60 px-2.5 py-0.5 rounded-full">
                    <span class="font-arial font-bold">{{ $citasCompletadas }}</span>&nbsp;Finalizadas
                </span>
            </div>
            <div class="mt-2.5 flex items-center gap-2 text-xs text-slate-400">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                <span>Cálculo según servicios programados</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-500"></div>
        </div>

        <!-- Barberos en Turno -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Barberos Activos</span>
                <span class="p-2.5 rounded-2xl bg-[#0f1015]/10 border border-slate-300 text-slate-800 group-hover:scale-110 transition-transform">
                    <i data-lucide="scissors" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4 flex items-baseline justify-between">
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">{{ $barberosActivosCount }}</h3>
                <span class="inline-flex items-center text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2.5 py-0.5 rounded-full">
                    Disponibles
                </span>
            </div>
            <div class="mt-2.5 flex items-center gap-2 text-xs text-slate-400">
                <span class="w-1.5 h-1.5 rounded-full bg-slate-800"></span>
                <span>Capacidad operativa registrada</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#182032]"></div>
        </div>
    </div>

    <!-- Main Content Layout (Citas Table & Side Widgets) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Citas Programadas Table (Col 8) -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
            <!-- Table Header Section -->
            <div class="p-5 sm:p-6 border-b border-slate-100 bg-white">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start sm:items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0 shadow-2xs">
                            <i data-lucide="calendar-days" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h2 class="text-lg font-bold text-slate-900 tracking-tight font-serif">
                                    Citas de la Jornada
                                </h2>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Control de itinerario y seguimiento en tiempo real del día</p>
                        </div>
                    </div>
                </div>

                <!-- Interactive Filter Tabs / Chips -->
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-1.5 sm:gap-2 overflow-x-auto pb-1 text-xs">
                    <span class="text-slate-400 font-semibold text-[11px] mr-1 hidden sm:inline">Estado:</span>
                    
                    <button type="button" onclick="filtrarCitas('TODAS')" id="tab-citas-TODAS" 
                            class="filter-tab-btn active px-3 py-1.5 rounded-xl font-bold transition-all flex items-center gap-1.5 bg-slate-900 text-white shadow-2xs cursor-pointer">
                        <span>Todas</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-700 text-slate-200 font-bold font-arial">{{ $totalCitasHoy }}</span>
                    </button>

                    <button type="button" onclick="filtrarCitas('PENDIENTE')" id="tab-citas-PENDIENTE" 
                            class="filter-tab-btn px-3 py-1.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-all flex items-center gap-1.5 cursor-pointer">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>Pendientes</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-amber-100 text-amber-800 font-bold font-arial">{{ $citasPendientes }}</span>
                    </button>

                    <button type="button" onclick="filtrarCitas('ACEPTADA')" id="tab-citas-ACEPTADA" 
                            class="filter-tab-btn px-3 py-1.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-all flex items-center gap-1.5 cursor-pointer">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Aceptadas</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold font-arial">{{ $citasAceptadas }}</span>
                    </button>

                    <button type="button" onclick="filtrarCitas('COMPLETADA')" id="tab-citas-COMPLETADA" 
                            class="filter-tab-btn px-3 py-1.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-all flex items-center gap-1.5 cursor-pointer">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                        <span>Finalizadas</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-100 text-slate-700 font-bold font-arial">{{ $citasCompletadas }}</span>
                    </button>

                    <button type="button" onclick="filtrarCitas('CANCELADA')" id="tab-citas-CANCELADA" 
                            class="filter-tab-btn px-3 py-1.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-all flex items-center gap-1.5 cursor-pointer">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        <span>Canceladas</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-rose-100 text-rose-800 font-bold font-arial">{{ $citasCanceladas }}</span>
                    </button>
                </div>
            </div>

            <!-- Lista Vertical de Clientes / Citas con Desplazamiento Hacia Abajo (Sin Scroll Horizontal) -->
            <div class="overflow-y-auto max-h-[580px] p-4 sm:p-5 space-y-3 flex-1 divide-y-0" style="scrollbar-width: thin;">
                @forelse($citas as $cita)
                    <div class="cita-row group p-4 rounded-2xl bg-white hover:bg-slate-50/90 border border-slate-200/80 hover:border-amber-400/50 shadow-2xs hover:shadow-xs transition-all" 
                        data-estado="{{ $cita->estado }}">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3.5">
                            
                            <!-- Izquierda: Hora + Información del Cliente -->
                            <div class="flex items-center gap-3.5 min-w-0">
                                <!-- Hora con insignia destacada -->
                                <div class="flex flex-col items-center justify-center px-3 py-2 rounded-xl bg-slate-100 border border-slate-200/90 text-slate-800 shrink-0">
                                    <span class="text-xs font-extrabold font-arial tracking-tight">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i') }}</span>
                                    <span class="text-[10px] font-bold text-amber-700 uppercase font-arial">{{ \Carbon\Carbon::parse($cita->hora)->format('A') }}</span>
                                </div>

                                <!-- Avatar + Nombre + Teléfono -->
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-800 to-slate-950 text-amber-400 font-bold text-xs flex items-center justify-center shrink-0 border border-amber-500/30 shadow-2xs overflow-hidden">
                                        @if($cita->cliente && $cita->cliente->foto_perfil)
                                            <img src="{{ asset($cita->cliente->foto_perfil) }}" 
                                                alt="{{ $cita->cliente->nombre }}" 
                                                class="w-full h-full object-cover"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span style="display: none;" class="w-full h-full items-center justify-center">
                                                {{ strtoupper(substr($cita->cliente->nombre ?? 'C', 0, 2)) }}
                                            </span>
                                        @else
                                            {{ strtoupper(substr($cita->cliente->nombre ?? 'C', 0, 2)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-900 text-sm truncate group-hover:text-amber-800 transition-colors">
                                            {{ $cita->cliente->nombre ?? 'Cliente no registrado' }}
                                        </h4>
                                        <p class="text-xs text-slate-400 flex items-center gap-1.5 mt-0.5">
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <span class="font-arial">{{ $cita->cliente->telefono ?? ($cita->cliente->numero_identificacion ?? 'Sin tel') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Centro: Barbero asignado + Servicio & Precio -->
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <!-- Barbero -->
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-slate-100/90 border border-slate-200/70 text-xs font-semibold text-slate-700">
                                    <i data-lucide="scissors" class="w-3.5 h-3.5 text-amber-600"></i>
                                    <span>{{ $cita->barbero->nombre ?? 'Sin barbero' }}</span>
                                </span>

                                <!-- Servicio con precio en dorado -->
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50/70 border border-amber-200/60 text-xs font-semibold text-slate-800">
                                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i>
                                    <span>{{ $cita->servicio->nombre ?? 'Servicio general' }}</span>
                                    <strong class="text-amber-700 font-bold font-arial ml-1">${{ number_format($cita->servicio->precio ?? 0, 0) }}</strong>
                                </span>
                            </div>

                            <!-- Derecha: Estado + Acciones Funcionales -->
                            <div class="flex items-center justify-between lg:justify-end gap-3 shrink-0 pt-2.5 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                                <!-- Insignia de Estado -->
                                @if($cita->estado === 'ACEPTADA')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        ACEPTADA
                                    </span>
                                @elseif($cita->estado === 'PENDIENTE')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/80 shadow-2xs">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                        PENDIENTE
                                    </span>
                                @elseif($cita->estado === 'REPROGRAMADA')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200/80 shadow-2xs">
                                        <i data-lucide="refresh-cw" class="w-3 h-3 text-purple-600"></i>
                                        REPROGRAMADA
                                    </span>
                                @elseif($cita->estado === 'COMPLETADA')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                                        <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                                        COMPLETADA
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/80 shadow-2xs">
                                        <i data-lucide="x" class="w-3 h-3 text-rose-600"></i>
                                        CANCELADA
                                    </span>
                                @endif

                                <!-- Botones de Acción Rápida -->
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Si está pendiente: Botón para ACEPTAR -->
                                    @if($cita->estado === 'PENDIENTE')
                                        <form method="POST" action="{{ route('admin.citas.estado', $cita) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="ACEPTADA">
                                            <button type="submit" class="p-2 text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 rounded-xl transition-all shadow-2xs cursor-pointer" title="Aceptar Cita">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Si está aceptada: Botón para COMPLETAR -->
                                    @if($cita->estado === 'ACEPTADA')
                                        <form method="POST" action="{{ route('admin.citas.estado', $cita) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="COMPLETADA">
                                            <button type="submit" class="p-2 text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200/80 rounded-xl transition-all shadow-2xs cursor-pointer" title="Marcar como Completada">
                                                <i data-lucide="check-check" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Botón para CANCELAR si no está ya cancelada o completada -->
                                    @if(!in_array($cita->estado, ['CANCELADA', 'COMPLETADA']))
                                        <button type="button" 
                                                onclick="abrirModalCancelar('{{ $cita->id_cita }}')" 
                                                class="p-2 text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200/80 rounded-xl transition-all shadow-2xs cursor-pointer" 
                                                title="Cancelar Cita">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <!-- Observación o Motivo de Cancelación si existe -->
                        @if(!empty($cita->observacion) || $cita->estado === 'CANCELADA')
                            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-2 text-xs text-slate-500">
                                @if($cita->estado === 'CANCELADA')
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-rose-500 shrink-0"></i>
                                    <span class="text-rose-700 font-medium"><strong class="font-bold">Motivo de cancelación:</strong> {{ $cita->motivo_cancelacion ?? 'Cancelada' }}</span>
                                @else
                                    <i data-lucide="message-square" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                    <span class="text-slate-600"><strong class="font-semibold text-slate-700">Observación:</strong> {{ $cita->observacion }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <!-- Empty State Rediseñado con Estética Premium -->
                    <div class="py-16 px-4 text-center">
                        <div class="max-w-md mx-auto flex flex-col items-center">
                            <!-- Ambient Icon Box -->
                            <div class="relative mb-4">
                                <div class="w-16 h-16 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shadow-inner">
                                    <i data-lucide="calendar-clock" class="w-8 h-8 text-amber-600"></i>
                                </div>
                                <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white border border-slate-200 text-amber-600 flex items-center justify-center shadow-xs">
                                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 tracking-tight font-serif">
                                Sin citas registradas para esta fecha
                            </h3>
                            <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                                No hay reservas agendadas en esta jornada. Puedes explorar las fechas en el calendario superior.
                            </p>

                            @if(!$esHoy)
                                <div class="mt-5">
                                    <a href="{{ route('admin.dashboard1') }}" 
                                       class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors inline-flex items-center gap-1.5">
                                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                        <span>Ir a Hoy</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforelse

                <!-- Elemento invisible para cuando el filtro no coincide con ninguna cita -->
                <div id="row-no-filtered-results" class="hidden py-12 px-4 text-center">
                    <div class="flex flex-col items-center justify-center text-slate-400">
                        <i data-lucide="filter-x" class="w-7 h-7 mb-2 text-slate-300"></i>
                        <p class="text-xs font-bold text-slate-700">No hay citas con este estado</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Selecciona la pestaña "Todas" para ver el itinerario completo.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Turnos en Sala & Reprogramaciones (Col 4) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Widget 1: Cola de Turnos en Sala (Tabla 'turnos') -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
                <div>
                    <!-- Header con Indicador de Estado En Vivo -->
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 flex items-center justify-center shrink-0">
                                <i data-lucide="list-ordered" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-slate-900 font-serif">Turnos en Sala</h3>
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        En vivo
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400">Sala de espera en tiempo real</p>
                            </div>
                        </div>
                    </div>


                    <!-- Lista de Turnos Dinámica -->
                    <div class="space-y-3">
                        @forelse($turnos as $turno)
                            @if($turno->estado === 'EN_ATENCION')
                                <!-- Turno EN_ATENCION -->
                                <div class="p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 flex items-center justify-between gap-3 shadow-2xs">
                                    <div class="flex items-center gap-3">
                                        <span class="w-9 h-9 rounded-xl bg-emerald-600 text-white font-extrabold flex items-center justify-center text-sm shadow-xs shrink-0 font-arial">
                                            #{{ str_pad($turno->posicion, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <div>
                                            <h4 class="text-xs sm:text-sm font-bold text-slate-900">{{ $turno->cliente->nombre ?? 'Cliente' }}</h4>
                                            <p class="text-[11px] text-emerald-700 font-medium flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                                                En Atención • {{ $turno->cita->barbero->nombre ?? 'Barbero' }}
                                            </p>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('admin.turnos.finalizar', $turno) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white shadow-xs transition-all cursor-pointer flex items-center gap-1">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i>
                                            <span>Finalizar</span>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <!-- Turno EN_ESPERA -->
                                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-3 hover:bg-slate-100/70 transition-all shadow-2xs">
                                    <div class="flex items-center gap-3">
                                        <span class="w-9 h-9 rounded-xl bg-slate-200 text-slate-700 font-extrabold flex items-center justify-center text-sm shrink-0 font-arial">
                                            #{{ str_pad($turno->posicion, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <div>
                                            <h4 class="text-xs sm:text-sm font-bold text-slate-800">{{ $turno->cliente->nombre ?? 'Cliente' }}</h4>
                                            <p class="text-[11px] text-slate-500">Posición en cola: <span class="font-arial font-bold text-slate-700">{{ $turno->posicion }}</span></p>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('admin.turnos.llamar', $turno) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs transition-all cursor-pointer flex items-center gap-1">
                                            <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                                            <span>Llamar</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @empty
                            <!-- Empty State de Turnos Rediseñado -->
                            <div class="py-8 text-center text-slate-400 flex flex-col items-center">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 flex items-center justify-center mb-2.5">
                                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-800">No hay clientes esperando en sala</p>
                                <p class="text-[11px] text-slate-400 max-w-[210px] mt-0.5">La sala se encuentra despejada en este momento.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Footer del Widget -->
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span class="font-medium">Total en cola: <strong class="text-slate-900 font-bold">{{ $turnosEnEsperaCount }}</strong></span>
                    <a href="{{ route('admin.turnos.index') }}" class="font-bold text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1 group transition-colors">
                        <span>Ver sala de turnos</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Widget 2: Reprogramaciones Pendientes (Tabla 'reprogramaciones') -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-2xl bg-purple-500/10 border border-purple-500/20 text-purple-600 flex items-center justify-center shrink-0">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 font-serif">Reprogramaciones</h3>
                            <p class="text-xs text-slate-400">Solicitudes de cambio</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-purple-700 bg-purple-50 px-2.5 py-0.5 rounded-full border border-purple-200/80">
                        {{ $reprogramaciones->count() }} Pendiente(s)
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($reprogramaciones as $reprog)
                        <div class="p-3.5 rounded-2xl bg-purple-50/50 border border-purple-200/70 shadow-2xs">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-xs font-bold text-slate-900">
                                        {{ $reprog->cita->cliente->nombre ?? 'Cliente' }}
                                        <span class="text-slate-400 font-normal">#{{ $reprog->id_cita }}</span>
                                    </p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Solicita cambio de horario:</p>
                                    <div class="mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-white border border-purple-200/80 text-xs font-bold text-purple-900 shadow-2xs">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-purple-600"></i>
                                        <span>{{ \Carbon\Carbon::parse($reprog->nueva_fecha)->isoFormat('dddd, D [de] MMMM') }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span>{{ \Carbon\Carbon::parse($reprog->nueva_hora)->format('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center gap-2">
                                <!-- Formulario Aprobar -->
                                <form method="POST" action="{{ route('admin.reprogramaciones.gestionar', $reprog) }}" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="accion" value="aprobar">
                                    <button type="submit" class="w-full py-2 px-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold shadow-2xs transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        <span>Aprobar</span>
                                    </button>
                                </form>

                                <!-- Formulario Rechazar -->
                                <form method="POST" action="{{ route('admin.reprogramaciones.gestionar', $reprog) }}" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="accion" value="rechazar">
                                    <button type="submit" class="w-full py-2 px-3 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                        <span>Rechazar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State Reprogramaciones Rediseñado -->
                        <div class="py-6 text-center text-slate-400 flex flex-col items-center">
                            <div class="w-11 h-11 rounded-2xl bg-purple-500/10 border border-purple-500/20 text-purple-600 flex items-center justify-center mb-2">
                                <i data-lucide="calendar-check" class="w-5 h-5"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-800">No hay solicitudes de reprogramación pendientes</p>
                            <p class="text-[11px] text-slate-400 max-w-[210px] mt-0.5">Todas las peticiones han sido gestionadas correctamente.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>

<!--MODALES FUNCIONALES-->

<!-- 2. Modal Cancelar Cita -->
<div id="modalCancelarCita" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-600 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-octagon" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-rose-600 font-serif">Cancelar Cita</h3>
                    <p class="text-xs text-slate-400">Acción de cancelación</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalCancelarCita')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="formCancelarCita" method="POST" action="" class="mt-5 space-y-4">
            @csrf
            @method('PATCH')
            <input type="hidden" name="estado" value="CANCELADA">

            <p class="text-sm text-slate-600 leading-relaxed">
                ¿Estás seguro de que deseas marcar esta cita como cancelada? Por favor ingresa el motivo para registro de auditoría.
            </p>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Motivo de Cancelación *</label>
                <textarea name="motivo_cancelacion" required rows="3" placeholder="Ej: Cliente canceló por llamada telefónica..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-rose-500 transition-all font-medium"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalCancelarCita')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Regresar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-md transition-all cursor-pointer">
                    Confirmar Cancelación
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function abrirModalCancelar(citaId) {
        const form = document.getElementById('formCancelarCita');
        form.action = `/administrador/citas/${citaId}/estado`;
        openModal('modalCancelarCita');
    }

    // Filtrado interactivo en tiempo real de filas de citas
    function filtrarCitas(estado) {
        const rows = document.querySelectorAll('.cita-row');
        const tabs = document.querySelectorAll('.filter-tab-btn');
        let visibles = 0;

        // Reset tab styles
        tabs.forEach(tab => {
            tab.classList.remove('bg-slate-900', 'text-white', 'shadow-2xs');
            tab.classList.add('text-slate-600', 'hover:bg-slate-100');
        });

        // Set active tab style
        const activeTab = document.getElementById(`tab-citas-${estado}`);
        if (activeTab) {
            activeTab.classList.remove('text-slate-600', 'hover:bg-slate-100');
            activeTab.classList.add('bg-slate-900', 'text-white', 'shadow-2xs');
        }

        // Show/Hide matching rows
        rows.forEach(row => {
            const rowEstado = row.getAttribute('data-estado');
            if (estado === 'TODAS' || rowEstado === estado) {
                row.style.display = '';
                visibles++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mostrar u ocultar mensaje de ningún resultado para este filtro
        const emptyFilteredRow = document.getElementById('row-no-filtered-results');
        if (emptyFilteredRow) {
            if (visibles === 0 && rows.length > 0) {
                emptyFilteredRow.classList.remove('hidden');
            } else {
                emptyFilteredRow.classList.add('hidden');
            }
        }
    }
</script>
@endpush
