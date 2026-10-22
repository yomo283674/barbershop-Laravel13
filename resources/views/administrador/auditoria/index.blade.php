@extends('layouts.app')

@section('title', 'Auditoría & Inteligencia de Negocio')
@section('breadcrumb', 'Auditoría')

@section('content')
<div class="space-y-6">

    <!-- Header Section de Lujo -->
    <div class="relative overflow-hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="absolute -right-8 -bottom-8 w-36 h-36 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Auditoría y Inteligencia de Negocio
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                Trazabilidad de seguridad, bitácora de eventos y reportes analíticos de rendimiento.
            </p>
        </div>

        <button type="button" onclick="openModal('modalGenerarReporte')" 
                class="relative z-10 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md shadow-amber-500/10 hover:shadow-lg transition-all cursor-pointer active:scale-95 shrink-0">
            <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
            <span>Generar Reporte</span>
        </button>
    </div>

    <!-- Pestañas de Navegación del Módulo (Segmented Control Elegante) -->
    <div class="inline-flex p-1.5 rounded-2xl bg-slate-100/90 border border-slate-200/80 gap-1.5">
        <a href="{{ route('admin.auditoria.index', ['tab' => 'auditoria']) }}" 
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all {{ $tab === 'auditoria' ? 'bg-[#182032] text-amber-400 shadow-xs border border-slate-800' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60' }}">
            <i data-lucide="shield-check" class="w-4 h-4 {{ $tab === 'auditoria' ? 'text-amber-400' : 'text-slate-400' }}"></i>
            <span>Bitácora de Auditoría</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-arial font-bold {{ $tab === 'auditoria' ? 'bg-amber-400/20 text-amber-300' : 'bg-slate-200 text-slate-600' }}">{{ $totalLogs }}</span>
        </a>

        <a href="{{ route('admin.auditoria.index', ['tab' => 'reportes']) }}" 
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all {{ $tab === 'reportes' ? 'bg-[#182032] text-amber-400 shadow-xs border border-slate-800' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60' }}">
            <i data-lucide="bar-chart-3" class="w-4 h-4 {{ $tab === 'reportes' ? 'text-amber-400' : 'text-slate-400' }}"></i>
            <span>Reportes y Rendimiento</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-arial font-bold {{ $tab === 'reportes' ? 'bg-amber-400/20 text-amber-300' : 'bg-slate-200 text-slate-600' }}">{{ $reportes->count() }}</span>
        </a>
    </div>

    @if($tab === 'auditoria')
        <!-- PESTAÑA 1: BITÁCORA DE AUDITORÍA -->

        <!-- 4 KPIs de Auditoría (Arquitectura 3-Tier de Lujo con Tipografía Arial) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- 1. Total Eventos (Ámbar / Oro) -->
            <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                <div>
                    <!-- Tier 1: Header de Categoría & Icono Elevado -->
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Total Eventos</span>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                            <i data-lucide="shield-check" class="w-5 h-5 stroke-[1.9]"></i>
                        </div>
                    </div>

                    <!-- Tier 2: Hero Numeral Principal en Tipografía Arial -->
                    <div class="mt-2.5 mb-4">
                        <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-arial tabular-nums leading-none">
                            {{ $totalLogs }}
                        </div>
                    </div>
                </div>

                <!-- Tier 3: Repisa de Estado & Contexto -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        Registros en bitácora
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">Trazabilidad</span>
                </div>
            </div>

            <!-- 2. Actividad Hoy (Dorado Cálido / Reloj) -->
            <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                <div>
                    <!-- Tier 1: Header de Categoría y Icono Elevado -->
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Actividad Hoy</span>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-yellow-100/80 border border-amber-300/80 text-amber-700 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                            <i data-lucide="clock" class="w-5 h-5 stroke-[1.9] text-amber-600"></i>
                        </div>
                    </div>

                    <!-- Tier 2: Hero Numeral Principal en Tipografía Arial -->
                    <div class="mt-2.5 mb-4">
                        <div class="text-3xl sm:text-4xl font-extrabold text-amber-600 tracking-tight font-arial tabular-nums leading-none">
                            {{ $logsHoy }}
                        </div>
                    </div>
                </div>

                <!-- Tier 3: Repisa de Estado & Contexto -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-900 border border-amber-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Acciones registradas
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">Jornada hoy</span>
                </div>
            </div>

            <!-- 3. Operaciones Exitosas (Esmeralda) -->
            <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-300/80 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                <div>
                    <!-- Tier 1: Header de Categoría & Icono Elevado -->
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Operaciones Exitosas</span>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                            <i data-lucide="check-circle-2" class="w-5 h-5 stroke-[1.9]"></i>
                        </div>
                    </div>

                    <!-- Tier 2: Hero Numeral Principal en Tipografía Arial -->
                    <div class="mt-2.5 mb-4">
                        <div class="text-3xl sm:text-4xl font-extrabold text-emerald-600 tracking-tight font-arial tabular-nums leading-none">
                            {{ $logsExitosos }}
                        </div>
                    </div>
                </div>

                <!-- Tier 3: Repisa de Estado & Contexto -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Tasa óptima ({{ $totalLogs > 0 ? round(($logsExitosos / $totalLogs) * 100, 1) : 100 }}%)
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">Integridad</span>
                </div>
            </div>

            <!-- 4. Módulos Auditados (Obsidiana / Base de Datos) -->
            <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-slate-300/80 hover:shadow-lg hover:shadow-slate-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-slate-900/5 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                <div>
                    <!-- Tier 1: Header de Categoría & Icono Elevado -->
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Módulos Auditados</span>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200/80 border border-slate-300/80 text-slate-800 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                            <i data-lucide="database" class="w-5 h-5 stroke-[1.9]"></i>
                        </div>
                    </div>

                    <!-- Tier 2: Hero Numeral Principal en Tipografía Arial -->
                    <div class="mt-2.5 mb-4">
                        <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-arial tabular-nums leading-none">
                            {{ $entidadesModificadas }}
                        </div>
                    </div>
                </div>

                <!-- Tier 3: Repisa de Estado & Contexto -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                        Tablas seguidas
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">Monitoreo</span>
                </div>
            </div>

        </div>

        <!-- Filtros de Auditoría con Estilo Luxury -->
        <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
            <form method="GET" action="{{ route('admin.auditoria.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <input type="hidden" name="tab" value="auditoria">

                <div class="sm:col-span-6 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-amber-500">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </span>
                    <input type="text" 
                        name="buscar" 
                        value="{{ request('buscar') }}" 
                        placeholder="Buscar por acción, detalle, entidad u observación..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-medium outline-none focus:ring-2 focus:ring-amber-400/30 transition-all">
                </div>

                <div class="sm:col-span-3 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i data-lucide="calendar" class="w-4 h-4 text-amber-600"></i>
                    </span>
                    <input type="date" 
                        name="fecha" 
                        value="{{ request('fecha') }}" 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-amber-400/30 transition-all cursor-pointer">
                </div>

                <div class="sm:col-span-2">
                    <select name="resultado" class="w-full py-2.5 px-3 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-amber-400/30 transition-all cursor-pointer">
                        <option value="TODOS">Todos los resultados</option>
                        <option value="EXITO" {{ request('resultado') === 'EXITO' ? 'selected' : '' }}>Éxito</option>
                        <option value="ERROR" {{ request('resultado') === 'ERROR' ? 'selected' : '' }}>Error</option>
                    </select>
                </div>

                <div class="sm:col-span-1 flex items-center gap-1.5">
                    <button type="submit" class="flex-1 py-2.5 px-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-2xs transition-all flex items-center justify-center gap-1 cursor-pointer" title="Aplicar filtros">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    </button>
                    @if(request()->hasAny(['buscar', 'fecha', 'resultado']))
                        <a href="{{ route('admin.auditoria.index', ['tab' => 'auditoria']) }}" class="py-2.5 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-all shadow-2xs flex items-center justify-center" title="Limpiar filtros">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabla de Registros de Auditoría -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            
            <!-- Toolbar Superior de la Tabla -->
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-3 bg-slate-50/40">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-serif">
                        Registro de Eventos y Trazabilidad
                    </h3>
                    <span class="text-[11px] font-bold text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-full font-arial">
                        {{ $logs->total() }} eventos
                    </span>
                </div>

                <span class="text-xs text-slate-400 font-medium hidden sm:inline-block">
                    Página <span class="font-arial font-bold text-slate-700">{{ $logs->currentPage() }}</span> de <span class="font-arial font-bold text-slate-700">{{ $logs->lastPage() }}</span>
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">
                            <th class="py-3.5 px-5 sm:px-6">Fecha / Hora</th>
                            <th class="py-3.5 px-4 sm:px-6">Usuario Responsable</th>
                            <th class="py-3.5 px-4 sm:px-6">Acción</th>
                            <th class="py-3.5 px-4 sm:px-6">Detalle y Observación</th>
                            <th class="py-3.5 px-5 sm:px-6 text-center">Resultado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($logs as $log)
                            <tr class="hover:bg-amber-50/20 transition-colors group">
                                
                                <!-- Fecha / Hora -->
                                <td class="py-4 px-5 sm:px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100/90 border border-slate-200/80 font-mono text-xs font-semibold text-slate-700">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i>
                                        <span>{{ \Carbon\Carbon::parse($log->fecha_hora)->format('d/m/Y H:i:s') }}</span>
                                    </span>
                                </td>

                                <!-- Usuario -->
                                <td class="py-4 px-4 sm:px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#182032] via-[#0f1422] to-[#0a0d17] text-amber-400 font-serif font-extrabold text-xs flex items-center justify-center shrink-0 border border-amber-500/30 shadow-2xs overflow-hidden">
                                            @if($log->usuario && $log->usuario->foto_perfil)
                                                <img src="{{ asset($log->usuario->foto_perfil) }}" 
                                                    alt="{{ $log->usuario->nombre }}" 
                                                    class="w-full h-full object-cover"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <span style="display: none;" class="w-full h-full items-center justify-center">
                                                    {{ strtoupper(substr($log->usuario->nombre ?? 'S', 0, 1)) }}
                                                </span>
                                            @else
                                                {{ strtoupper(substr($log->usuario->nombre ?? 'S', 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block font-serif group-hover:text-amber-800 transition-colors">
                                                {{ $log->usuario->nombre ?? 'Sistema Automático' }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-medium">
                                                ID: {{ $log->id_usuario ?? 'SYS' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Acción -->
                                <td class="py-4 px-4 sm:px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[11px] font-bold bg-slate-100 text-slate-800 font-mono border border-slate-200/70 shadow-2xs">
                                        {{ $log->accion }}
                                    </span>
                                </td>

                                <!-- Detalle -->
                                <td class="py-4 px-4 sm:px-6 max-w-sm">
                                    <span class="font-medium text-slate-900 block truncate" title="{{ $log->detalle }}">
                                        {{ $log->detalle }}
                                    </span>
                                    @if($log->observacion)
                                        <span class="text-[11px] text-slate-400 block truncate mt-0.5" title="{{ $log->observacion }}">
                                            {{ $log->observacion }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Resultado -->
                                <td class="py-4 px-5 sm:px-6 text-center whitespace-nowrap">
                                    @if($log->resultado === 'EXITO')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/90 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Éxito</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-800 border border-rose-200/90 shadow-2xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            <span>Error</span>
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <!-- Empty State de Auditoría -->
                            <tr>
                                <td colspan="5" class="py-14 px-4 text-center">
                                    <div class="max-w-md mx-auto flex flex-col items-center bg-gradient-to-b from-slate-50/70 to-white border border-slate-200/80 rounded-3xl p-8 sm:p-10 shadow-xs relative overflow-hidden">
                                        <div class="absolute -top-10 -right-10 w-36 h-36 bg-amber-500/5 rounded-full blur-2xl pointer-events-none"></div>

                                        <div class="relative mb-4">
                                            <div class="w-16 h-16 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shadow-inner">
                                                <i data-lucide="shield-check" class="w-8 h-8 text-amber-600"></i>
                                            </div>
                                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white border border-slate-200 text-amber-600 flex items-center justify-center shadow-xs">
                                                <i data-lucide="search" class="w-3.5 h-3.5"></i>
                                            </span>
                                        </div>

                                        <h4 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight font-serif">
                                            No hay registros de auditoría
                                        </h4>
                                        <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                                            @if(request()->hasAny(['buscar', 'fecha', 'resultado']))
                                                No se encontraron eventos que coincidan con los filtros aplicados.
                                            @else
                                                Aún no se han registrado eventos en la bitácora del sistema.
                                            @endif
                                        </p>

                                        @if(request()->hasAny(['buscar', 'fecha', 'resultado']))
                                            <div class="mt-6">
                                                <a href="{{ route('admin.auditoria.index', ['tab' => 'auditoria']) }}" 
                                                class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors shadow-2xs inline-flex items-center gap-1.5">
                                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                                    <span>Limpiar Filtros</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer con Paginación Premium Rediseñada -->
            <div class="px-5 py-3.5 sm:px-6 border-t border-slate-100 bg-slate-50/60 flex flex-col md:flex-row items-center justify-between gap-3.5">
                <!-- Indicador de Resultados Elegante y Limpio -->
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Mostrando</span>
                    <span class="font-bold text-slate-900 font-arial">{{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }}</span>
                    <span class="text-slate-400">de</span>
                    <span class="font-bold text-slate-900 font-arial">{{ $logs->total() }}</span>
                    <span>eventos en bitácora</span>
                </div>

                <!-- Toolbar Derecha: Selector de Filas + Navegación -->
                <div class="flex items-center gap-3 flex-wrap justify-center md:justify-end">
                    <!-- Selector Cantidad por Página (Segmented Control Armonioso) -->
                    <div class="inline-flex items-center gap-1.5">
                        <span class="text-xs text-slate-400 font-semibold hidden sm:inline">Mostrar:</span>
                        <div class="inline-flex items-center bg-slate-100/90 p-1 rounded-2xl border border-slate-200/70">
                            @foreach([8, 10, 15, 20] as $cant)
                                <a href="{{ request()->fullUrlWithQuery(['per_page' => $cant, 'page' => 1]) }}"
                                class="px-2.5 py-1 rounded-xl text-xs font-arial transition-all {{ request('per_page', 10) == $cant ? 'bg-white text-slate-950 font-bold shadow-xs border border-slate-200/80' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60 font-semibold' }}">
                                    {{ $cant }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if($logs->hasPages())
                        <span class="h-4 w-px bg-slate-200 hidden sm:block"></span>

                        {{-- Controles de Paginación con Números Arial --}}
                        <div>
                            {{ $logs->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>

        </div>

    @else
        <!--PESTAÑA 2: REPORTES & BUSINESS INTELLIGENCE-->

        <!-- 4 Métricas de Rendimiento VIP -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- 1. Facturación Estimada (Ámbar / Oro) -->
            <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Facturación Estimada</span>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                            <i data-lucide="coins" class="w-5 h-5 stroke-[1.9]"></i>
                        </div>
                    </div>

                    <div class="mt-2.5 mb-4">
                        <div class="text-3xl sm:text-4xl font-extrabold text-amber-600 tracking-tight font-arial tabular-nums leading-none">
                            ${{ number_format($ingresosEstimados, 0) }}
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        Citas completadas
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">Total ingresos</span>
                </div>
            </div>

            <!-- 2. Citas Completadas (Esmeralda) -->
            <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-300/80 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Citas Completadas</span>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                            <i data-lucide="check-circle-2" class="w-5 h-5 stroke-[1.9]"></i>
                        </div>
                    </div>

                    <div class="mt-2.5 mb-4">
                        <div class="text-3xl sm:text-4xl font-extrabold text-emerald-600 tracking-tight font-arial tabular-nums leading-none">
                            {{ $citasPorEstado['COMPLETADA'] ?? 0 }}
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Servicios finalizados
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">En silla</span>
                </div>
            </div>

            <!-- 3. Turnos Hoy en Sala (Azul / Indigo) -->
            <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-indigo-300/80 hover:shadow-lg hover:shadow-indigo-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-indigo-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Turnos Hoy en Sala</span>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100/70 border border-indigo-200/80 text-indigo-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                            <i data-lucide="users" class="w-5 h-5 stroke-[1.9]"></i>
                        </div>
                    </div>

                    <div class="mt-2.5 mb-4">
                        <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-arial tabular-nums leading-none">
                            {{ $turnosHoyCount }}
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                        Flujo presencial
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">Jornada</span>
                </div>
            </div>

            <!-- 4. Reportes Emitidos (Obsidiana) -->
            <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-slate-300/80 hover:shadow-lg hover:shadow-slate-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
                <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-slate-900/5 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Reportes Emitidos</span>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200/80 border border-slate-300/80 text-slate-800 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                            <i data-lucide="archive" class="w-5 h-5 stroke-[1.9]"></i>
                        </div>
                    </div>

                    <div class="mt-2.5 mb-4">
                        <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-arial tabular-nums leading-none">
                            {{ $reportes->count() }}
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/80">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                        Informes ejecutivos
                    </span>
                    <span class="text-[11px] font-medium text-slate-400">Consolidados</span>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Desglose de Citas por Estado -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                        <i data-lucide="pie-chart" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider font-serif">
                            Distribución de Agenda por Estados
                        </h3>
                        <p class="text-[11px] text-slate-400">Proporción de citas en el sistema</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @php
                        $totalCitasTodas = array_sum($citasPorEstado) ?: 1;
                    @endphp
                    @foreach(['COMPLETADA' => ['color' => 'bg-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-800 border-emerald-200'], 
                            'ACEPTADA' => ['color' => 'bg-amber-500', 'badge' => 'bg-amber-50 text-amber-800 border-amber-200'], 
                            'PENDIENTE' => ['color' => 'bg-blue-500', 'badge' => 'bg-blue-50 text-blue-800 border-blue-200'], 
                            'REPROGRAMADA' => ['color' => 'bg-purple-500', 'badge' => 'bg-purple-50 text-purple-800 border-purple-200'], 
                            'CANCELADA' => ['color' => 'bg-rose-500', 'badge' => 'bg-rose-50 text-rose-800 border-rose-200']] as $estado => $cfg)
                        @php
                            $cant = $citasPorEstado[$estado] ?? 0;
                            $pct = round(($cant / $totalCitasTodas) * 100, 1);
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-xs font-semibold mb-1.5">
                                <span class="text-slate-800 font-bold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full {{ $cfg['color'] }}"></span>
                                    <span>{{ $estado }}</span>
                                </span>
                                <div class="flex items-center gap-2">
                                    <span class="font-arial font-bold text-slate-900">{{ $cant }} citas</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full font-arial font-extrabold border shadow-2xs {{ $cfg['badge'] }}">
                                        {{ $pct }}%
                                    </span>
                                </div>
                            </div>
                            <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden p-0.5 border border-slate-200/60">
                                <div class="h-full {{ $cfg['color'] }} rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Servicios Más Solicitados -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                        <i data-lucide="flame" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider font-serif">
                            Servicios con Mayor Demanda
                        </h3>
                        <p class="text-[11px] text-slate-400">Los procedimientos más reservados</p>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($topServicios as $index => $serv)
                        <div class="py-3 flex items-center justify-between text-xs group">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-xl font-bold font-arial text-xs flex items-center justify-center {{ $index === 0 ? 'bg-amber-500 text-slate-950 shadow-xs' : 'bg-slate-100 text-slate-700' }}">
                                    #{{ $index + 1 }}
                                </span>
                                <div>
                                    <span class="font-bold text-slate-900 block font-serif group-hover:text-amber-800 transition-colors">{{ $serv->nombre }}</span>
                                    <span class="text-slate-400 flex items-center gap-2 mt-0.5">
                                        <strong class="font-arial font-extrabold text-slate-700">${{ number_format($serv->precio, 0) }}</strong>
                                        <span class="text-slate-300">•</span>
                                        <span><strong class="font-arial font-bold">{{ $serv->duracion_min }}</strong> min</span>
                                    </span>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-xl bg-amber-50 text-amber-800 font-bold border border-amber-200/80 shadow-2xs font-arial">
                                {{ $serv->citas_count }} {{ $serv->citas_count === 1 ? 'reserva' : 'reservas' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-6 text-center">No hay datos de servicios aún.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Historial de Reportes Emitidos -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/40">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-serif">
                        Informes Ejecutivos Emitidos
                    </h3>
                </div>
                <span class="text-xs text-slate-500 font-arial font-bold bg-slate-100 px-2.5 py-0.5 rounded-full">
                    {{ $reportes->count() }} emitidos
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">
                            <th class="py-3.5 px-5 sm:px-6">ID</th>
                            <th class="py-3.5 px-4 sm:px-6">Tipo Reporte</th>
                            <th class="py-3.5 px-4 sm:px-6">Generado Por</th>
                            <th class="py-3.5 px-4 sm:px-6">Periodo Analizado</th>
                            <th class="py-3.5 px-4 sm:px-6">Fecha Generación</th>
                            <th class="py-3.5 px-5 sm:px-6 text-right">Detalle</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($reportes as $rep)
                            <tr class="hover:bg-amber-50/20 transition-colors group">
                                <td class="py-4 px-5 sm:px-6 font-mono font-bold text-slate-700 whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-800">
                                        #{{ $rep->id_reporte }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 sm:px-6 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[11px] font-bold bg-amber-50 text-amber-900 border border-amber-200/80 shadow-2xs">
                                        {{ $rep->tipo_reporte }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 sm:px-6 font-medium text-slate-800 whitespace-nowrap">
                                    {{ $rep->generador->nombre ?? 'Admin' }}
                                </td>
                                <td class="py-4 px-4 sm:px-6 text-slate-600 font-mono text-xs whitespace-nowrap">
                                    {{ $rep->fecha_inicio }} a {{ $rep->fecha_fin }}
                                </td>
                                <td class="py-4 px-4 sm:px-6 font-mono text-slate-400 text-xs whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($rep->fecha_generacion)->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-4 px-5 sm:px-6 text-right whitespace-nowrap">
                                    <button type="button" 
                                            onclick="mostrarDatosReporte({{ json_encode($rep) }})" 
                                            class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-2xs transition-all cursor-pointer">
                                        Ver Resumen
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-400 text-xs">
                                    Aún no se han generado reportes consolidados. Haz clic en "Generar Reporte" arriba.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @endif

</div>

<!--MODALES VIP-->

<!-- 1. Modal Generar Reporte -->
<div id="modalGenerarReporte" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif">Generar Reporte</h3>
                    <p class="text-xs text-slate-400">Consolidar métricas operativas y financieras</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalGenerarReporte')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.auditoria.reporte') }}" class="mt-5 space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipo de Reporte</label>
                <select name="tipo_reporte" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                    <option value="RESUMEN_EJECUTIVO">Resumen Ejecutivo General</option>
                    <option value="FINANCIERO_VENTAS">Financiero y Ventas de Servicios</option>
                    <option value="PRODUCTIVIDAD_EQUIPO">Productividad del Equipo de Barberos</option>
                    <option value="OPERACION_SALA">Operación de Sala y Tiempos de Espera</option>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Fecha Inicio *</label>
                    <input type="date" name="fecha_inicio" required value="{{ now()->startOfMonth()->toDateString() }}" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Fecha Fin *</label>
                    <input type="date" name="fecha_fin" required value="{{ now()->toDateString() }}" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalGenerarReporte')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover rounded-xl shadow-md transition-all cursor-pointer">
                    Generar y Consolidar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Detalle de Reporte -->
<div id="modalDetalleReporte" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[88vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="bar-chart-2" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif" id="detalleReporteTitulo">Resumen de Reporte</h3>
                    <p class="text-xs text-slate-400">Detalle consolidado del informe ejecutivo</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalDetalleReporte')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div id="detalleReporteCuerpo" class="mt-5 space-y-3 text-xs">
            <!-- Dinámico -->
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end mt-4">
            <button type="button" onclick="closeModal('modalDetalleReporte')" class="px-5 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer">
                Cerrar
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function mostrarDatosReporte(rep) {
        document.getElementById('detalleReporteTitulo').innerText = `Reporte #${rep.id_reporte}: ${rep.tipo_reporte}`;
        const contenedor = document.getElementById('detalleReporteCuerpo');
        
        let datos = {};
        try {
            datos = typeof rep.datos === 'string' ? JSON.parse(rep.datos) : rep.datos;
        } catch(e) {
            datos = { contenido: rep.datos };
        }

        let html = `
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 space-y-1.5 mb-3">
                <div class="flex justify-between font-bold text-slate-900 text-xs">
                    <span>Periodo Analizado:</span>
                    <span class="font-mono text-amber-800">${rep.fecha_inicio} al ${rep.fecha_fin}</span>
                </div>
                <div class="flex justify-between text-slate-500 text-[11px]">
                    <span>Generado por:</span>
                    <span class="font-semibold text-slate-700">${rep.generador ? rep.generador.nombre : 'Admin'}</span>
                </div>
            </div>
            <div class="space-y-2">
        `;

        for (const [key, val] of Object.entries(datos)) {
            const formattedKey = key.replace(/_/g, ' ').toUpperCase();
            const formattedVal = typeof val === 'number' && key.includes('ingreso') ? `$${val.toLocaleString('es-CO')}` : val;
            html += `
                <div class="flex justify-between items-center py-2 px-3.5 rounded-xl bg-slate-50/70 border border-slate-200/60 hover:bg-white transition-colors">
                    <span class="text-slate-500 font-semibold text-[11px]">${formattedKey}:</span>
                    <span class="font-extrabold font-arial text-slate-900 text-xs sm:text-sm">${formattedVal}</span>
                </div>
            `;
        }

        html += `</div>`;
        contenedor.innerHTML = html;
        openModal('modalDetalleReporte');
    }
</script>
@endpush
