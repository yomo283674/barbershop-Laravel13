@extends('layouts.app')

@section('title', 'Mi Estación de Trabajo')
@section('breadcrumb', 'Barbero / Mi Estación')

@section('content')
<div class="space-y-6">


    <!-- 1. Header Operativo de la Estación -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Panel de Barbero
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Hola, <span class="font-semibold text-slate-800">{{ Auth::user()->nombre }}</span>. Bienvenido a tu estación de trabajo
            </p>
        </div>

        <!-- Selector y Navegador de Fecha de la Estación -->
        <div class="flex items-center">
            <form method="GET" action="{{ route('barbero.dashboard2') }}" id="formFechaBarbero" class="flex items-center gap-1 bg-slate-100/80 p-1 rounded-2xl border border-slate-200/80 shadow-2xs">
                <!-- Botón Día Anterior -->
                <a href="{{ route('barbero.dashboard2', ['fecha' => \Carbon\Carbon::parse($fecha)->subDay()->toDateString()]) }}" 
                class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-white transition-all shadow-2xs cursor-pointer active:scale-95"
                title="Día anterior">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>

                <!-- Píldora de Fecha Personalizada con Apertura de Calendario Nativo -->
                <div class="relative group">
                    <div class="px-3.5 py-1.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-200/80 text-slate-800 text-xs font-semibold flex items-center gap-2 shadow-2xs group-hover:border-amber-400/50 transition-all select-none">
                        <i data-lucide="calendar" class="w-4 h-4 text-amber-500 group-hover:scale-105 transition-transform"></i>
                        <span class="whitespace-nowrap capitalize-first">
                            @if(\Carbon\Carbon::parse($fecha)->isToday())
                                Hoy, {{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('D [de] MMMM') }}
                            @elseif(\Carbon\Carbon::parse($fecha)->isTomorrow())
                                Mañana, {{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('D [de] MMMM') }}
                            @elseif(\Carbon\Carbon::parse($fecha)->isYesterday())
                                Ayer, {{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('D [de] MMMM') }}
                            @else
                                {{ ucfirst(\Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('dddd, D [de] MMMM')) }}
                            @endif
                        </span>
                    </div>

                    <!-- Input nativo invisible que cubre el pill para disparar el selector al hacer clic -->
                    <input type="date" 
                        name="fecha" 
                        id="inputFechaDashboard" 
                        value="{{ $fecha }}" 
                        onchange="this.form.submit()"
                        class="absolute inset-0 opacity-0 w-full h-full cursor-pointer z-10"
                        title="Clic para seleccionar otra fecha">
                </div>

                <!-- Botón Día Siguiente -->
                <a href="{{ route('barbero.dashboard2', ['fecha' => \Carbon\Carbon::parse($fecha)->addDay()->toDateString()]) }}" 
                class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-white transition-all shadow-2xs cursor-pointer active:scale-95"
                title="Día siguiente">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>

                <!-- Botón 'Hoy' de acceso rápido (si no está en hoy) -->
                @if(!\Carbon\Carbon::parse($fecha)->isToday())
                    <a href="{{ route('barbero.dashboard2', ['fecha' => now()->toDateString()]) }}" 
                    class="px-2.5 py-1 text-[11px] font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/80 rounded-xl transition-all shadow-2xs cursor-pointer ml-0.5">
                        Hoy
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- 2. Stat Cards Métricas (Estructura Arquitectónica 3-Tier con Acabado Artesanal de Lujo) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Mis Citas Hoy (Ámbar) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Mis Citas Hoy</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="calendar" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $totalCitasHoy }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $citasPendientesCount > 0 ? 'bg-amber-50 text-amber-800 border border-amber-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $citasPendientesCount > 0 ? 'bg-amber-500 animate-pulse' : 'bg-slate-300' }}"></span>
                    {{ $citasPendientesCount }} por confirmar
                </span>
                <span class="text-[11px] font-medium text-slate-400">Total agendadas</span>
            </div>
        </div>

        <!-- 2. Turnos en Sala de Espera (Esmeralda) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-300/80 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">En Sala de Espera</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="users" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $turnosEnEsperaCount }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $turnosEnEsperaCount > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $turnosEnEsperaCount > 0 ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                    {{ $turnosEnEsperaCount > 0 ? 'En fila activa' : 'Cola de tu puesto' }}
                </span>
                <span class="text-[11px] font-medium text-slate-400">En tiempo real</span>
            </div>
        </div>

        <!-- 3. Comisión Estimada Hoy (Índigo) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-indigo-300/80 hover:shadow-lg hover:shadow-indigo-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-indigo-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría, Microchip de Tasa & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Mi Comisión Hoy</span>
                        <span class="px-1.5 py-0.5 text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/70 rounded-md">40%</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100/70 border border-indigo-200/80 text-indigo-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="badge-percent" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        ${{ number_format($comisionEstimadaHoy, 2) }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $citasCompletadasCount > 0 ? 'bg-indigo-50 text-indigo-800 border border-indigo-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $citasCompletadasCount > 0 ? 'bg-indigo-500' : 'bg-slate-300' }}"></span>
                    {{ $citasCompletadasCount }} {{ $citasCompletadasCount == 1 ? 'corte listo' : 'cortes listos' }}
                </span>
                <span class="text-[11px] font-medium text-slate-400">Estimado</span>
            </div>
        </div>

        <!-- 4. Portafolio de Servicios Propios (Ámbar / Oro) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Mis Servicios</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="scissors" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $serviciosPropiosCount }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto con Acción -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Catálogo activo
                </span>
                <a href="{{ route('barbero.servicios.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-amber-700 hover:text-amber-800 transition-colors group/link">
                    <span>Gestionar</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover/link:translate-x-0.5 transition-transform"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- 3. Consola de la Estación: "En Silla Ahora" (Active Station Console) -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#0b0c10] via-[#141620] to-[#08090c] p-5 sm:p-6 text-white shadow-xl border border-amber-500/25 before:absolute before:inset-x-0 before:top-0 before:h-px before:bg-gradient-to-r before:from-transparent before:via-amber-400/40 before:to-transparent">
        <!-- Destellos ámbar decorativos con iluminación ambiental -->
        <div class="absolute -right-16 -top-16 w-56 h-56 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-56 h-56 rounded-full bg-amber-500/5 blur-3xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 relative z-10">
            @if($turnoEnSilla)
                <!-- Estado A: Cliente en Silla -->
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-amber-500/20 to-amber-950/60 border border-amber-400/40 flex items-center justify-center shrink-0 font-serif text-amber-300 text-2xl font-bold shadow-lg shadow-amber-500/10 overflow-hidden">
                        @if($turnoEnSilla->cliente && $turnoEnSilla->cliente->foto_perfil)
                            <img src="{{ asset($turnoEnSilla->cliente->foto_perfil) }}" 
                                alt="{{ $turnoEnSilla->cliente->nombre }}" 
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <span style="display: none;" class="w-full h-full items-center justify-center">
                                {{ strtoupper(substr($turnoEnSilla->cliente->nombre ?? 'C', 0, 1)) }}
                            </span>
                        @else
                            {{ strtoupper(substr($turnoEnSilla->cliente->nombre ?? 'C', 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[11px] font-bold tracking-wider uppercase flex items-center gap-1.5 font-sans">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                EN ATENCIÓN EN SILLA
                            </span>
                            <span class="text-xs text-zinc-400 font-medium">Turno #{{ $turnoEnSilla->posicion }}</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold font-serif text-white tracking-tight mt-1">{{ $turnoEnSilla->cliente->nombre }}</h2>
                        <p class="text-xs sm:text-sm text-zinc-300 mt-0.5">
                            <span class="text-amber-400 font-semibold">{{ $turnoEnSilla->cita->servicio->nombre ?? 'Servicio Personalizado' }}</span>
                            <span class="text-zinc-500 mx-1">•</span> ${{ number_format($turnoEnSilla->cita->servicio->precio ?? 0, 0) }} 
                            <span class="text-zinc-500 mx-1">•</span> Duración: {{ $turnoEnSilla->cita->servicio->duracion_min ?? 30 }} min
                        </p>
                        @if($turnoEnSilla->cita && $turnoEnSilla->cita->observacion)
                            <p class="text-xs text-amber-200/90 italic mt-1.5 bg-white/5 px-2.5 py-1 rounded-lg border border-white/10 max-w-xl">
                                Nota previa: {{ $turnoEnSilla->cita->observacion }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <button type="button" onclick="abrirModalFinalizar('{{ $turnoEnSilla->cita->id_cita }}', '{{ $turnoEnSilla->cliente->nombre }}', '{{ $turnoEnSilla->cita->servicio->nombre ?? 'Corte' }}')"
                            class="px-5 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs sm:text-sm flex items-center gap-2 shadow-lg shadow-amber-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all cursor-pointer">
                        <i data-lucide="check-check" class="w-4 h-4 stroke-[2.5]"></i>
                        <span>Finalizar Servicio y Registrar Notas</span>
                    </button>
                </div>
            @else
                <!-- Estado B: Silla Disponible (Estación en Espera) -->
                <div class="flex items-start sm:items-center gap-4">
                    <div class="w-13 h-13 sm:w-15 sm:h-15 rounded-2xl bg-gradient-to-br from-amber-500/15 via-zinc-900 to-black border border-amber-500/30 flex items-center justify-center text-amber-400 shrink-0 shadow-lg shadow-black/40 group">
                        <i data-lucide="armchair" class="w-6 h-6 text-amber-400 stroke-[1.8] group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-300 text-[11px] font-bold uppercase tracking-wider border border-emerald-500/30 flex items-center gap-1.5 font-sans">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                SILLA DISPONIBLE
                            </span>
                            <span class="text-xs text-zinc-400 font-medium">Puesto Operativo</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold font-serif text-white tracking-tight mt-1">Tu puesto de trabajo está listo</h2>
                        <p class="text-xs sm:text-sm text-zinc-400 mt-0.5">
                            @if($siguienteEnEspera)
                                Hay <span class="text-amber-400 font-semibold">{{ $turnosEnEsperaCount }}</span> clientes en espera. Siguiente: <span class="text-white font-medium underline decoration-amber-400/40 underline-offset-2">{{ $siguienteEnEspera->cliente->nombre }}</span> (Turno #{{ $siguienteEnEspera->posicion }}).
                            @else
                                No tienes clientes en sala de espera en este momento. Puesto libre para recibir turnos.
                            @endif
                        </p>
                    </div>
                </div>

                @if($siguienteEnEspera)
                    <form action="{{ route('barbero.turnos.llamar', $siguienteEnEspera->id_turno) }}" method="POST" class="shrink-0">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-5 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs sm:text-sm flex items-center gap-2 shadow-lg shadow-amber-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all cursor-pointer">
                            <i data-lucide="bell" class="w-4 h-4 stroke-[2]"></i>
                            <span>Llamar Siguiente: {{ $siguienteEnEspera->cliente->nombre }} (#{{ $siguienteEnEspera->posicion }})</span>
                        </button>
                    </form>
                @else
                    @php
                        $proximaCita = $citasHoy->whereIn('estado', ['ACEPTADA', 'PENDIENTE'])->first();
                    @endphp
                    <div class="flex flex-wrap items-center gap-3 shrink-0">
                        @if($proximaCita)
                            <!-- Tarjeta glassmorphism de Próxima Cita Programada -->
                            <div class="flex items-center gap-3 bg-white/[0.04] border border-white/10 hover:border-amber-400/40 rounded-xl px-3.5 py-2 backdrop-blur-xs transition-all">
                                <div class="w-9 h-9 rounded-lg bg-amber-500/15 border border-amber-500/30 flex flex-col items-center justify-center text-amber-300 shrink-0">
                                    <span class="text-[11px] font-bold leading-none">{{ \Carbon\Carbon::parse($proximaCita->hora)->format('h:i') }}</span>
                                    <span class="text-[8px] uppercase font-bold text-amber-400/80 mt-0.5">{{ \Carbon\Carbon::parse($proximaCita->hora)->format('A') }}</span>
                                </div>
                                <div class="text-left">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[10px] font-bold text-amber-400 uppercase tracking-wider font-sans">Próxima Cita</span>
                                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold {{ $proximaCita->estado === 'ACEPTADA' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300' }}">
                                            {{ $proximaCita->estado }}
                                        </span>
                                    </div>
                                    <div class="text-xs font-bold text-white truncate max-w-[150px] sm:max-w-[180px]">
                                        {{ $proximaCita->cliente->nombre }}
                                    </div>
                                    <div class="text-[11px] text-zinc-400 truncate max-w-[150px] sm:max-w-[180px]">
                                        {{ $proximaCita->servicio->nombre ?? 'Servicio' }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Indicador de Estación Libre & Operativa -->
                            <div class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl bg-white/[0.04] border border-white/10">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                                <span class="text-xs font-medium text-zinc-300">Estación Lista</span>
                                <span class="text-zinc-600">•</span>
                                <span class="text-xs text-amber-300 font-semibold">{{ Auth::user()->nombre }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- 4. Split Layout: Agenda del Día (2/3) y Cola de Sala en Vivo (1/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Columna Izquierda: Agenda de Citas del Día (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:border-slate-300 p-5 sm:p-6 flex flex-col transition-all duration-300">
            <!-- Header de la Agenda -->
            <div class="flex items-center mb-4 pb-3.5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs">
                        <i data-lucide="calendar" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 font-serif tracking-tight">Mi Agenda del Día</h2>
                        <p class="text-[11px] text-slate-400 font-sans">Turnos agendados y reservas de clientes</p>
                    </div>
                </div>
            </div>

            <!-- Lista de Citas del Día -->
            <div class="space-y-3">
                @forelse($citasHoy as $cita)
                    <div class="p-4 rounded-xl border transition-all {{ $cita->estado === 'ACEPTADA' ? 'bg-amber-50/40 border-amber-300 shadow-2xs' : ($cita->estado === 'COMPLETADA' ? 'bg-slate-50 border-slate-200/50 opacity-75' : 'bg-white border-slate-200/80 hover:border-slate-300 shadow-2xs') }}">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-start sm:items-center gap-3.5">
                                <div class="w-12 h-12 rounded-xl bg-slate-900 text-white border border-slate-800 flex flex-col items-center justify-center shrink-0 shadow-xs">
                                    <span class="text-xs font-extrabold">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i') }}</span>
                                    <span class="text-[9px] uppercase font-bold text-amber-400">{{ \Carbon\Carbon::parse($cita->hora)->format('A') }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $cita->cliente->nombre }}</h4>
                                        @if($cita->cliente->telefono)
                                            <span class="text-xs text-slate-400 font-medium">({{ $cita->cliente->telefono }})</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-600 mt-0.5">
                                        <span class="font-semibold text-amber-700">{{ $cita->servicio->nombre ?? 'Servicio' }}</span>
                                        <span class="text-slate-400 mx-1">•</span> ${{ number_format($cita->servicio->precio ?? 0, 0) }} 
                                        <span class="text-slate-400 mx-1">•</span> {{ $cita->servicio->duracion_min ?? 30 }} min
                                    </p>
                                    @if($cita->observacion)
                                        <p class="text-[11px] text-slate-500 italic mt-1 bg-slate-100/70 px-2 py-0.5 rounded-md border border-slate-200/60">
                                            Nota: {{ $cita->observacion }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Acciones por Estado -->
                            <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                @if($cita->estado === 'PENDIENTE')
                                    <form action="{{ route('barbero.citas.estado', $cita->id_cita) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="estado" value="ACEPTADA">
                                        <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold text-xs transition-all flex items-center gap-1.5 shadow-xs cursor-pointer">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            Aceptar
                                        </button>
                                    </form>

                                    <button type="button" onclick="abrirModalCancelar('{{ $cita->id_cita }}', '{{ $cita->cliente->nombre }}')"
                                            class="px-3 py-1.5 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 active:scale-95 text-xs font-bold transition-all cursor-pointer">
                                        Rechazar
                                    </button>

                                @elseif($cita->estado === 'ACEPTADA')
                                    <form action="{{ route('barbero.citas.iniciar', $cita->id_cita) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3.5 py-1.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs transition-all flex items-center gap-1.5 shadow-xs hover:scale-[1.02] active:scale-95 cursor-pointer">
                                            <i data-lucide="armchair" class="w-3.5 h-3.5"></i>
                                            Pasar a Silla
                                        </button>
                                    </form>

                                    <button type="button" onclick="abrirModalFinalizar('{{ $cita->id_cita }}', '{{ $cita->cliente->nombre }}', '{{ $cita->servicio->nombre ?? 'Corte' }}')"
                                            class="px-3.5 py-1.5 rounded-xl bg-[#0b0c10] hover:bg-slate-800 text-white font-bold text-xs transition-all flex items-center gap-1.5 active:scale-95 cursor-pointer">
                                            <i data-lucide="check-check" class="w-3.5 h-3.5 text-amber-400"></i>
                                            Finalizar
                                        </button>

                                    <button type="button" onclick="abrirModalReprogramar('{{ $cita->id_cita }}', '{{ $cita->cliente->nombre }}', '{{ $cita->fecha->format('Y-m-d') }}', '{{ substr($cita->hora, 0, 5) }}')"
                                            class="p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 hover:text-slate-800 text-xs transition-all cursor-pointer" title="Reprogramar">
                                        <i data-lucide="calendar-clock" class="w-4 h-4"></i>
                                    </button>

                                @elseif($cita->estado === 'COMPLETADA')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                                        <i data-lucide="check-circle" class="w-3 h-3 text-emerald-600"></i>
                                        Completada (+${{ number_format(($cita->servicio->precio ?? 0) * 0.4, 0) }})
                                    </span>

                                @elseif($cita->estado === 'CANCELADA')
                                    <span class="px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-semibold">
                                        Cancelada
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                                        {{ $cita->estado }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Estado Vacío Artesanal -->
                    <div class="my-2 py-8 px-6 rounded-2xl bg-gradient-to-b from-amber-500/[0.03] via-slate-50/50 to-transparent border border-dashed border-amber-300/60 text-center relative overflow-hidden group">
                        <!-- Destello ambiental -->
                        <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/5 blur-xl pointer-events-none"></div>

                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100/80 border border-amber-200 text-amber-600 flex items-center justify-center mx-auto mb-3.5 shadow-xs group-hover:scale-105 transition-transform">
                            <i data-lucide="calendar-check-2" class="w-7 h-7 stroke-[1.8]"></i>
                        </div>

                        <h4 class="text-base font-bold text-slate-900 font-serif">Tu agenda está completamente libre para hoy</h4>
                        <p class="text-xs text-slate-500 mt-1.5 max-w-md mx-auto leading-relaxed">
                            No tienes citas programadas para esta fecha. Los clientes pueden reservar tus turnos directamente desde el catálogo en línea.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Columna Derecha: Cola de Turnos en Sala de Espera (1 Col) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:border-slate-300 p-5 sm:p-6 flex flex-col transition-all duration-300">
            <!-- Header de Sala de Espera -->
            <div class="flex items-center justify-between mb-4 pb-3.5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs">
                        <i data-lucide="list-ordered" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 font-serif tracking-tight">Sala de Espera</h2>
                        <p class="text-[11px] text-slate-400 font-sans">Cola en vivo para tu estación</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full {{ $turnosEnEsperaCount > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/80' }} font-bold text-xs inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full {{ $turnosEnEsperaCount > 0 ? 'bg-emerald-500 animate-ping' : 'bg-slate-300' }}"></span>
                    {{ $turnosEnEsperaCount }} en fila
                </span>
            </div>

            <!-- Cola de Turnos en Sala -->
            <div class="space-y-2.5">
                @forelse($turnosHoy as $turno)
                    <div class="p-3 rounded-xl border flex items-center justify-between gap-3 {{ $turno->estado === 'EN_ATENCION' ? 'bg-emerald-50/50 border-emerald-300 ring-1 ring-emerald-300 shadow-2xs' : ($turno->estado === 'FINALIZADO' ? 'bg-slate-50 border-slate-100 opacity-60' : 'bg-white border-slate-200/80 shadow-2xs') }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs {{ $turno->estado === 'EN_ATENCION' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                                #{{ $turno->posicion }}
                            </div>
                            <div class="truncate">
                                <h4 class="font-bold text-slate-900 text-xs truncate">{{ $turno->cliente->nombre }}</h4>
                                <p class="text-[11px] text-slate-500 truncate">{{ $turno->cita->servicio->nombre ?? 'Servicio en sala' }}</p>
                            </div>
                        </div>

                        <div class="shrink-0">
                            @if($turno->estado === 'EN_ESPERA')
                                <form action="{{ route('barbero.turnos.llamar', $turno->id_turno) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs shadow-xs hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-1.5 cursor-pointer">
                                        <i data-lucide="bell" class="w-3.5 h-3.5"></i>
                                        Llamar
                                    </button>
                                </form>
                            @elseif($turno->estado === 'EN_ATENCION')
                                <span class="text-[11px] font-bold text-emerald-700 bg-emerald-100/60 px-2 py-0.5 rounded-full">
                                    En Silla
                                </span>
                            @else
                                <span class="text-[11px] font-medium text-slate-400">
                                    Listo
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <!-- Estado Vacío de Sala en Vivo -->
                    <div class="my-2 py-8 px-5 rounded-2xl bg-gradient-to-b from-emerald-500/[0.03] via-slate-50/50 to-transparent border border-dashed border-emerald-300/60 text-center relative overflow-hidden group">
                        <!-- Destello ambiental -->
                        <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/5 blur-xl pointer-events-none"></div>

                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100/80 border border-emerald-200 text-emerald-600 flex items-center justify-center mx-auto mb-3.5 shadow-xs group-hover:scale-105 transition-transform">
                            <i data-lucide="armchair" class="w-7 h-7 stroke-[1.8]"></i>
                        </div>

                        <h4 class="text-base font-bold text-slate-900 font-serif">Sala de espera libre</h4>
                        <p class="text-xs text-slate-500 mt-1.5 max-w-xs mx-auto leading-relaxed">
                            No hay turnos asignados a tu puesto en este momento. La cola en vivo se sincroniza automáticamente.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

<!-- MODAL: FINALIZAR SERVICIO y NOTAS TÉCNICAS -->
<div id="modalFinalizar" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200/60 text-amber-600 flex items-center justify-center font-bold">
                    <i data-lucide="check-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 font-serif">Finalizar Servicio en Silla</h3>
                    <p class="text-xs text-slate-500" id="modalFinalizarSubtitle">Cliente</p>
                </div>
            </div>
            <button onclick="cerrarModalFinalizar()" class="text-slate-400 hover:text-slate-600 cursor-pointer p-1 rounded-lg"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <form id="formFinalizar" method="POST" class="mt-4 space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Ficha Técnica o Notas del Corte
                </label>
                <textarea name="observacion" rows="3" required
                        placeholder="Ej: Degradado medio 0.5 a los lados, tijera arriba, perfilado de barba con toalla caliente y navaja. Usa cera mate."
                        class="w-full text-xs rounded-xl border border-slate-300 p-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"></textarea>
                <p class="text-[11px] text-slate-400 mt-1">
                    Esta observación se guardará en el historial del cliente para que recuerdes su estilo en futuras citas.
                </p>
            </div>

            <div class="p-3 bg-amber-50/60 rounded-xl border border-amber-200/60 flex items-center gap-3">
                <i data-lucide="badge-percent" class="w-5 h-5 text-amber-600 shrink-0"></i>
                <p class="text-xs text-amber-900">
                    Al finalizar se sumará el <strong>40% del valor del servicio</strong> a tu liquidación diaria de comisiones.
                </p>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="cerrarModalFinalizar()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold shadow-md shadow-amber-500/20 cursor-pointer active:scale-95">
                    Confirmar y cerrar Servicio
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: CANCELAR CITA -->
<div id="modalCancelar" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200">
        <h3 class="font-bold text-slate-900 font-serif text-lg">Cancelar Cita</h3>
        <p class="text-xs text-slate-500 mt-0.5" id="modalCancelarSubtitle">Indica el motivo de la cancelación</p>

        <form id="formCancelar" method="POST" class="mt-4 space-y-3">
            @csrf
            @method('PATCH')
            <input type="hidden" name="estado" value="CANCELADA">

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Motivo de Cancelación</label>
                <textarea name="motivo_cancelacion" rows="3" required
                        placeholder="Ej: Cliente solicitó cancelar vía telefónica por calamidad doméstica..."
                        class="w-full text-xs rounded-xl border border-slate-300 p-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/30 focus:border-rose-500"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="cerrarModalCancelar()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">
                    Volver
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold cursor-pointer">
                    Confirmar Cancelación
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: REPROGRAMAR CITA -->
<div id="modalReprogramar" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200">
        <h3 class="font-bold text-slate-900 font-serif text-lg">Reprogramar Cita</h3>
        <p class="text-xs text-slate-500 mt-0.5" id="modalReprogramarSubtitle">Selecciona el nuevo horario</p>

        <form id="formReprogramar" method="POST" class="mt-4 space-y-3">
            @csrf

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nueva Fecha</label>
                    <input type="date" name="nueva_fecha" id="inputNuevaFecha" required
                        class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nueva Hora</label>
                    <input type="time" name="nueva_hora" id="inputNuevaHora" required
                        class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Motivo del Cambio</label>
                <input type="text" name="motivo" placeholder="Ej: Solicitud acordada con el cliente..."
                    class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="cerrarModalReprogramar()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">
                    Cerrar
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold cursor-pointer active:scale-95">
                    Guardar Nuevo Horario
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function abrirModalFinalizar(idCita, cliente, servicio) {
        document.getElementById('formFinalizar').action = `/barbero/citas/${idCita}/finalizar`;
        document.getElementById('modalFinalizarSubtitle').innerText = `${cliente} • ${servicio}`;
        document.getElementById('modalFinalizar').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }
    function cerrarModalFinalizar() {
        document.getElementById('modalFinalizar').classList.add('hidden');
    }

    function abrirModalCancelar(idCita, cliente) {
        document.getElementById('formCancelar').action = `/barbero/citas/${idCita}/estado`;
        document.getElementById('modalCancelarSubtitle').innerText = `Cliente: ${cliente}`;
        document.getElementById('modalCancelar').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }
    function cerrarModalCancelar() {
        document.getElementById('modalCancelar').classList.add('hidden');
    }

    function abrirModalReprogramar(idCita, cliente, fecha, hora) {
        document.getElementById('formReprogramar').action = `/barbero/citas/${idCita}/reprogramar`;
        document.getElementById('modalReprogramarSubtitle').innerText = `Cliente: ${cliente}`;
        document.getElementById('inputNuevaFecha').value = fecha;
        document.getElementById('inputNuevaHora').value = hora;
        document.getElementById('modalReprogramar').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }
    function cerrarModalReprogramar() {
        document.getElementById('modalReprogramar').classList.add('hidden');
    }
</script>
@endpush
@endsection
