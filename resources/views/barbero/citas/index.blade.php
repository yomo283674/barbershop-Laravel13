@extends('layouts.app')

@section('title', 'Mi Agenda de Citas')
@section('breadcrumb', 'Barbero / Mi Agenda')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="relative overflow-hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Agenda e Historial de Citas
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Gestiona las citas reservadas por tus clientes, confirma turnos y registra la ficha técnica de cada corte.
            </p>
        </div>
        <div class="relative z-10 flex items-center gap-2">
            <a href="{{ route('barbero.dashboard2') }}" class="px-4 py-2 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-slate-100 text-slate-700 text-xs font-bold transition-all flex items-center gap-1.5 shadow-2xs">
                <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 text-amber-600"></i>
                <span>Mi Panel</span>
            </a>
        </div>
    </div>

    <!-- Filtros y Tabs de Estado -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <!-- Tabs de conteo rápido (Segmented Luxury Status Bar) -->
        <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-3.5">
            <!-- Todas -->
            <a href="{{ route('barbero.citas.index') }}" 
            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ !request('estado') || request('estado') === 'TODAS' ? 'bg-slate-900 text-amber-300 shadow-sm border border-slate-900' : 'bg-slate-50 text-slate-600 border border-slate-200/80 hover:bg-slate-100' }}">
                <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                <span>Todas</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ !request('estado') || request('estado') === 'TODAS' ? 'bg-amber-400/20 text-amber-300' : 'bg-slate-200/70 text-slate-700' }}">{{ $totalCitas }}</span>
            </a>

            <!-- Pendientes -->
            <a href="{{ route('barbero.citas.index', ['estado' => 'PENDIENTE']) }}" 
            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('estado') === 'PENDIENTE' ? 'bg-amber-500 text-slate-950 shadow-sm shadow-amber-500/20 border border-amber-500' : 'bg-amber-50/70 text-amber-800 border border-amber-200/70 hover:bg-amber-100/70' }}">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 {{ $totalPendientes > 0 ? 'animate-pulse' : '' }}"></span>
                <span>Pendientes</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ request('estado') === 'PENDIENTE' ? 'bg-black/15 text-slate-950' : 'bg-amber-100 text-amber-800' }}">{{ $totalPendientes }}</span>
            </a>

            <!-- Confirmadas -->
            <a href="{{ route('barbero.citas.index', ['estado' => 'ACEPTADA']) }}" 
            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('estado') === 'ACEPTADA' ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-500/20 border border-emerald-600' : 'bg-emerald-50/70 text-emerald-800 border border-emerald-200/70 hover:bg-emerald-100/70' }}">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Confirmadas</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ request('estado') === 'ACEPTADA' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800' }}">{{ $totalAceptadas }}</span>
            </a>

            <!-- Finalizadas -->
            <a href="{{ route('barbero.citas.index', ['estado' => 'COMPLETADA']) }}" 
            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('estado') === 'COMPLETADA' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-500/20 border border-indigo-600' : 'bg-indigo-50/70 text-indigo-800 border border-indigo-200/70 hover:bg-indigo-100/70' }}">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                <span>Finalizadas</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ request('estado') === 'COMPLETADA' ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-800' }}">{{ $totalCompletadas }}</span>
            </a>

            <!-- Canceladas -->
            <a href="{{ route('barbero.citas.index', ['estado' => 'CANCELADA']) }}" 
            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('estado') === 'CANCELADA' ? 'bg-rose-600 text-white shadow-sm shadow-rose-500/20 border border-rose-600' : 'bg-rose-50/70 text-rose-800 border border-rose-200/70 hover:bg-rose-100/70' }}">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                <span>Canceladas</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold {{ request('estado') === 'CANCELADA' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-800' }}">{{ $totalCanceladas }}</span>
            </a>
        </div>

        <!-- Formulario de Búsqueda y Fecha -->
        <form method="GET" action="{{ route('barbero.citas.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-1">
            @if(request('estado'))
                <input type="hidden" name="estado" value="{{ request('estado') }}">
            @endif

            <div class="sm:col-span-6 relative">
                <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar cliente por nombre o teléfono..."
                    class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 pl-9.5 pr-3 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all placeholder:text-slate-400">
            </div>

            <div class="sm:col-span-3 relative">
                <i data-lucide="calendar" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                <input type="date" name="fecha" value="{{ request('fecha') }}"
                    class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 pl-9.5 pr-3 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all text-slate-700 cursor-pointer">
            </div>

            <div class="sm:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm shadow-amber-500/20 transition-all cursor-pointer active:scale-95">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Filtrar Agenda</span>
                </button>
                <a href="{{ route('barbero.citas.index') }}" class="px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 text-xs font-semibold transition-all flex items-center justify-center gap-1.5 shadow-2xs active:scale-95" title="Restablecer filtros">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    <span class="hidden md:inline">Restablecer</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla de Citas -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">
                    <tr>
                        <th class="px-5 py-3.5">Fecha y Hora</th>
                        <th class="px-5 py-3.5">Cliente</th>
                        <th class="px-5 py-3.5">Servicio Contratado</th>
                        <th class="px-5 py-3.5">Comisión 40%</th>
                        <th class="px-5 py-3.5">Estado</th>
                        <th class="px-5 py-3.5">Notas y Ficha Técnica</th>
                        <th class="px-5 py-3.5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($citas as $cita)
                        <tr class="hover:bg-amber-50/20 transition-colors group">
                            <!-- Fecha & Hora -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200/80 flex flex-col items-center justify-center shrink-0">
                                        <span class="text-[10px] font-extrabold text-slate-700 uppercase leading-none">
                                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d') }}
                                        </span>
                                        <span class="text-[8px] font-bold text-slate-400 uppercase leading-none mt-0.5">
                                            {{ \Carbon\Carbon::parse($cita->fecha)->translatedFormat('M') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 block text-xs">
                                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                        </span>
                                        <span class="text-slate-500 font-semibold text-[11px] flex items-center gap-1">
                                            <i data-lucide="clock" class="w-3 h-3 text-amber-600"></i>
                                            {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Cliente -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-slate-900 text-amber-400 font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs overflow-hidden border border-amber-500/30">
                                        @if($cita->cliente && $cita->cliente->foto_perfil)
                                            <img src="{{ asset($cita->cliente->foto_perfil) }}" 
                                                alt="{{ $cita->cliente->nombre }}" 
                                                class="w-full h-full object-cover"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span style="display: none;" class="w-full h-full items-center justify-center">
                                                {{ strtoupper(substr($cita->cliente->nombre, 0, 1)) }}
                                            </span>
                                        @else
                                            {{ strtoupper(substr($cita->cliente->nombre, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-xs">{{ $cita->cliente->nombre }}</div>
                                        <div class="text-[11px] text-slate-400 flex items-center gap-1">
                                            <i data-lucide="phone" class="w-3 h-3 text-slate-400"></i>
                                            {{ $cita->cliente->telefono ?? 'Sin teléfono' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Servicio Contratado -->
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-800 text-xs">{{ $cita->servicio->nombre ?? 'Servicio' }}</div>
                                <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                    <span class="font-semibold text-slate-700">${{ number_format($cita->servicio->precio ?? 0, 0) }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-slate-500">{{ $cita->servicio->duracion_min ?? 30 }} min en silla</span>
                                </div>
                            </td>

                            <!-- Comisión (40%) -->
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1 font-extrabold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200/80 text-xs tabular-nums shadow-2xs">
                                    <i data-lucide="badge-percent" class="w-3 h-3 text-emerald-600"></i>
                                    ${{ number_format(($cita->servicio->precio ?? 0) * 0.40, 0) }}
                                </span>
                            </td>

                            <!-- Estado -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if($cita->estado === 'PENDIENTE')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200/80 text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Pendiente
                                    </span>
                                @elseif($cita->estado === 'ACEPTADA')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200/80 text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Confirmada
                                    </span>
                                @elseif($cita->estado === 'COMPLETADA')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-800 border border-indigo-200/80 text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                        Finalizada
                                    </span>
                                @elseif($cita->estado === 'CANCELADA')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-800 border border-rose-200/80 text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Cancelada
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-[11px] font-bold">
                                        {{ $cita->estado }}
                                    </span>
                                @endif
                            </td>

                            <!-- Notas / Ficha Técnica -->
                            <td class="px-5 py-4 max-w-xs">
                                @if($cita->observacion)
                                    <p class="text-[11px] text-slate-600 truncate italic flex items-center gap-1" title="{{ $cita->observacion }}">
                                        <i data-lucide="file-text" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                        <span>{{ $cita->observacion }}</span>
                                    </p>
                                @elseif($cita->motivo_cancelacion)
                                    <p class="text-[11px] text-rose-600 truncate italic flex items-center gap-1" title="{{ $cita->motivo_cancelacion }}">
                                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-rose-500 shrink-0"></i>
                                        <span>Motivo: {{ $cita->motivo_cancelacion }}</span>
                                    </p>
                                @else
                                    <span class="text-[11px] text-slate-400 italic">Sin observaciones</span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($cita->estado === 'PENDIENTE')
                                        <form action="{{ route('barbero.citas.estado', $cita->id_cita) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="ACEPTADA">
                                            <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] shadow-2xs transition-all active:scale-95 flex items-center gap-1 cursor-pointer">
                                                <i data-lucide="check" class="w-3 h-3"></i>
                                                <span>Aceptar</span>
                                            </button>
                                        </form>

                                        <button type="button" onclick="abrirModalCancelar('{{ $cita->id_cita }}', '{{ $cita->cliente->nombre }}')"
                                                class="px-2.5 py-1.5 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-[11px] font-bold transition-all active:scale-95 cursor-pointer">
                                            Rechazar
                                        </button>

                                    @elseif($cita->estado === 'ACEPTADA')
                                        <form action="{{ route('barbero.citas.iniciar', $cita->id_cita) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-[11px] flex items-center gap-1 shadow-sm active:scale-95 cursor-pointer">
                                                <i data-lucide="armchair" class="w-3 h-3"></i>
                                                <span>A Silla</span>
                                            </button>
                                        </form>

                                        <button type="button" onclick="abrirModalFinalizar('{{ $cita->id_cita }}', '{{ $cita->cliente->nombre }}', '{{ $cita->servicio->nombre ?? 'Corte' }}')"
                                                class="px-3 py-1.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 font-bold text-[11px] shadow-2xs transition-all active:scale-95 cursor-pointer">
                                            Finalizar
                                        </button>

                                        <button type="button" onclick="abrirModalReprogramar('{{ $cita->id_cita }}', '{{ $cita->cliente->nombre }}', '{{ $cita->fecha->format('Y-m-d') }}', '{{ substr($cita->hora, 0, 5) }}')"
                                                class="w-8 h-8 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 flex items-center justify-center transition-all shadow-2xs active:scale-95 cursor-pointer" title="Reprogramar">
                                            <i data-lucide="calendar-clock" class="w-3.5 h-3.5"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 px-4 text-center">
                                <div class="max-w-md mx-auto flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-amber-50 border border-amber-200/70 text-amber-600 flex items-center justify-center mb-4 shadow-2xs">
                                        <i data-lucide="calendar-check-2" class="w-8 h-8 stroke-[1.75]"></i>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900 tracking-tight">
                                        No se encontraron citas en este criterio
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                                        No tienes citas agendadas con los filtros o el estado seleccionado actualmente.
                                    </p>
                                    @if(request('buscar') || request('fecha') || (request('estado') && request('estado') !== 'TODAS'))
                                        <a href="{{ route('barbero.citas.index') }}" class="mt-4 px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition-all inline-flex items-center gap-1.5 shadow-2xs active:scale-95">
                                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                            <span>Restablecer Filtros</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $citas->links() }}
        </div>
    </div>

</div>

<!-- Reutilizar modales de Finalizar, Cancelar y Reprogramar -->
<!--MODAL: FINALIZAR SERVICIO y NOTAS TÉCNICAS-->
<div id="modalFinalizar" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200 my-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 font-serif text-xl tracking-tight">Finalizar Servicio</h3>
            <button onclick="cerrarModalFinalizar()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <form id="formFinalizar" method="POST" class="mt-4 space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5 tracking-wider">
                    Ficha Técnica y Notas del Corte
                </label>
                <textarea name="observacion" rows="3" required
                        placeholder="Ej: Degradado medio 0.5 a los lados, tijera arriba, perfilado de barba con toalla caliente..."
                        class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 p-3 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all placeholder:text-slate-400"></textarea>
            </div>

            <div class="flex justify-end gap-2.5 pt-2">
                <button type="button" onclick="cerrarModalFinalizar()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold shadow-md shadow-amber-500/20 transition-all cursor-pointer active:scale-95">
                    Guardar & Finalizar
                </button>
            </div>
        </form>
    </div>
</div>

<!--MODAL: CANCELAR CITA -->
<div id="modalCancelar" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200 my-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 font-serif text-xl tracking-tight text-rose-900">Rechazar y Cancelar Cita</h3>
            <button onclick="cerrarModalCancelar()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form id="formCancelar" method="POST" class="mt-4 space-y-4">
            @csrf
            @method('PATCH')
            <input type="hidden" name="estado" value="CANCELADA">

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5 tracking-wider">Motivo de Cancelación</label>
                <textarea name="motivo_cancelacion" rows="3" required placeholder="Ingresa el motivo detallado de la cancelación..."
                        class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 p-3 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-400 transition-all placeholder:text-slate-400"></textarea>
            </div>

            <div class="flex justify-end gap-2.5 pt-2">
                <button type="button" onclick="cerrarModalCancelar()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors cursor-pointer">
                    Volver
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition-all cursor-pointer active:scale-95">
                    Confirmar Cancelación
                </button>
            </div>
        </form>
    </div>
</div>

<!--MODAL: REPROGRAMAR CITA -->
<div id="modalReprogramar" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200 my-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 font-serif text-xl tracking-tight">Reprogramar Cita</h3>
            <button onclick="cerrarModalReprogramar()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form id="formReprogramar" method="POST" class="mt-4 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5 tracking-wider">Nueva Fecha</label>
                    <input type="date" name="nueva_fecha" id="inputNuevaFecha" required class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 p-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5 tracking-wider">Nueva Hora</label>
                    <input type="time" name="nueva_hora" id="inputNuevaHora" required class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 p-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5 tracking-wider">Motivo de Reprogramación</label>
                <input type="text" name="motivo" placeholder="Ej: Solicitud de cliente..." class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 p-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all placeholder:text-slate-400">
            </div>
            <div class="flex justify-end gap-2.5 pt-2">
                <button type="button" onclick="cerrarModalReprogramar()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors cursor-pointer">Cerrar</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold shadow-md shadow-amber-500/20 transition-all cursor-pointer active:scale-95">Guardar Cambio</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function abrirModalFinalizar(idCita, cliente, servicio) {
        document.getElementById('formFinalizar').action = `/barbero/citas/${idCita}/finalizar`;
        document.getElementById('modalFinalizar').classList.remove('hidden');
    }
    function cerrarModalFinalizar() {
        document.getElementById('modalFinalizar').classList.add('hidden');
    }

    function abrirModalCancelar(idCita, cliente) {
        document.getElementById('formCancelar').action = `/barbero/citas/${idCita}/estado`;
        document.getElementById('modalCancelar').classList.remove('hidden');
    }
    function cerrarModalCancelar() {
        document.getElementById('modalCancelar').classList.add('hidden');
    }

    function abrirModalReprogramar(idCita, cliente, fecha, hora) {
        document.getElementById('formReprogramar').action = `/barbero/citas/${idCita}/reprogramar`;
        document.getElementById('inputNuevaFecha').value = fecha;
        document.getElementById('inputNuevaHora').value = hora;
        document.getElementById('modalReprogramar').classList.remove('hidden');
    }
    function cerrarModalReprogramar() {
        document.getElementById('modalReprogramar').classList.add('hidden');
    }
</script>
@endpush
@endsection
