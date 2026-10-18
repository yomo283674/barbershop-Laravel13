@extends('layouts.app')

@section('title', 'Sala de Espera & Turnos')
@section('breadcrumb', 'Barbero / Turnos en Sala')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="relative overflow-hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>

        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Monitor de Sala de Espera
            </h1>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl">
                Visualiza y gestiona el flujo de clientes presenciales asignados a tu puesto de trabajo en tiempo real.
            </p>
        </div>

        <div class="relative z-10 flex items-center gap-2">
            <!-- Acceso directo a Mi Agenda -->
            <a href="{{ route('barbero.citas.index') }}" 
            class="px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-amber-600"></i>
                <span>Mi Agenda</span>
            </a>
        </div>
    </div>

    <!-- 2. KPIs de la Sala (Estructura Arquitectónica 3-Tier de Lujo) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Total en Sala Hoy (Pizarra / General) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-slate-400/80 hover:shadow-lg hover:shadow-slate-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-slate-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Total en Sala Hoy</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200/70 border border-slate-200/80 text-slate-700 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="ticket" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $totalTurnos }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                    Asignados a tu puesto
                </span>
                <span class="text-[11px] font-medium text-slate-400">Total jornada</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-300 group-hover:bg-slate-500 transition-colors"></div>
        </div>

        <!-- 2. En Espera (Esmeralda) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-300/80 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">En Espera</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="clock" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $turnosEnEspera }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $turnosEnEspera > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $turnosEnEspera > 0 ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                    {{ $turnosEnEspera > 0 ? 'Listos para pasar' : 'Sin espera' }}
                </span>
                <span class="text-[11px] font-medium text-slate-400">En cola</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-400 group-hover:bg-emerald-500 transition-colors"></div>
        </div>

        <!-- 3. En Silla Ahora (Ámbar / Oro) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">En Silla Ahora</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="scissors" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $turnosEnAtencion }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $turnosEnAtencion > 0 ? 'bg-amber-50 text-amber-800 border border-amber-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $turnosEnAtencion > 0 ? 'bg-amber-500 animate-ping' : 'bg-slate-300' }}"></span>
                    {{ $turnosEnAtencion > 0 ? 'En servicio' : 'Puesto libre' }}
                </span>
                <span class="text-[11px] font-medium text-slate-400">Atención activa</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-400 group-hover:bg-amber-500 transition-colors"></div>
        </div>

        <!-- 4. Finalizados (Índigo) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-indigo-300/80 hover:shadow-lg hover:shadow-indigo-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-indigo-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Finalizados</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100/70 border border-indigo-200/80 text-indigo-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="check-circle-2" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $turnosFinalizados }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $turnosFinalizados > 0 ? 'bg-indigo-50 text-indigo-800 border border-indigo-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $turnosFinalizados > 0 ? 'bg-indigo-500' : 'bg-slate-300' }}"></span>
                    Atendidos hoy
                </span>
                <span class="text-[11px] font-medium text-slate-400">Completados</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-400 group-hover:bg-indigo-500 transition-colors"></div>
        </div>
    </div>

    <!-- 3. Héroe del Turno en Atención (En Silla Actualmente) -->
    @if($turnoActual)
        <div class="relative overflow-hidden p-6 rounded-2xl bg-gradient-to-r from-[#0d141c] via-[#101b2b] to-[#152336] text-white border border-emerald-500/40 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-emerald-500/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500/25 to-emerald-500/10 border-2 border-emerald-400/50 flex flex-col items-center justify-center text-emerald-300 font-bold shadow-lg shadow-emerald-950/40 shrink-0">
                    <span class="text-[10px] tracking-widest uppercase font-sans text-emerald-400 font-extrabold">TURNO</span>
                    <span class="text-2xl font-serif font-black text-white leading-none">#{{ $turnoActual->posicion }}</span>
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-[11px] font-extrabold tracking-wider uppercase mb-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Cliente en Silla Actualmente
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight flex items-center gap-2">
                        {{ $turnoActual->cliente->nombre }}
                    </h2>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-300 mt-1">
                        <span class="inline-flex items-center gap-1.5 text-emerald-300 font-medium">
                            <i data-lucide="scissors" class="w-3.5 h-3.5 text-emerald-400"></i>
                            {{ $turnoActual->cita->servicio->nombre ?? 'Servicio en curso' }}
                        </span>
                        <span class="text-slate-500">•</span>
                        <span class="font-bold text-amber-300">
                            ${{ number_format($turnoActual->cita->servicio->precio ?? 0, 0) }}
                        </span>
                        @if($turnoActual->cliente->telefono)
                            <span class="text-slate-500">•</span>
                            <span class="text-slate-400 inline-flex items-center gap-1">
                                <i data-lucide="phone" class="w-3 h-3 text-slate-400"></i>
                                {{ $turnoActual->cliente->telefono }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="relative z-10 shrink-0">
                <form action="{{ route('barbero.turnos.finalizar', $turnoActual->id_turno) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all cursor-pointer">
                        <i data-lucide="check-check" class="w-4 h-4 stroke-[2.2]"></i>
                        Finalizar Atención de Turno
                    </button>
                </form>
            </div>
        </div>
    @elseif($siguienteTurno)
        <!-- Callout cuando la silla está libre y hay alguien en espera -->
        <div class="relative overflow-hidden p-5 rounded-2xl bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border border-amber-500/30 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-500/40 flex flex-col items-center justify-center text-amber-800 font-bold shrink-0">
                    <span class="text-[9px] uppercase tracking-wider font-extrabold text-amber-600">Turno</span>
                    <span class="text-lg font-serif font-black leading-none">#{{ $siguienteTurno->posicion }}</span>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-amber-700 tracking-wider uppercase flex items-center gap-1.5">
                        <i data-lucide="bell-ring" class="w-3.5 h-3.5 text-amber-600"></i>
                        Silla Libre • Siguiente cliente en fila
                    </span>
                    <h3 class="font-bold text-slate-900 text-base mt-0.5">
                        {{ $siguienteTurno->cliente->nombre }}
                        <span class="text-xs font-normal text-slate-500">({{ $siguienteTurno->cita->servicio->nombre ?? 'Servicio Estándar' }})</span>
                    </h3>
                </div>
            </div>
            <form action="{{ route('barbero.turnos.llamar', $siguienteTurno->id_turno) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs shadow-sm flex items-center justify-center gap-2 transition-all cursor-pointer">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                    Llamar a Silla Ahora
                </button>
            </form>
        </div>
    @endif

    <!-- 4. Cola de Turnos con Filtros Segmentados -->
    <div class="relative bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Destello ambiental sutil -->
        <div class="absolute -right-12 -top-12 w-36 h-36 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>
        
        <!-- Tabs de Estado y Encabezado de Fila -->
        <div class="relative z-10 p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Tabs Segmentados -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Todos -->
                <a href="{{ route('barbero.turnos.index', ['estado' => 'TODOS']) }}" 
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $estado === 'TODOS' ? 'bg-slate-900 text-amber-300 shadow-sm border border-slate-900' : 'bg-slate-50 text-slate-600 border border-slate-200/80 hover:bg-slate-100' }}">
                    <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                    <span>Todos</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ $estado === 'TODOS' ? 'bg-amber-400/20 text-amber-300' : 'bg-slate-200/70 text-slate-700' }}">{{ $totalTurnos }}</span>
                </a>

                <!-- En Espera -->
                <a href="{{ route('barbero.turnos.index', ['estado' => 'EN_ESPERA']) }}" 
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $estado === 'EN_ESPERA' ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-500/20 border border-emerald-600' : 'bg-emerald-50/70 text-emerald-800 border border-emerald-200/70 hover:bg-emerald-100/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 {{ $turnosEnEspera > 0 ? 'animate-pulse' : '' }}"></span>
                    <span>En Espera</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ $estado === 'EN_ESPERA' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800' }}">{{ $turnosEnEspera }}</span>
                </a>

                <!-- En Silla -->
                <a href="{{ route('barbero.turnos.index', ['estado' => 'EN_ATENCION']) }}" 
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $estado === 'EN_ATENCION' ? 'bg-amber-500 text-slate-950 shadow-sm shadow-amber-500/20 border border-amber-500' : 'bg-amber-50/70 text-amber-800 border border-amber-200/70 hover:bg-amber-100/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 {{ $turnosEnAtencion > 0 ? 'animate-ping' : '' }}"></span>
                    <span>En Silla</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ $estado === 'EN_ATENCION' ? 'bg-black/15 text-slate-950' : 'bg-amber-100 text-amber-800' }}">{{ $turnosEnAtencion }}</span>
                </a>

                <!-- Finalizados -->
                <a href="{{ route('barbero.turnos.index', ['estado' => 'FINALIZADO']) }}" 
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $estado === 'FINALIZADO' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-500/20 border border-indigo-600' : 'bg-indigo-50/70 text-indigo-800 border border-indigo-200/70 hover:bg-indigo-100/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    <span>Finalizados</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ $estado === 'FINALIZADO' ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-800' }}">{{ $turnosFinalizados }}</span>
                </a>
            </div>

            <!-- Indicador de Fila en Sala -->
            <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Fila activa para tu puesto</span>
            </div>
        </div>

        <!-- Tabla de Turnos -->
        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">
                    <tr>
                        <th class="px-6 py-3.5 text-left">Turno</th>
                        <th class="px-5 py-3.5 text-left">Cliente</th>
                        <th class="px-5 py-3.5 text-left">Servicio Solicitado</th>
                        <th class="px-5 py-3.5 text-left">Estado</th>
                        <th class="px-6 py-3.5 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($turnos as $turno)
                        <tr class="hover:bg-slate-50/70 transition-colors {{ $turno->estado === 'EN_ATENCION' ? 'bg-emerald-50/30' : '' }}">
                            <!-- Turno Posición -->
                            <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl {{ $turno->estado === 'EN_ATENCION' ? 'bg-emerald-500 text-slate-950 font-black shadow-sm' : ($turno->estado === 'EN_ESPERA' ? 'bg-slate-900 text-amber-300 shadow-2xs font-extrabold' : 'bg-slate-100 text-slate-600') }} font-serif">
                                    #{{ $turno->posicion }}
                                </div>
                            </td>

                            <!-- Cliente Info -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200/80 flex items-center justify-center text-slate-700 font-bold text-xs shrink-0 overflow-hidden">
                                        @if($turno->cliente && $turno->cliente->foto_perfil)
                                            <img src="{{ asset($turno->cliente->foto_perfil) }}" 
                                                alt="{{ $turno->cliente->nombre }}" 
                                                class="w-full h-full object-cover"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span style="display: none;" class="w-full h-full items-center justify-center">
                                                {{ strtoupper(substr($turno->cliente->nombre ?? 'C', 0, 2)) }}
                                            </span>
                                        @else
                                            {{ strtoupper(substr($turno->cliente->nombre ?? 'C', 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $turno->cliente->nombre }}</div>
                                        <div class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                            @if($turno->cliente->telefono)
                                                <i data-lucide="phone" class="w-3 h-3 text-slate-400"></i>
                                                <span>{{ $turno->cliente->telefono }}</span>
                                            @else
                                                <span class="italic">Cliente presencial sin teléfono</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Servicio -->
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800 text-xs flex items-center gap-1.5">
                                    <i data-lucide="scissors" class="w-3.5 h-3.5 text-amber-600"></i>
                                    <span>{{ $turno->cita->servicio->nombre ?? 'Servicio Estándar' }}</span>
                                </div>
                                <div class="mt-1 flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200/70 font-bold text-[11px]">
                                        ${{ number_format($turno->cita->servicio->precio ?? 0, 0) }}
                                    </span>
                                    @if(isset($turno->cita->servicio->duracion_min))
                                        <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                            {{ $turno->cita->servicio->duracion_min }} min
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Estado Badge -->
                            <td class="px-5 py-4">
                                @if($turno->estado === 'EN_ESPERA')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        En Espera
                                    </span>
                                @elseif($turno->estado === 'EN_ATENCION')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-300 text-xs font-bold shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                                        En Silla Ahora
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200/70 text-xs font-semibold">
                                        <i data-lucide="check" class="w-3 h-3 text-slate-400"></i>
                                        Finalizado
                                    </span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 text-right">
                                @if($turno->estado === 'EN_ESPERA')
                                    <form action="{{ route('barbero.turnos.llamar', $turno->id_turno) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3.5 py-2 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs shadow-xs flex items-center gap-1.5 ml-auto transition-all cursor-pointer">
                                            <i data-lucide="bell" class="w-3.5 h-3.5"></i>
                                            <span>Llamar a Silla</span>
                                        </button>
                                    </form>
                                @elseif($turno->estado === 'EN_ATENCION')
                                    <form action="{{ route('barbero.turnos.finalizar', $turno->id_turno) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-sm shadow-emerald-600/20 flex items-center gap-1.5 ml-auto transition-all cursor-pointer">
                                            <i data-lucide="check" class="w-3.5 h-3.5 stroke-[2.5]"></i>
                                            <span>Finalizar Atención</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs text-slate-400 font-medium">
                                        <i data-lucide="check-check" class="w-3.5 h-3.5 text-indigo-400"></i>
                                        Atendido
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 px-6 text-center">
                                <div class="max-w-md mx-auto flex flex-col items-center">
                                    <!-- Icono elevado con aura ambiental -->
                                    <div class="relative flex items-center justify-center mb-4">
                                        <div class="absolute w-16 h-16 rounded-2xl bg-amber-500/10 blur-xl pointer-events-none"></div>
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-xs leading-none relative z-10">
                                            <i data-lucide="users-round" class="w-8 h-8 stroke-[1.75] block translate-y-[3.5px] translate-x-[1px]"></i>
                                        </div>
                                    </div>

                                    <h4 class="text-base font-bold text-slate-900 font-serif tracking-tight">Sin turnos registrados</h4>
                                    <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                                        @if($estado !== 'TODOS')
                                            No hay turnos con estado <strong class="text-slate-700 font-semibold">{{ $estado }}</strong> en la sala hoy.
                                        @else
                                            No hay turnos asignados a tu puesto de trabajo en la sala de espera hoy.
                                        @endif
                                    </p>
                                    @if($estado !== 'TODOS')
                                        <a href="{{ route('barbero.turnos.index', ['estado' => 'TODOS']) }}" class="mt-4 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors inline-flex items-center gap-1.5">
                                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                            <span>Ver todos los turnos</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
