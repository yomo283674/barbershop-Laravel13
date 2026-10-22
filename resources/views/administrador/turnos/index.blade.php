@extends('layouts.app')

@section('title', 'Turnos en Sala')
@section('breadcrumb', 'Turnos en Sala')



@section('content')
    @php
        $carbonFecha = \Carbon\Carbon::parse($fecha);
        $fechaAnterior = $carbonFecha->copy()->subDay()->toDateString();
        $fechaSiguiente = $carbonFecha->copy()->addDay()->toDateString();
        $esHoy = $fecha === now()->toDateString();
    @endphp

    <div class="space-y-6">

        <!-- Header Section con Navegación de Fecha -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 font-serif">
                        Sala de Espera y Turnos
                    </h1>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Control en tiempo real de la cola presencial de clientes y llamado a sillas de barbería.
                </p>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <!-- Navegación de Fecha interactiva -->
                <form method="GET" action="{{ route('admin.turnos.index') }}" class="flex items-center gap-1.5 sm:gap-2">
                    @if(request('estado') && request('estado') !== 'TODOS')
                        <input type="hidden" name="estado" value="{{ request('estado') }}">
                    @endif

                    <!-- Día anterior -->
                    <a href="{{ route('admin.turnos.index', array_merge(request()->except('page'), ['fecha' => $fechaAnterior])) }}" 
                    class="p-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 text-slate-700 rounded-xl transition-all shadow-2xs hover:shadow-xs" 
                    title="Día anterior ({{ \Carbon\Carbon::parse($fechaAnterior)->isoFormat('D MMM') }})">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </a>

                    <!-- Selector de fecha -->
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

                    <!-- Día siguiente -->
                    <a href="{{ route('admin.turnos.index', array_merge(request()->except('page'), ['fecha' => $fechaSiguiente])) }}" 
                    class="p-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 text-slate-700 rounded-xl transition-all shadow-2xs hover:shadow-xs" 
                    title="Día siguiente ({{ \Carbon\Carbon::parse($fechaSiguiente)->isoFormat('D MMM') }})">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>

                    <!-- Botón Hoy -->
                    @if(!$esHoy)
                        <a href="{{ route('admin.turnos.index') }}" 
                        class="px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200/70 rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-1.5" 
                        title="Regresar a hoy">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-amber-600"></i>
                            <span>Hoy</span>
                        </a>
                    @endif
                </form>

                <!-- Botón Emitir Turno -->
                <button type="button" onclick="openModal('modalNuevoTurno')" 
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md transition-all cursor-pointer shrink-0">
                    <i data-lucide="ticket" class="w-4 h-4"></i>
                    <span>Emitir Turno</span>
                </button>
            </div>
        </div>

        <!-- Monitor Digital de Turnos (Estilo Pantalla de Sala de Espera de Lujo) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <!-- Turno Actual en Atención -->
            <div class="bg-gradient-to-br from-[#0c1a14] via-[#101b17] to-[#0b0c10] rounded-3xl p-6 sm:p-7 text-white shadow-xl border border-emerald-500/30 relative overflow-hidden flex flex-col justify-between group">
                <!-- Glow ambiental decorativo -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-400 flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                            </span>
                            En Atención Ahora
                        </span>
                        <span class="text-xs bg-emerald-500/20 text-emerald-300 px-3 py-1 rounded-full font-bold border border-emerald-500/30">
                            Silla Activa
                        </span>
                    </div>

                    @if($turnoActual)
                        <div class="flex items-center gap-4 mt-3">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center shrink-0 shadow-inner">
                                <span class="text-3xl sm:text-4xl font-black font-mono tracking-tight text-white">
                                    #{{ str_pad($turnoActual->posicion, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-xl sm:text-2xl font-extrabold text-white truncate">{{ $turnoActual->cliente->nombre ?? 'Cliente' }}</h3>
                                <div class="flex items-center gap-2 text-xs sm:text-sm text-emerald-300 mt-1 flex-wrap">
                                    <span class="flex items-center gap-1 font-semibold text-white">
                                        <i data-lucide="scissors" class="w-3.5 h-3.5 text-amber-400"></i>
                                        {{ $turnoActual->cita->barbero->nombre ?? 'Puesto General' }}
                                    </span>
                                    @if($turnoActual->cita && $turnoActual->cita->servicio)
                                        <span class="text-emerald-500">•</span>
                                        <span>{{ $turnoActual->cita->servicio->nombre }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="py-10 text-center flex flex-col items-center">
                            <div class="w-16 h-16 rounded-3xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3">
                                <i data-lucide="scissors" class="w-8 h-8"></i>
                            </div>
                            <h4 class="text-base font-bold text-slate-100">Sillón disponible para atención</h4>
                            <p class="text-xs text-slate-400 max-w-xs mt-1 leading-relaxed">
                                Ningún turno en atención en este momento. Llama al siguiente cliente en la fila para comenzar.
                            </p>
                        </div>
                    @endif
                </div>

                @if($turnoActual)
                    <div class="mt-6 pt-4 border-t border-emerald-900/60 flex items-center justify-between">
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-emerald-400"></i>
                            <span>En servicio presencial</span>
                        </span>
                        <form method="POST" action="{{ route('admin.turnos.finalizar', $turnoActual) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition-all cursor-pointer flex items-center gap-1.5">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>Finalizar Servicio</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Siguiente Turno en Fila -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200/80 hover:shadow-md transition-all flex flex-col justify-between relative overflow-hidden group">
                <!-- Glow ambiental sutil -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-amber-700 flex items-center gap-1.5">
                            <i data-lucide="arrow-right-circle" class="w-4 h-4 text-amber-600"></i>
                            Siguiente en Fila
                        </span>
                        <span class="text-xs bg-amber-50 text-amber-800 px-3 py-1 rounded-full font-bold border border-amber-200/70">
                            {{ $turnosEnEspera }} en espera
                        </span>
                    </div>

                    @if($siguienteTurno)
                        <div class="flex items-center gap-4 mt-3">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-900 flex items-center justify-center shrink-0 shadow-inner">
                                <span class="text-3xl sm:text-4xl font-black font-mono tracking-tight text-slate-900">
                                    #{{ str_pad($siguienteTurno->posicion, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 truncate">{{ $siguienteTurno->cliente->nombre ?? 'Cliente' }}</h3>
                                <p class="text-slate-500 text-xs sm:text-sm mt-1">
                                    @if($siguienteTurno->cita)
                                        <span class="font-semibold text-slate-700">{{ $siguienteTurno->cita->servicio->nombre ?? 'Servicio' }}</span> • Barbero: <span class="font-medium text-slate-600">{{ $siguienteTurno->cita->barbero->nombre ?? 'General' }}</span>
                                    @else
                                        <span class="text-amber-700 font-semibold">Turno presencial directo (Walk-in)</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="py-10 text-center flex flex-col items-center">
                            <div class="w-16 h-16 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center mb-3">
                                <i data-lucide="users" class="w-8 h-8"></i>
                            </div>
                            <h4 class="text-base font-bold text-slate-900">Fila de espera al día</h4>
                            <p class="text-xs text-slate-400 max-w-xs mt-1 leading-relaxed">
                                No hay clientes en espera en este momento. Emite un nuevo turno cuando llegue un cliente a la sala.
                            </p>
                        </div>
                    @endif
                </div>

                @if($siguienteTurno)
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">Posición #1 de la fila de espera</span>
                        <form method="POST" action="{{ route('admin.turnos.llamar', $siguienteTurno) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover rounded-xl shadow-md transition-all cursor-pointer flex items-center gap-1.5">
                                <i data-lucide="volume-2" class="w-4 h-4"></i>
                                <span>Llamar a Silla →</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>

        <!-- 4 Métricas de Sala de Espera -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Total Emitidos -->
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Emitidos</span>
                    <span class="p-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-slate-700 group-hover:scale-110 transition-transform">
                        <i data-lucide="ticket" class="w-5 h-5"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">{{ $totalTurnos }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Registrados en la fecha</p>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-800"></div>
            </div>

            <!-- En Espera -->
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">En Espera</span>
                    <span class="p-2.5 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 group-hover:scale-110 transition-transform">
                        <i data-lucide="hourglass" class="w-5 h-5"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-amber-600 tracking-tight font-arial">{{ $turnosEnEspera }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Clientes en sala de espera</p>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
            </div>

            <!-- En Atención -->
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">En Atención</span>
                    <span class="p-2.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 group-hover:scale-110 transition-transform">
                        <i data-lucide="scissors" class="w-5 h-5"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight font-arial">{{ $turnosEnAtencion }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Actualmente en silla</p>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
            </div>

            <!-- Finalizados -->
            <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Finalizados</span>
                    <span class="p-2.5 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 group-hover:scale-110 transition-transform">
                        <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">{{ $turnosFinalizados }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Servicios completados hoy</p>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-500"></div>
            </div>
        </div>

        <!-- Lista de Turnos de la Jornada (Sin Scroll Horizontal y Totalmente Responsiva) -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
            <!-- Header del Contenedor de Turnos -->
            <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 font-serif">
                            Fila de Turnos de Hoy
                        </h2>
                        <span class="text-xs font-bold text-slate-700 bg-slate-100 border border-slate-200 px-3 py-0.5 rounded-full">
                            <span class="font-arial font-bold">{{ $turnos->total() }}</span> Registros
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Orden de llegada y atención presencial en sala</p>
                </div>

                <!-- Filtros Rápidos de Estado de Turno -->
                <div class="flex items-center gap-1.5 overflow-x-auto text-xs font-semibold">
                    <a href="{{ route('admin.turnos.index', ['fecha' => $fecha, 'estado' => 'TODOS']) }}" 
                    class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $estado === 'TODOS' ? 'bg-slate-900 text-white font-bold shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Todos
                    </a>
                    <a href="{{ route('admin.turnos.index', ['fecha' => $fecha, 'estado' => 'EN_ESPERA']) }}" 
                    class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 {{ $estado === 'EN_ESPERA' ? 'bg-amber-500 text-slate-950 font-bold shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        <span>En Espera ({{ $turnosEnEspera }})</span>
                    </a>
                    <a href="{{ route('admin.turnos.index', ['fecha' => $fecha, 'estado' => 'EN_ATENCION']) }}" 
                    class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 {{ $estado === 'EN_ATENCION' ? 'bg-emerald-600 text-white font-bold shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span>En Atención ({{ $turnosEnAtencion }})</span>
                    </a>
                    <a href="{{ route('admin.turnos.index', ['fecha' => $fecha, 'estado' => 'FINALIZADO']) }}" 
                    class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 {{ $estado === 'FINALIZADO' ? 'bg-slate-800 text-white font-bold shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        <i data-lucide="check" class="w-3 h-3 text-emerald-400"></i>
                        <span>Finalizados ({{ $turnosFinalizados }})</span>
                    </a>
                </div>
            </div>

            <!-- Lista de Turnos como Tarjetas Verticales -->
            <div class="p-4 sm:p-5 space-y-3">
                @forelse($turnos as $turno)
                    <div class="group p-4 sm:p-5 rounded-2xl bg-white hover:bg-slate-50/90 border border-slate-200/80 hover:border-amber-400/50 shadow-2xs hover:shadow-xs transition-all {{ $turno->estado === 'FINALIZADO' ? 'opacity-70 bg-slate-50/40' : '' }}">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                            <!-- Columna 1: Número de Turno + Cliente -->
                            <div class="flex items-center gap-3.5 min-w-0">
                                <!-- Badge Número de Turno -->
                                <div class="w-12 h-12 rounded-2xl font-mono font-extrabold text-base flex items-center justify-center shrink-0 shadow-2xs {{ $turno->estado === 'EN_ATENCION' ? 'bg-emerald-600 text-white shadow-xs' : ($turno->estado === 'EN_ESPERA' ? 'bg-amber-100 text-amber-900 border border-amber-200' : 'bg-slate-100 text-slate-500 border border-slate-200') }}">
                                    #{{ str_pad($turno->posicion, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <!-- Avatar & Datos del Cliente -->
                                <div class="flex items-center gap-3 min-w-0">
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
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-900 text-sm truncate group-hover:text-amber-800 transition-colors">
                                            {{ $turno->cliente->nombre ?? 'Cliente' }}
                                        </h4>
                                        <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                            <i data-lucide="phone" class="w-3 h-3 text-slate-400"></i>
                                            <span>{{ $turno->cliente->telefono ?? ($turno->cliente->numero_identificacion ?? 'Sin datos de contacto') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna 2: Cita Vinculada & Barbero -->
                            <div class="flex items-center gap-2.5 flex-wrap text-xs">
                                <!-- Cita o Walk-in -->
                                @if($turno->cita)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50/80 border border-amber-200/70 font-semibold text-amber-900">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-amber-600"></i>
                                        <span>Cita #{{ $turno->cita->id_cita }} ({{ $turno->cita->servicio->nombre ?? 'Servicio' }})</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 border border-slate-200/70 font-semibold text-slate-700">
                                        <i data-lucide="user" class="w-3.5 h-3.5 text-slate-500"></i>
                                        <span>Turno Presencial</span>
                                    </span>
                                @endif

                                <!-- Barbero Asignado -->
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 border border-slate-200/70 font-semibold text-slate-700">
                                    <i data-lucide="scissors" class="w-3.5 h-3.5 text-amber-600"></i>
                                    <span>{{ $turno->cita->barbero->nombre ?? 'Puesto asignado al llamar' }}</span>
                                </span>
                            </div>

                            <!-- Columna 3: Estado & Acciones -->
                            <div class="flex items-center justify-between lg:justify-end gap-3 shrink-0 pt-2.5 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                                <!-- Badge de Estado -->
                                <div>
                                    @if($turno->estado === 'EN_ATENCION')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-2xs">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                            EN ATENCIÓN
                                        </span>
                                    @elseif($turno->estado === 'EN_ESPERA')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200/80 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            EN ESPERA
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
                                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                            FINALIZADO
                                        </span>
                                    @endif
                                </div>

                                <!-- Botones de Acción -->
                                <div class="inline-flex items-center gap-1.5">
                                    @if($turno->estado === 'EN_ESPERA')
                                        <form method="POST" action="{{ route('admin.turnos.llamar', $turno) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-2xs transition-all flex items-center gap-1.5 cursor-pointer">
                                                <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                                                <span>Llamar</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if($turno->estado === 'EN_ATENCION')
                                        <form method="POST" action="{{ route('admin.turnos.finalizar', $turno) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white shadow-2xs transition-all flex items-center gap-1.5 cursor-pointer">
                                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i>
                                                <span>Finalizar</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if($turno->estado !== 'FINALIZADO')
                                        <form method="POST" action="{{ route('admin.turnos.destroy', $turno) }}" class="inline" onsubmit="return confirm('¿Deseas cancelar este turno?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all shadow-2xs cursor-pointer border border-transparent hover:border-rose-200" title="Cancelar Turno">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <!-- Empty State de Turnos -->
                    <div class="py-16 px-4 text-center">
                        <div class="max-w-md mx-auto flex flex-col items-center">
                            <div class="relative mb-4">
                                <div class="w-16 h-16 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shadow-inner">
                                    <i data-lucide="ticket" class="w-8 h-8 text-amber-600"></i>
                                </div>
                                <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white border border-slate-200 text-amber-600 flex items-center justify-center shadow-xs">
                                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 tracking-tight font-serif">
                                No hay turnos registrados para esta fecha
                            </h3>
                            <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                                No se han emitido turnos en esta jornada. Puedes emitir el primer turno presencial para un cliente en sala.
                            </p>

                            <div class="mt-5 flex items-center gap-2.5">
                                @if($esHoy)
                                @else
                                    <a href="{{ route('admin.turnos.index') }}" 
                                    class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                        Ir a Hoy
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Footer con Paginación Premium Rediseñada -->
            <div class="px-5 py-3.5 sm:px-6 border-t border-slate-100 bg-slate-50/60 flex flex-col md:flex-row items-center justify-between gap-3.5">
                <!-- Indicador de Resultados -->
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Mostrando</span>
                    <span class="font-bold text-slate-900 font-arial">{{ $turnos->firstItem() ?? 0 }}–{{ $turnos->lastItem() ?? 0 }}</span>
                    <span class="text-slate-400">de</span>
                    <span class="font-bold text-slate-900 font-arial">{{ $turnos->total() }}</span>
                    <span>turnos en lista</span>
                </div>

                <!-- Toolbar Derecha: Selector de Filas + Navegación -->
                <div class="flex items-center gap-3 flex-wrap justify-center md:justify-end">
                    <!-- Selector Cantidad por Página -->
                    <div class="inline-flex items-center gap-1.5">
                        <span class="text-xs text-slate-400 font-semibold hidden sm:inline">Mostrar:</span>
                        <div class="inline-flex items-center bg-slate-100/90 p-1 rounded-2xl border border-slate-200/70">
                            @foreach([5, 8, 12, 20] as $cant)
                                <a href="{{ request()->fullUrlWithQuery(['per_page' => $cant, 'page' => 1]) }}"
                                class="px-2.5 py-1 rounded-xl text-xs font-arial transition-all {{ request('per_page', 8) == $cant ? 'bg-white text-slate-950 font-bold shadow-xs border border-slate-200/80' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60 font-semibold' }}">
                                    {{ $cant }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if($turnos->hasPages())
                        <span class="h-4 w-px bg-slate-200 hidden sm:block"></span>

                        {{-- Controles de Paginación --}}
                        <div>
                            {{ $turnos->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Emitir Turno -->
    <div id="modalNuevoTurno" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                        <i data-lucide="ticket" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 font-serif">Emitir Turno en Sala</h3>
                        <p class="text-xs text-slate-400">Atención presencial por orden de llegada</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modalNuevoTurno')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.turnos.store') }}" class="mt-5 space-y-4">
                @csrf

                <!-- Cliente -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cliente en Sala</label>
                    <select name="id_cliente" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                        <option value="">Selecciona cliente</option>
                        @foreach($clientes as $cli)
                            <option value="{{ $cli->id_usuario }}">{{ $cli->nombre }} (CC: {{ $cli->numero_identificacion ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cita Vinculada (Opcional) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Vincular a Cita de Hoy</label>
                    <select name="id_cita" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                        <option value="">Sin cita previa (Cliente presencial directo)</option>
                        @foreach($citasHoySinTurno as $c)
                            <option value="{{ $c->id_cita }}">
                                Cita #{{ $c->id_cita }} - {{ $c->cliente->nombre ?? 'Cliente' }} ({{ \Carbon\Carbon::parse($c->hora)->format('h:i A') }} con {{ $c->barbero->nombre ?? 'Barbero' }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">Si el cliente ya tenía una reserva agendada hoy, vincúlala aquí.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modalNuevoTurno')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2.5 text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover rounded-xl shadow-md transition-all cursor-pointer">
                        Generar Turno
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
