@extends('layouts.app')

@section('title', 'Mis Comisiones & Rendimiento')
@section('breadcrumb', 'Barbero / Mis Comisiones')

@section('content')
<div class="space-y-6">

    <!-- 1. Header Financiero con Filtro -->
    <div class="relative overflow-hidden flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 min-w-0 flex-1">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Mis Comisiones y Liquidación
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xl">
                Transparencia total de tus ingresos devengados. Base de cálculo pactada: <strong class="text-amber-600 font-bold">40% sobre cada servicio finalizado</strong>.
            </p>
        </div>

        <!-- Filtro por Rango de Fechas (Diseño limpio sin contenedor anidado) -->
        <form method="GET" action="{{ route('barbero.comisiones.index') }}" class="relative z-10 flex items-center gap-2.5 flex-nowrap shrink-0 self-start lg:self-auto">
            <div class="flex items-center gap-2">
                <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}"
                    class="px-3.5 py-2 text-xs font-semibold rounded-xl border border-slate-200 bg-white hover:border-slate-300 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 transition-all shadow-2xs cursor-pointer">
                <span class="text-xs text-slate-400 font-medium">a</span>
                <input type="date" name="fecha_fin" value="{{ $fechaFin }}"
                    class="px-3.5 py-2 text-xs font-semibold rounded-xl border border-slate-200 bg-white hover:border-slate-300 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/25 focus:border-amber-400 transition-all shadow-2xs cursor-pointer">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold shadow-xs transition-all flex items-center gap-1.5 cursor-pointer shrink-0 whitespace-nowrap">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Filtrar</span>
            </button>
        </form>
    </div>

    <!-- 2. KPIs Financieros (Estructura Arquitectónica 3-Tier de Lujo) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Mi Comisión en el Período (Ámbar / Oro - Estilo Casual Blanco) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Comisión Período</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="wallet" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Value Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        ${{ number_format($comisionPeriodo, 2) }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Devengado
                </span>
                <span class="text-[11px] text-slate-400 font-medium truncate max-w-[150px]" title="Sobre ${{ number_format($ingresosBrutosPeriodo, 0) }} facturados en {{ $totalServiciosPeriodo }} servicios">
                    ${{ number_format($ingresosBrutosPeriodo, 0) }} • {{ $totalServiciosPeriodo }} serv.
                </span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-400 group-hover:bg-amber-500 transition-colors"></div>
        </div>

        <!-- 2. Comisión de Hoy (Índigo / Púrpura) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-indigo-300/80 hover:shadow-lg hover:shadow-indigo-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-indigo-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Ganado Hoy</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100/70 border border-indigo-200/80 text-indigo-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="sun" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Value Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        ${{ number_format($comisionHoy, 2) }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    {{ $serviciosHoy }} {{ $serviciosHoy == 1 ? 'corte' : 'cortes' }}
                </span>
                <span class="text-[11px] text-slate-400 font-medium">Jornada de hoy</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-400 group-hover:bg-indigo-500 transition-colors"></div>
        </div>

        <!-- 3. Comisión Esta Semana (Ámbar / Oro) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Semana en Curso</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="calendar" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Value Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        ${{ number_format($comisionSemana, 2) }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Semanal
                </span>
                <span class="text-[11px] text-slate-400 font-medium">Lunes a hoy</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-400 group-hover:bg-amber-500 transition-colors"></div>
        </div>

        <!-- 4. Comisión del Mes Actual (Esmeralda) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-300/80 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Mes en Curso</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="trending-up" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Value Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        ${{ number_format($comisionMes, 2) }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Mensual
                </span>
                <span class="text-[11px] text-slate-400 font-medium">Acumulado mes</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-400 group-hover:bg-emerald-500 transition-colors"></div>
        </div>
    </div>

    <!-- 3. Desglose de Servicios y Comisiones -->
    <div class="relative bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="absolute -right-12 -top-12 w-36 h-36 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs shrink-0">
                    <i data-lucide="receipt" class="w-5 h-5 stroke-[1.9]"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight font-serif">Detalle de Servicios Cobrados</h3>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-700 shadow-2xs self-start sm:self-auto">
                <span class="w-2 h-2 rounded-full {{ $citas->total() > 0 ? 'bg-amber-500 animate-pulse' : 'bg-slate-300' }}"></span>
                <span class="tabular-nums font-bold text-slate-900">{{ $citas->total() }}</span>
                <span class="text-slate-400 font-medium">liquidaciones</span>
            </div>
        </div>

        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">
                    <tr>
                        <th class="px-6 py-3.5 text-left">Fecha y Hora</th>
                        <th class="px-5 py-3.5 text-left">Cliente Atendido</th>
                        <th class="px-5 py-3.5 text-left">Servicio Realizado</th>
                        <th class="px-5 py-3.5 text-left">Tarifa Cobrada</th>
                        <th class="px-5 py-3.5 text-left">Comisión Barbero</th>
                        <th class="px-6 py-3.5 text-right">Notas Técnicas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($citas as $cita)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-slate-900 block text-sm">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</span>
                                <span class="text-slate-400 font-medium text-[11px]">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</span>
                            </td>

                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $cita->cliente->nombre }}</div>
                                <div class="text-[11px] text-slate-400">{{ $cita->cliente->telefono ?? 'Cliente verificado' }}</div>
                            </td>

                            <td class="px-5 py-4 font-semibold text-slate-800">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="scissors" class="w-3.5 h-3.5 text-amber-600"></i>
                                    <span>{{ $cita->servicio->nombre ?? 'Servicio Profesional' }}</span>
                                </div>
                            </td>

                            <td class="px-5 py-4 font-bold text-slate-900 tabular-nums text-sm">
                                ${{ number_format($cita->servicio->precio ?? 0, 0) }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 font-extrabold text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-xl border border-emerald-200/80 text-xs tabular-nums shadow-2xs">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 stroke-[2.5]"></i>
                                    ${{ number_format(($cita->servicio->precio ?? 0) * 0.40, 2) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right max-w-xs">
                                @if($cita->observacion)
                                    <span class="text-[11px] text-slate-600 truncate block italic" title="{{ $cita->observacion }}">
                                        {{ $cita->observacion }}
                                    </span>
                                @else
                                    <span class="text-[11px] text-slate-400">Servicio completado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 px-6 text-center">
                                <div class="max-w-md mx-auto flex flex-col items-center">
                                    <div class="relative flex items-center justify-center mb-4">
                                        <div class="absolute w-16 h-16 rounded-2xl bg-amber-500/10 blur-xl pointer-events-none"></div>
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-xs leading-none relative z-10">
                                            <i data-lucide="wallet" class="w-8 h-8 stroke-[1.75] block translate-y-[1px]"></i>
                                        </div>
                                    </div>

                                    <h4 class="text-base font-bold text-slate-900 font-serif tracking-tight">Sin servicios finalizados</h4>
                                    <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                                        No hay servicios registrados ni liquidados en el rango de fechas seleccionado.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($citas->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $citas->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
