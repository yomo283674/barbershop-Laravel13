@extends('layouts.app')

@section('title', 'Gestión de Citas')
@section('breadcrumb', 'Citas')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 font-serif">
                    Módulo de Citas
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Administra todas las reservas, aprueba citas pendientes y gestiona horarios de tus barberos.
            </p>
        </div>

        <button type="button" onclick="openModal('modalNuevaCita')" 
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md transition-all cursor-pointer shrink-0">
            <span>Agendar Nueva Cita</span>
        </button>
    </div>

    <!-- Status Tabs (Filtros Rápidos por Estado) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none text-xs font-semibold">
        @php
            $estadoActual = request('estado', 'TODAS');
        @endphp

        <!-- Todas -->
        <a href="{{ route('admin.citas.index', array_merge(request()->except('estado', 'page'), ['estado' => 'TODAS'])) }}" 
        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $estadoActual === 'TODAS' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-white border border-slate-200/80 text-slate-600 hover:bg-slate-50' }}">
            <span>Todas</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold {{ $estadoActual === 'TODAS' ? 'bg-slate-700 text-slate-200' : 'bg-slate-100 text-slate-700' }}">{{ $conteoTotal }}</span>
        </a>

        <!-- Pendientes -->
        <a href="{{ route('admin.citas.index', array_merge(request()->except('estado', 'page'), ['estado' => 'PENDIENTE'])) }}" 
        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $estadoActual === 'PENDIENTE' ? 'bg-amber-500 text-slate-950 font-bold shadow-xs' : 'bg-white border border-slate-200/80 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full {{ $estadoActual === 'PENDIENTE' ? 'bg-slate-950' : 'bg-amber-500 animate-pulse' }}"></span>
            <span>Pendientes</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold {{ $estadoActual === 'PENDIENTE' ? 'bg-amber-600 text-slate-950' : 'bg-amber-100 text-amber-800' }}">{{ $conteoPendientes }}</span>
        </a>

        <!-- Aceptadas -->
        <a href="{{ route('admin.citas.index', array_merge(request()->except('estado', 'page'), ['estado' => 'ACEPTADA'])) }}" 
        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $estadoActual === 'ACEPTADA' ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'bg-white border border-slate-200/80 text-slate-600 hover:bg-slate-50' }}">
            <span class="w-2 h-2 rounded-full {{ $estadoActual === 'ACEPTADA' ? 'bg-white' : 'bg-emerald-500' }}"></span>
            <span>Aceptadas</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold {{ $estadoActual === 'ACEPTADA' ? 'bg-emerald-700 text-emerald-100' : 'bg-emerald-100 text-emerald-800' }}">{{ $conteoAceptadas }}</span>
        </a>

        <!-- Reprogramadas -->
        <a href="{{ route('admin.citas.index', array_merge(request()->except('estado', 'page'), ['estado' => 'REPROGRAMADA'])) }}" 
        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $estadoActual === 'REPROGRAMADA' ? 'bg-purple-600 text-white font-bold shadow-xs' : 'bg-white border border-slate-200/80 text-slate-600 hover:bg-slate-50' }}">
            <i data-lucide="refresh-cw" class="w-3 h-3 {{ $estadoActual === 'REPROGRAMADA' ? 'text-white' : 'text-purple-600' }}"></i>
            <span>Reprogramadas</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold {{ $estadoActual === 'REPROGRAMADA' ? 'bg-purple-700 text-purple-100' : 'bg-purple-100 text-purple-800' }}">{{ $conteoReprogramadas }}</span>
        </a>

        <!-- Completadas -->
        <a href="{{ route('admin.citas.index', array_merge(request()->except('estado', 'page'), ['estado' => 'COMPLETADA'])) }}" 
        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $estadoActual === 'COMPLETADA' ? 'bg-slate-800 text-white font-bold shadow-xs' : 'bg-white border border-slate-200/80 text-slate-600 hover:bg-slate-50' }}">
            <i data-lucide="check" class="w-3 h-3 {{ $estadoActual === 'COMPLETADA' ? 'text-emerald-400' : 'text-slate-400' }}"></i>
            <span>Completadas</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold {{ $estadoActual === 'COMPLETADA' ? 'bg-slate-700 text-slate-200' : 'bg-slate-100 text-slate-700' }}">{{ $conteoCompletadas }}</span>
        </a>

        <!-- Canceladas -->
        <a href="{{ route('admin.citas.index', array_merge(request()->except('estado', 'page'), ['estado' => 'CANCELADA'])) }}" 
        class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-2 {{ $estadoActual === 'CANCELADA' ? 'bg-rose-600 text-white font-bold shadow-xs' : 'bg-white border border-slate-200/80 text-slate-600 hover:bg-slate-50' }}">
            <i data-lucide="x" class="w-3 h-3 {{ $estadoActual === 'CANCELADA' ? 'text-white' : 'text-rose-500' }}"></i>
            <span>Canceladas</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold {{ $estadoActual === 'CANCELADA' ? 'bg-rose-700 text-rose-100' : 'bg-rose-100 text-rose-800' }}">{{ $conteoCanceladas }}</span>
        </a>
    </div>

    <!-- Filters Section (Barra de Búsqueda y Filtros) -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.citas.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            @if(request('estado') && request('estado') !== 'TODAS')
                <input type="hidden" name="estado" value="{{ request('estado') }}">
            @endif

            <!-- Buscador texto -->
            <div class="lg:col-span-5 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" 
                    name="buscar" 
                    value="{{ request('buscar') }}" 
                    placeholder="Buscar por cliente, documento o teléfono..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-medium outline-none focus:ring-2 focus:ring-amber-400/30 transition-all">
            </div>

            <!-- Filtro Barbero -->
            <div class="lg:col-span-3">
                <div class="relative">
                    <select name="id_barbero" class="w-full py-2.5 px-3 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-medium outline-none focus:ring-2 focus:ring-amber-400/30 transition-all cursor-pointer">
                        <option value="">Todos los barberos</option>
                        @foreach($barberos as $bar)
                            <option value="{{ $bar->id_usuario }}" {{ request('id_barbero') == $bar->id_usuario ? 'selected' : '' }}>
                                {{ $bar->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Filtro Fecha -->
            <div class="lg:col-span-3">
                <input type="date" 
                    name="fecha" 
                    value="{{ request('fecha') }}" 
                    class="w-full py-2.5 px-3 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-amber-400/30 transition-all cursor-pointer">
            </div>

            <!-- Botones -->
            <div class="lg:col-span-1 flex items-center gap-1.5">
                <button type="submit" class="flex-1 py-2.5 px-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-2xs transition-all flex items-center justify-center gap-1 cursor-pointer" title="Aplicar filtros">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                </button>
                @if(request()->hasAny(['buscar', 'id_barbero', 'fecha', 'estado']))
                    <a href="{{ route('admin.citas.index') }}" class="py-2.5 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-all shadow-2xs" title="Limpiar filtros">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Citas Feed / List Card (Sin Scroll Horizontal y Totalmente Responsivo) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
        
        <!-- Header del Contenedor -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="calendar-check" class="w-4 h-4"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 font-serif">
                        Registros de Citas
                    </h2>
                    <p class="text-xs text-slate-400">Listado completo de reservas y control de itinerario</p>
                </div>
            </div>
            <span class="text-xs font-bold text-slate-700 bg-slate-100 border border-slate-200 px-3 py-1 rounded-full">
                Mostrando {{ $citas->count() }} de {{ $citas->total() }} registros
            </span>
        </div>

        <!-- Lista de Citas Vertical y Adaptable -->
        <div class="p-4 sm:p-5 space-y-3.5">
            @forelse($citas as $cita)
                <div class="group p-4 sm:p-5 rounded-2xl bg-white hover:bg-slate-50/90 border border-slate-200/80 hover:border-amber-400/50 shadow-2xs hover:shadow-xs transition-all {{ $cita->estado === 'CANCELADA' ? 'opacity-70 bg-slate-50/40' : '' }}">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        
                        <!-- Columna 1: ID + Fecha/Hora + Cliente -->
                        <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                            <!-- Fecha & Hora Badge -->
                            <div class="flex flex-col items-center justify-center px-3 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-800 shrink-0 min-w-[76px] text-center">
                                <span class="text-xs font-extrabold font-mono tracking-tight text-slate-900">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</span>
                                <span class="text-[10px] font-bold text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($cita->fecha)->isoFormat('D MMM, YY') }}</span>
                            </div>

                            <!-- Avatar + Info Cliente -->
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
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-slate-400">#{{ $cita->id_cita }}</span>
                                        <h4 class="font-bold text-slate-900 text-sm truncate group-hover:text-amber-800 transition-colors">
                                            {{ $cita->cliente->nombre ?? 'Cliente no registrado' }}
                                        </h4>
                                    </div>
                                    <p class="text-xs text-slate-400 flex items-center gap-2 mt-0.5 flex-wrap">
                                        <span>Doc: {{ $cita->cliente->numero_identificacion ?? 'N/A' }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="phone" class="w-3 h-3"></i>
                                            <span>{{ $cita->cliente->telefono ?? 'Sin teléfono' }}</span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Columna 2: Barbero y Servicio -->
                        <div class="flex items-center gap-2.5 flex-wrap text-xs">
                            <!-- Barbero -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 border border-slate-200/80 font-semibold text-slate-700">
                                <i data-lucide="scissors" class="w-3.5 h-3.5 text-amber-600"></i>
                                <span>{{ $cita->barbero->nombre ?? 'Por asignar' }}</span>
                            </span>

                            <!-- Servicio -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50/70 border border-amber-200/60 font-semibold text-slate-800">
                                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>{{ $cita->servicio->nombre ?? 'Servicio' }}</span>
                                <strong class="text-amber-700 font-bold ml-0.5">${{ number_format($cita->servicio->precio ?? 0, 0) }}</strong>
                            </span>
                        </div>

                        <!-- Columna 3: Estado + Acciones Funcionales -->
                        <div class="flex items-center justify-between lg:justify-end gap-3 shrink-0 pt-2.5 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                            <!-- Estado Badge -->
                            <div>
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
                            </div>

                            <!-- Acciones Rápidas -->
                            <div class="inline-flex items-center gap-1.5">
                                <!-- Aceptar Cita rápida -->
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

                                <!-- Completar Cita rápida -->
                                @if($cita->estado === 'ACEPTADA')
                                    <form method="POST" action="{{ route('admin.citas.estado', $cita) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="estado" value="COMPLETADA">
                                        <button type="submit" class="p-2 text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200/80 rounded-xl transition-all shadow-2xs cursor-pointer" title="Completar Cita">
                                            <i data-lucide="check-check" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Editar Cita (Abre modal) -->
                                <button type="button" 
                                        onclick="abrirModalEditarCita({{ json_encode($cita) }})" 
                                        class="p-2 text-slate-600 bg-slate-50 hover:bg-amber-50 hover:text-amber-700 border border-slate-200/80 rounded-xl transition-all shadow-2xs cursor-pointer" 
                                        title="Editar Cita">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>

                                <!-- Cancelar Cita -->
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
                                <span class="text-rose-700 font-medium"><strong class="font-bold">Motivo:</strong> {{ $cita->motivo_cancelacion ?? 'Cancelada' }}</span>
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
                        <div class="relative mb-4">
                            <div class="w-16 h-16 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shadow-inner">
                                <i data-lucide="calendar-x" class="w-8 h-8 text-amber-600"></i>
                            </div>
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white border border-slate-200 text-amber-600 flex items-center justify-center shadow-xs">
                                <i data-lucide="search-x" class="w-3.5 h-3.5"></i>
                            </span>
                        </div>

                        <h3 class="text-base font-bold text-slate-900 tracking-tight font-serif">
                            No se encontraron citas con los filtros seleccionados
                        </h3>
                        <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                            Intenta ajustar los criterios de búsqueda, limpia los filtros aplicados o registra una nueva reserva.
                        </p>

                        <div class="mt-5 flex items-center gap-2.5">
                            <button type="button" onclick="openModal('modalNuevaCita')" 
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover shadow-sm transition-all cursor-pointer">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                <span>+ Agendar Nueva Cita</span>
                            </button>
                            @if(request()->hasAny(['buscar', 'id_barbero', 'fecha', 'estado']))
                                <a href="{{ route('admin.citas.index') }}" 
                                class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                    Restablecer Filtros
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($citas->hasPages())
            <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/50">
                {{ $citas->links() }}
            </div>
        @endif
    </div>

</div>

<!--MODALES DE GESTIÓN -->

<!-- 1. Modal Nueva Cita -->
<div id="modalNuevaCita" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif">Agendar Nueva Cita</h3>
                    <p class="text-xs text-slate-400">Crear reserva administrativa</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalNuevaCita')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.citas.store') }}" class="mt-5 space-y-4">
            @csrf

            <!-- Cliente -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cliente</label>
                <select name="id_cliente" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                    <option value="">Selecciona un cliente</option>
                    @foreach($clientes as $cli)
                        <option value="{{ $cli->id_usuario }}">{{ $cli->nombre }} (CC: {{ $cli->numero_identificacion ?? 'N/A' }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Barbero -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Barbero</label>
                <select name="id_barbero" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                    <option value="">Selecciona un barbero</option>
                    @foreach($barberos as $bar)
                        <option value="{{ $bar->id_usuario }}">{{ $bar->nombre }} - {{ $bar->especialidad ?? 'Especialista' }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Servicio -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Servicio</label>
                <select name="id_servicio" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                    <option value="">Selecciona servicio</option>
                    @foreach($servicios as $srv)
                        <option value="{{ $srv->id_servicio }}">{{ $srv->nombre }} - ${{ number_format($srv->precio, 0) }} ({{ $srv->duracion_min }} min)</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha y Hora -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Fecha</label>
                    <input type="date" name="fecha" value="{{ now()->toDateString() }}" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-semibold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hora</label>
                    <input type="time" name="hora" value="10:00" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-semibold">
                </div>
            </div>

            <!-- Estado Inicial -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estado de Cita</label>
                <select name="estado" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                    <option value="ACEPTADA">ACEPTADA (Confirmada)</option>
                    <option value="PENDIENTE">PENDIENTE (Por confirmar)</option>
                </select>
            </div>

            <!-- Observación -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Observaciones</label>
                <textarea name="observacion" rows="2" placeholder="Preferencias, detalles de corte..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalNuevaCita')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover rounded-xl shadow-md transition-all cursor-pointer">
                    Guardar Cita
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Editar Cita -->
<div id="modalEditarCita" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="edit" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif" id="tituloEditarCita">Editar Cita</h3>
                    <p class="text-xs text-slate-400">Actualizar información de reserva</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalEditarCita')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="formEditarCita" method="POST" action="" class="mt-5 space-y-4">
            @csrf
            @method('PUT')

            <!-- Barbero -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Barbero</label>
                <select name="id_barbero" id="edit_id_barbero" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                    @foreach($barberos as $bar)
                        <option value="{{ $bar->id_usuario }}">{{ $bar->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Servicio -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Servicio</label>
                <select name="id_servicio" id="edit_id_servicio" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                    @foreach($servicios as $srv)
                        <option value="{{ $srv->id_servicio }}">{{ $srv->nombre }} - ${{ number_format($srv->precio, 0) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha y Hora -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Fecha</label>
                    <input type="date" name="fecha" id="edit_fecha" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-semibold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hora</label>
                    <input type="time" name="hora" id="edit_hora" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-semibold">
                </div>
            </div>

            <!-- Estado -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estado</label>
                <select name="estado" id="edit_estado" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                    <option value="ACEPTADA">ACEPTADA</option>
                    <option value="PENDIENTE">PENDIENTE</option>
                    <option value="REPROGRAMADA">REPROGRAMADA</option>
                    <option value="COMPLETADA">COMPLETADA</option>
                    <option value="CANCELADA">CANCELADA</option>
                </select>
            </div>

            <!-- Observación -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Observación</label>
                <textarea name="observacion" id="edit_observacion" rows="2" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium"></textarea>
            </div>

            <!-- Motivo Cancelación (opcional si cancelada) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Motivo de Cancelación</label>
                <textarea name="motivo_cancelacion" id="edit_motivo_cancelacion" rows="2" placeholder="Solo si la cita es cancelada..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalEditarCita')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white rounded-xl shadow-md transition-all cursor-pointer">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Modal Cancelar Cita -->
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
                ¿Estás seguro de que deseas cancelar esta cita? Por favor ingresa el motivo:
            </p>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Motivo de Cancelación</label>
                <textarea name="motivo_cancelacion" required rows="3" placeholder="Ej: Cliente canceló por inconveniente personal..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-rose-500 transition-all font-medium"></textarea>
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
    function abrirModalEditarCita(cita) {
        const form = document.getElementById('formEditarCita');
        form.action = `/administrador/citas/${cita.id_cita}`;
        document.getElementById('tituloEditarCita').innerText = `Editar Cita #${cita.id_cita}`;
        
        document.getElementById('edit_id_barbero').value = cita.id_barbero;
        document.getElementById('edit_id_servicio').value = cita.id_servicio;
        document.getElementById('edit_fecha').value = cita.fecha ? cita.fecha.substring(0, 10) : '';
        document.getElementById('edit_hora').value = cita.hora ? cita.hora.substring(0, 5) : '';
        document.getElementById('edit_estado').value = cita.estado;
        document.getElementById('edit_observacion').value = cita.observacion || '';
        document.getElementById('edit_motivo_cancelacion').value = cita.motivo_cancelacion || '';

        openModal('modalEditarCita');
    }

    function abrirModalCancelar(citaId) {
        const form = document.getElementById('formCancelarCita');
        form.action = `/administrador/citas/${citaId}/estado`;
        openModal('modalCancelarCita');
    }
</script>
@endpush
