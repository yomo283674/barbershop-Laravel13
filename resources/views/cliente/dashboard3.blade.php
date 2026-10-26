@extends('layouts.app')

@section('title', 'Mi Cuenta')
@section('breadcrumb', 'Cliente / Mi Panel')

@section('content')
<div class="space-y-6">

    <!-- Banner de Alerta: Solicitudes de Reprogramación Pendientes -->
    @if($reprogramacionesPendientes->isNotEmpty())
        <div class="space-y-3">
            @foreach($reprogramacionesPendientes as $rep)
                <div class="bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent rounded-3xl border border-amber-400/40 p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-600 border border-amber-400/30 flex items-center justify-center shrink-0">
                            <i data-lucide="calendar-sync" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full border border-amber-300">
                                    Propuesta del Barbero
                                </span>
                                <span class="text-xs text-slate-500">Cita #{{ $rep->cita->id_cita }}</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mt-1">
                                {{ $rep->cita->barbero->nombre ?? 'Tu barbero' }} propone un nuevo horario para "{{ $rep->cita->servicio->nombre ?? 'tu corte' }}"
                            </h3>
                            <div class="mt-1.5 flex flex-wrap items-center gap-2 text-xs text-slate-600">
                                <span class="line-through text-slate-400">
                                    {{ \Carbon\Carbon::parse($rep->cita->fecha)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($rep->cita->hora)->format('h:i A') }}
                                </span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-amber-600"></i>
                                <span class="font-bold text-amber-700 bg-amber-100/70 px-2 py-0.5 rounded-md">
                                    {{ \Carbon\Carbon::parse($rep->nueva_fecha)->isoFormat('dddd D [de] MMMM') }} a las {{ \Carbon\Carbon::parse($rep->nueva_hora)->format('h:i A') }}
                                </span>
                            </div>
                            @if($rep->motivo)
                                <p class="text-xs text-slate-500 mt-1 italic">
                                    "{{ $rep->motivo }}"
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 shrink-0 self-end md:self-center">
                        <form action="{{ route('cliente.reprogramaciones.responder', $rep->id_reprogramacion) }}" method="POST">
                            @csrf
                            <input type="hidden" name="accion" value="rechazar">
                            <button type="submit" onclick="return confirm('¿Rechazar este cambio? La cita será cancelada.');" 
                                class="px-3.5 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:text-rose-800 hover:bg-rose-50 border border-rose-200 transition-colors cursor-pointer">
                                Rechazar
                            </button>
                        </form>
                        <form action="{{ route('cliente.reprogramaciones.responder', $rep->id_reprogramacion) }}" method="POST">
                            @csrf
                            <input type="hidden" name="accion" value="aceptar">
                            <button type="submit" 
                                class="px-4 py-2 rounded-xl text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover shadow-xs transition-all cursor-pointer flex items-center gap-1.5">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                <span>Aceptar Nuevo Horario</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Header Principal -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-1">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Bienvenido, <span class="text-amber-900">{{ ucwords(Auth::user()->nombre ?? 'Cliente') }}</span>
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                Elige tu barbero favorito, reserva tu horario y gestiona todas tus citas de forma personalizada.
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <button type="button" onclick="openModal('modalNuevaReservaCliente')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs tracking-wide uppercase text-slate-950 gold-gradient gold-gradient-hover shadow-sm hover:shadow-md transition-all cursor-pointer">
                <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                <span>Agendar Cita</span>
            </button>
        </div>
    </div>

    <!-- WIDGET DESTACADO: TURNO EN SALA EN VIVO (Si el cliente tiene cita/turno hoy) -->
    @if($miTurnoHoy)
        <div class="bg-gradient-to-br from-[#0b0c10] via-[#17181f] to-[#0b0c10] text-white rounded-3xl p-4 sm:p-6 shadow-xl border border-amber-500/30 relative overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6 relative z-10">
                <div class="flex items-start gap-3.5 sm:gap-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-slate-900 border border-[#c5a059]/40 text-[#c5a059] flex flex-col items-center justify-center font-bold shrink-0 shadow-xs">
                        <span class="text-[10px] uppercase font-bold tracking-wider leading-none text-slate-400">Turno</span>
                        <span class="text-xl sm:text-2xl font-arial font-bold leading-tight text-white">#{{ $miTurnoHoy->posicion }}</span>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            @if($miTurnoHoy->estado === 'EN_ATENCION')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    En sillón de atención
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#c5a059]/20 text-[#e2c788] border border-[#c5a059]/40">
                                    <span class="w-2 h-2 rounded-full bg-[#c5a059]"></span>
                                    En sala de espera
                                </span>
                            @endif
                        </div>

                        <h2 class="text-lg sm:text-xl font-bold font-serif text-white">
                            {{ $miTurnoHoy->cita->servicio->nombre ?? 'Servicio de Barbería' }}
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Barbero asignado: <strong class="text-slate-200">{{ $miTurnoHoy->cita->barbero->nombre ?? 'Profesional' }}</strong>
                        </p>
                    </div>
                </div>

                <!-- Estado de la Fila en Vivo -->
                <div class="bg-white/[0.06] backdrop-blur-xs rounded-2xl p-3 sm:p-4 border border-white/10 flex items-center gap-4 sm:gap-6 shrink-0 self-start md:self-auto">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Tu Posición</span>
                        <span class="text-xl sm:text-2xl font-bold font-arial text-[#c5a059]">#{{ $miTurnoHoy->posicion }}</span>
                    </div>
                    <div class="h-8 w-px bg-white/15"></div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Por Delante</span>
                        @if($miTurnoHoy->estado === 'EN_ATENCION')
                            <span class="text-xs font-semibold text-emerald-400">Siendo atendido</span>
                        @else
                            <span class="text-sm sm:text-base font-semibold font-arial text-white">
                                {{ $turnosPorDelante }} {{ $turnosPorDelante === 1 ? 'persona' : 'personas' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Tarjetas de Resumen KPI con toques de color -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <!-- Próxima Cita (Acento Dorado/Ámbar) -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 border-t-4 border-t-amber-500 shadow-xs flex flex-col justify-between hover:border-amber-400/80 hover:shadow-sm transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-amber-800 uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-600"></i>
                    Próxima Cita
                </span>
                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center border border-amber-300/70 shadow-2xs">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="mt-3">
                @if($proximaCita)
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 font-arial">
                            {{ \Carbon\Carbon::parse($proximaCita->fecha)->isoFormat('D [de] MMM') }}
                        </h3>
                        <span class="text-xs font-arial font-bold text-amber-900 bg-amber-100 px-2.5 py-0.5 rounded-md border border-amber-300/80">
                            {{ \Carbon\Carbon::parse($proximaCita->hora)->format('h:i A') }}
                        </span>
                    </div>
                    <p class="text-xs text-amber-950 font-medium mt-2 flex items-center gap-1.5 truncate bg-amber-50/70 p-2 rounded-xl border border-amber-200/70">
                        <i data-lucide="scissors" class="w-3.5 h-3.5 text-amber-600 shrink-0"></i>
                        <span class="truncate"><strong class="text-amber-950">{{ $proximaCita->servicio->nombre ?? 'Servicio' }}</strong> con <span class="text-amber-800 font-bold">{{ $proximaCita->barbero->nombre ?? 'Barbero' }}</span></span>
                    </p>
                @else
                    <h3 class="text-sm font-semibold text-slate-500 font-arial">Sin citas pendientes</h3>
                    <p class="text-xs text-slate-400 mt-1">Haz clic en "Agendar Cita" para programar tu estilo.</p>
                @endif
            </div>
        </div>

        <!-- Total de Reservas (Acento Esmeralda) -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 border-t-4 border-t-emerald-500 shadow-xs flex flex-col justify-between hover:border-emerald-400/80 hover:shadow-sm transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="calendar-check-2" class="w-3.5 h-3.5 text-emerald-600"></i>
                    Total Reservas
                </span>
                <a href="{{ route('cliente.citas.index') }}" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-950 flex items-center gap-1 transition-colors">
                    <span>Ver todas</span>
                    <i data-lucide="chevron-right" class="w-3 h-3 text-emerald-600"></i>
                </a>
            </div>
            <div class="mt-3 flex items-baseline justify-between">
                <h3 class="text-2xl font-bold text-slate-900 font-arial">{{ $misCitas->count() }}</h3>
                <span class="text-xs font-bold font-arial text-emerald-800 bg-emerald-100 border border-emerald-300 px-2.5 py-0.5 rounded-full inline-flex items-center gap-1">
                    <i data-lucide="check" class="w-3 h-3 text-emerald-600"></i>
                    <span>{{ $misCitas->where('estado', 'COMPLETADA')->count() }} completadas</span>
                </span>
            </div>
            <p class="text-xs text-emerald-900 mt-2 flex items-center gap-1.5 bg-emerald-50/70 p-2 rounded-xl border border-emerald-200/70 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span><strong class="font-arial font-bold">{{ $misCitas->whereIn('estado', ['PENDIENTE', 'ACEPTADA'])->count() }}</strong> activas en calendario</span>
            </p>
        </div>

        <!-- Perfil y Datos de Contacto (Acento Azul) -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 border-t-4 border-t-blue-500 shadow-xs flex flex-col justify-between hover:border-blue-400/80 hover:shadow-sm transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-blue-900 uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="user-check" class="w-3.5 h-3.5 text-blue-600"></i>
                    Tus Datos Registrados
                </span>
            </div>
            <div class="mt-3 space-y-1.5">
                <div class="flex items-center gap-2 text-xs text-blue-950 bg-blue-50/60 p-2 rounded-xl border border-blue-200/70">
                    <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 border border-blue-200">
                        <i data-lucide="phone" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="font-arial font-bold truncate">{{ Auth::user()->telefono ?? 'Sin teléfono registrado' }}</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-indigo-950 bg-indigo-50/60 p-2 rounded-xl border border-indigo-200/70">
                    <div class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 border border-indigo-200">
                        <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                    </div>
                    <span class="truncate font-semibold">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Barberos del Equipo -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-5 sm:p-6">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-bold text-slate-900 font-serif">Nuestros Barberos y sus Servicios</h2>
                <p class="text-xs text-slate-500 mt-0.5">Cada barbero cuenta con un portafolio exclusivo de cortes y estilos.</p>
            </div>
            <a href="{{ route('cliente.barberos.index') }}" class="text-xs font-bold text-amber-800 hover:text-amber-950 flex items-center gap-1.5 transition-colors">
                <span>Ver Portafolio Completo</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($barberos as $barbero)
                @include('cliente.partials.barbero_card', ['barbero' => $barbero, 'index' => $loop->index])
            @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-400">
                    No hay barberos disponibles en este momento.
                </div>
            @endforelse
        </div>

        @if(method_exists($barberos, 'links') && $barberos->hasPages())
            <div class="mt-5 pt-4 border-t border-slate-100 flex justify-center">
                {{ $barberos->links() }}
            </div>
        @endif
    </div>

    <!-- Historial Reciente de Citas -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-5 sm:p-6">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-bold text-slate-900 font-serif">Mis Reservas Recientes</h2>
                <p class="text-xs text-slate-500 mt-0.5">Consulta el estado en tiempo real o cancela tus citas programadas.</p>
            </div>
            <a href="{{ route('cliente.citas.index') }}" class="text-xs font-bold text-amber-800 hover:text-amber-950 flex items-center gap-1.5 transition-colors">
                <span>Ver Todas las Citas</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="space-y-3">
            @forelse($misCitas->take(5) as $cita)
                <div class="p-4 rounded-2xl bg-white border border-slate-200/90 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-amber-300/80 transition-all shadow-2xs">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-11 h-11 rounded-xl overflow-hidden bg-gradient-to-br from-slate-900 to-[#14151b] text-[#c5a059] border border-[#c5a059]/40 flex items-center justify-center font-bold shrink-0 shadow-2xs mt-1 sm:mt-0">
                            @if($cita->barbero && $cita->barbero->foto_perfil)
                                <img src="{{ asset($cita->barbero->foto_perfil) }}" 
                                    alt="{{ $cita->barbero->nombre }}" 
                                    class="w-full h-full object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div style="display: none;" class="w-full h-full items-center justify-center">
                                    <i data-lucide="scissors" class="w-5 h-5"></i>
                                </div>
                            @elseif($cita->barbero && $cita->barbero->nombre)
                                <span class="font-serif font-bold text-base text-[#c5a059]">{{ strtoupper(substr($cita->barbero->nombre, 0, 1)) }}</span>
                            @else
                                <i data-lucide="scissors" class="w-5 h-5"></i>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-slate-900 text-sm sm:text-base font-serif">
                                    {{ $cita->servicio->nombre ?? 'Servicio' }}
                                </h4>
                                <span class="text-xs font-bold font-arial text-amber-900 bg-amber-100 border border-amber-300/80 px-2.5 py-0.5 rounded-md">
                                    ${{ number_format($cita->servicio->precio ?? 0, 0) }} COP
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">
                                Barbero: <strong class="text-slate-800">{{ $cita->barbero->nombre ?? 'Por asignar' }}</strong> • 
                                <span class="font-medium text-slate-700 font-arial">{{ \Carbon\Carbon::parse($cita->fecha)->isoFormat('dddd, D [de] MMMM') }}</span> a las 
                                <span class="font-bold text-slate-800 font-arial">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</span>
                            </p>
                            @if($cita->observacion)
                                <p class="text-xs text-slate-600 mt-1.5 bg-slate-50 p-2 rounded-xl border border-slate-200/60">
                                    <span class="font-semibold text-slate-700">Nota:</span> {{ $cita->observacion }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0 self-end sm:self-center">
                        @if($cita->estado === 'ACEPTADA')
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Confirmada
                            </span>
                        @elseif($cita->estado === 'PENDIENTE')
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-900 bg-amber-100 px-3 py-1 rounded-full border border-amber-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Pendiente
                            </span>
                        @elseif($cita->estado === 'COMPLETADA')
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-800 bg-slate-100 px-3 py-1 rounded-full border border-slate-300">
                                <i data-lucide="check" class="w-3 h-3 text-slate-600"></i>
                                Completada
                            </span>
                        @elseif($cita->estado === 'REPROGRAMADA')
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-900 bg-blue-100 px-3 py-1 rounded-full border border-blue-300">
                                <i data-lucide="calendar-sync" class="w-3 h-3 text-blue-700"></i>
                                Reprogramada
                            </span>
                        @else
                            <span class="text-xs font-bold text-rose-800 bg-rose-50 px-3 py-1 rounded-full border border-rose-200">
                                {{ $cita->estado }}
                            </span>
                        @endif

                        @if(in_array($cita->estado, ['PENDIENTE', 'ACEPTADA', 'REPROGRAMADA']))
                            <form action="{{ route('cliente.citas.cancelar', $cita->id_cita) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas cancelar esta cita?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 hover:bg-rose-50 px-3 py-1 rounded-xl border border-rose-200/70 transition-colors cursor-pointer" title="Cancelar esta cita">
                                    Cancelar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400">
                    <i data-lucide="calendar" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                    <p class="text-base font-semibold text-slate-700">Aún no tienes citas registradas</p>
                    <p class="text-xs text-slate-400 mt-1">Elige un barbero arriba o presiona el botón "Agendar Cita".</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Reutilizable de Reserva Inteligente -->
@include('cliente.partials.modal_reserva')
@endsection
