@extends('layouts.app')

@section('title', 'Mis Servicios Personalizados')
@section('breadcrumb', 'Barbero / Mis Servicios')

@section('content')
<div class="space-y-6">

    <!-- Header del Portafolio -->
    <div class="relative overflow-hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Mis Servicios
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Crea y personaliza las técnicas, fotos de cortes y tarifas que los clientes verán al agendar contigo.
            </p>
        </div>

        <button onclick="abrirModalCrear()" class="relative z-10 px-5 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-amber-500/20 transition-all shrink-0 cursor-pointer active:scale-95">
            <span>Crear Nuevo Servicio</span>
        </button>
    </div>

    <!-- KPIs del Catálogo Personal (Estructura Arquitectónica 3-Tier de Lujo Artesanal) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Servicios Creados (Ámbar) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Servicios Creados</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="scissors" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $totalServicios }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Portafolio propio
                </span>
                <span class="text-[11px] font-medium text-slate-400">Total catálogo</span>
            </div>
        </div>

        <!-- 2. Servicios Activos (Esmeralda) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-300/80 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Servicios Activos</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="sparkles" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $serviciosActivos }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $serviciosActivos > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $serviciosActivos > 0 ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                    Disponibles al cliente
                </span>
                <span class="text-[11px] font-medium text-slate-400">En vitrina</span>
            </div>
        </div>

        <!-- 3. Tarifa Promedio (Oro / Ámbar Cálido) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Tarifa Promedio</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="coins" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        ${{ number_format($precioPromedio, 0) }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Por corte/técnica
                </span>
                <span class="text-[11px] font-medium text-slate-400">Precio promedio</span>
            </div>
        </div>

        <!-- 4. Duración Promedio (Índigo) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-indigo-300/80 hover:shadow-lg hover:shadow-indigo-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-indigo-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Duración Promedio</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100/70 border border-indigo-200/80 text-indigo-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="clock" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                            {{ $duracionPromedio }}
                        </span>
                        <span class="text-base sm:text-lg font-bold text-slate-400 font-sans">min</span>
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-800 border border-indigo-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    Estimado en silla
                </span>
                <span class="text-[11px] font-medium text-slate-400">Por servicio</span>
            </div>
        </div>

    </div>

    <!-- Barra de Filtros -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('barbero.servicios.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o descripción..."
                    class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 pl-9.5 pr-3 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all placeholder:text-slate-400">
            </div>

            <div>
                <select name="categoria" onchange="this.form.submit()" class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all text-slate-700 cursor-pointer">
                    <option value="TODAS">Todas las Categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id_categoria }}" {{ request('categoria') == $cat->id_categoria ? 'selected' : '' }}>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <select name="estado" onchange="this.form.submit()" class="w-full text-xs rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-400 transition-all text-slate-700 cursor-pointer">
                    <option value="TODOS">Todos los Estados</option>
                    <option value="ACTIVO" {{ request('estado') === 'ACTIVO' ? 'selected' : '' }}>Solo Activos</option>
                    <option value="INACTIVO" {{ request('estado') === 'INACTIVO' ? 'selected' : '' }}>Solo Pausados</option>
                </select>
                <a href="{{ route('barbero.servicios.index') }}" class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-slate-900 text-xs font-semibold hover:bg-slate-50 transition-colors flex items-center justify-center gap-1.5 shrink-0" title="Limpiar filtros">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Limpiar</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Grid de Tarjetas de Servicios (Con Imagen de Corte de Cabello) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($servicios as $servicio)
            <div class="relative bg-white rounded-2xl border border-slate-200/90 shadow-xs hover:border-amber-300/80 hover:shadow-xl hover:shadow-amber-500/5 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                
                <!-- Encabezado Visual: Foto del Corte o Placeholder Estilizado -->
                @if($servicio->imagen)
                    <div class="relative h-52 w-full overflow-hidden bg-slate-950">
                        <img src="{{ $servicio->imagen }}" alt="{{ $servicio->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                        <!-- Gradiente cinemático de contraste -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-black/35 pointer-events-none"></div>

                        <!-- Badges Superiores Flotantes -->
                        <div class="absolute top-3.5 left-3.5 right-3.5 flex items-center justify-between pointer-events-none">
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold uppercase tracking-widest text-amber-300 bg-slate-950/85 backdrop-blur-md px-3 py-1.5 rounded-xl border border-amber-400/40 shadow-sm">
                                <i data-lucide="scissors" class="w-3 h-3 text-amber-400"></i>
                                {{ $servicio->categoria->nombre ?? 'Servicio' }}
                            </span>

                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1 rounded-full backdrop-blur-md shadow-sm {{ $servicio->estado === 'ACTIVO' ? 'bg-emerald-500/95 text-white border border-emerald-400/40' : 'bg-slate-800/95 text-slate-300 border border-slate-700/60' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $servicio->estado === 'ACTIVO' ? 'bg-white animate-pulse' : 'bg-slate-400' }}"></span>
                                {{ $servicio->estado === 'ACTIVO' ? 'Activo' : 'Pausado' }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="relative h-44 w-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(245,158,11,0.15),transparent_70%)]"></div>
                        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-amber-400/30 shadow-xl flex items-center justify-center text-amber-400 backdrop-blur-md group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <i data-lucide="scissors" class="w-7 h-7 stroke-[1.75]"></i>
                        </div>
                        <div class="absolute top-3.5 left-3.5 right-3.5 flex items-center justify-between pointer-events-none">
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold uppercase tracking-widest text-amber-300 bg-slate-950/85 backdrop-blur-md px-3 py-1.5 rounded-xl border border-amber-400/40 shadow-sm">
                                <i data-lucide="scissors" class="w-3 h-3 text-amber-400"></i>
                                {{ $servicio->categoria->nombre ?? 'Servicio' }}
                            </span>

                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1 rounded-full backdrop-blur-md shadow-sm {{ $servicio->estado === 'ACTIVO' ? 'bg-emerald-500/95 text-white border border-emerald-400/40' : 'bg-slate-800/95 text-slate-300 border border-slate-700/60' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $servicio->estado === 'ACTIVO' ? 'bg-white animate-pulse' : 'bg-slate-400' }}"></span>
                                {{ $servicio->estado === 'ACTIVO' ? 'Activo' : 'Pausado' }}
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Cuerpo de Información -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg leading-snug group-hover:text-amber-900 transition-colors">
                            {{ $servicio->nombre }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1.5 line-clamp-2 leading-relaxed min-h-[2rem]">
                            {{ $servicio->descripcion ?? 'Servicio especializado con técnicas profesionales y productos prémium.' }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3.5 border-t border-slate-100">
                        <!-- Módulos de Métrica Dual -->
                        <div class="grid grid-cols-2 gap-2.5">
                            <!-- Tarifa Cliente -->
                            <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100/90 flex flex-col justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tarifa Cliente</span>
                                <span class="mt-1 text-lg font-extrabold text-slate-900 tracking-tight tabular-nums">
                                    ${{ number_format($servicio->precio, 0) }}
                                </span>
                            </div>

                            <!-- Tiempo en Silla -->
                            <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100/90 flex flex-col justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Tiempo en Silla</span>
                                <span class="mt-1 text-sm sm:text-base font-bold text-slate-800 flex items-center gap-1.5 tabular-nums">
                                    <i data-lucide="clock" class="w-4 h-4 text-amber-600"></i>
                                    {{ $servicio->duracion_min }} min
                                </span>
                            </div>
                        </div>

                        <!-- Tu Ganancia / Comisión Calculada -->
                        <div class="mt-3 px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-amber-50/90 via-amber-100/40 to-amber-50/70 border border-amber-200/80 flex items-center justify-between shadow-2xs">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-amber-200/60 border border-amber-300/50 text-amber-800 flex items-center justify-center font-bold">
                                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-700"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase tracking-wider font-extrabold text-amber-800 block leading-tight">Tu Ganancia</span>
                                    <span class="text-[11px] font-medium text-amber-900/70">Comisión estimada (40%)</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-base sm:text-lg font-extrabold text-amber-950 font-sans tabular-nums">
                                    ${{ number_format($servicio->precio * 0.40, 0) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer de Acciones -->
                <div class="px-4 py-3 bg-slate-50/90 border-t border-slate-100 flex items-center justify-between gap-2">
                    <form action="{{ route('barbero.servicios.estado', $servicio->id_servicio) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if($servicio->estado === 'ACTIVO')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-amber-300/80 bg-white hover:bg-amber-50 text-amber-900 text-xs font-bold shadow-2xs transition-all active:scale-95 cursor-pointer">
                                <i data-lucide="pause-circle" class="w-3.5 h-3.5 text-amber-600"></i>
                                <span>Pausar</span>
                            </button>
                        @else
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-emerald-300/80 bg-white hover:bg-emerald-50 text-emerald-900 text-xs font-bold shadow-2xs transition-all active:scale-95 cursor-pointer">
                                <i data-lucide="play-circle" class="w-3.5 h-3.5 text-emerald-600"></i>
                                <span>Reactivar</span>
                            </button>
                        @endif
                    </form>

                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="abrirModalEditar({{ json_encode($servicio) }})"
                                class="w-8 h-8 rounded-xl border border-slate-200 bg-white text-slate-600 hover:text-amber-700 hover:border-amber-300 hover:bg-amber-50/60 transition-all flex items-center justify-center shadow-2xs active:scale-95 cursor-pointer" title="Editar servicio">
                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                        </button>

                        <form action="{{ route('barbero.servicios.destroy', $servicio->id_servicio) }}" method="POST" onsubmit="confirmarEliminarServicio(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-xl border border-slate-200 bg-white text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50/70 transition-all flex items-center justify-center shadow-2xs active:scale-95 cursor-pointer" title="Eliminar servicio">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-2xl border border-slate-200/80 p-8 shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-200/70 text-amber-600 flex items-center justify-center mx-auto mb-3 shadow-2xs">
                    <i data-lucide="scissors" class="w-7 h-7 stroke-[1.75]"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">No tienes servicios registrados en tu portafolio</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                    Crea tus propios servicios con fotos reales de tus cortes para que los clientes puedan elegirte al momento de reservar su cita.
                </p>
            </div>
        @endforelse
    </div>
</div>

<!-- MODAL: CREAR SERVICIO -->
<div id="modalCrear" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-lg w-full max-h-[92vh] overflow-y-auto p-6 sm:p-7 shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200 my-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 font-serif text-xl tracking-tight">Publicar Nuevo Servicio</h3>
            <button onclick="cerrarModalCrear()" class="text-slate-400 hover:text-slate-600 cursor-pointer p-1 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('barbero.servicios.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf

            <!-- Carga de Foto del Corte -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">
                    Foto / Imagen del Corte (Opcional)
                </label>
                
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3.5">
                    <!-- Vista previa en miniatura -->
                    <div id="createImgPreviewWrapper" class="w-20 h-20 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center overflow-hidden shrink-0 shadow-2xs relative">
                        <div id="createImgPlaceholder" class="flex flex-col items-center justify-center text-slate-400 text-center px-1">
                            <i data-lucide="image-plus" class="w-6 h-6 text-amber-500/80 mb-0.5"></i>
                            <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Sin foto</span>
                        </div>
                        <img id="createImgPreview" src="" alt="Vista previa del corte" class="w-full h-full object-cover hidden">
                    </div>

                    <!-- Botones de subida -->
                    <div class="flex-1 min-w-0">
                        <input type="file" name="imagen" id="inputImagenCrear" accept="image/png,image/jpeg,image/webp,image/jpg"
                            onchange="previewServiceImage(this, 'createImgPreview', 'createImgPlaceholder', 'btnRemoveCreateImg')" class="hidden">
                        
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" onclick="document.getElementById('inputImagenCrear').click()" 
                                    class="px-3.5 py-1.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition-all shadow-2xs cursor-pointer active:scale-95">
                                <i data-lucide="camera" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>Subir Foto del Corte</span>
                            </button>

                            <button type="button" id="btnRemoveCreateImg" onclick="removeServiceImage('inputImagenCrear', 'createImgPreview', 'createImgPlaceholder', 'btnRemoveCreateImg')" 
                                    class="hidden px-2.5 py-1.5 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold transition-all cursor-pointer">
                                Quitar
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5 leading-tight">
                            JPG, PNG o WebP (máx. 5MB). Muestra a los clientes el acabado visual del corte.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Nombre -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre del Servicio *</label>
                <input type="text" name="nombre" required placeholder="Ej: Fade Mid Skin & Texturizado Premium"
                    class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
            </div>

            <!-- Categoría y Tarifa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Categoría *</label>
                    <select name="id_categoria" required class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tarifa al Público ($) *</label>
                    <input type="number" name="precio" min="0" step="1000" required placeholder="35000"
                        class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                </div>
            </div>

            <!-- Duración -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Duración Estimada (Minutos) *</label>
                <input type="number" name="duracion_min" min="10" max="180" step="5" value="45" required
                    class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
            </div>

            <!-- Descripción -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Descripción del Servicio</label>
                <textarea name="descripcion" rows="3" placeholder="Describe qué incluye el servicio (lavado, productos, toalla caliente, navaja...)"
                        class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30"></textarea>
            </div>

            <div class="p-3 bg-amber-50/80 rounded-xl border border-amber-200/60 text-xs text-amber-900">
                Este servicio quedará vinculado automáticamente a tu perfil (<strong>{{ Auth::user()->nombre }}</strong>). Los clientes podrán seleccionarlo al agendar contigo.
            </div>

            <div class="flex justify-end gap-2.5 pt-2">
                <button type="button" onclick="cerrarModalCrear()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold shadow-md shadow-amber-500/20 cursor-pointer active:scale-95">
                    Guardar Servicio
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: EDITAR SERVICIO (Con soporte de Imagen del Corte) -->
<div id="modalEditar" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-lg w-full max-h-[92vh] overflow-y-auto p-6 sm:p-7 shadow-2xl border border-slate-200 animate-in fade-in zoom-in-95 duration-200 my-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 font-serif text-xl tracking-tight">Modificar Servicio</h3>
            <button onclick="cerrarModalEditar()" class="text-slate-400 hover:text-slate-600 cursor-pointer p-1 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="formEditar" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <!-- Foto del Corte en Edición -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">
                    Foto / Imagen del Corte
                </label>
                
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3.5">
                    <div id="editImgPreviewWrapper" class="w-20 h-20 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center overflow-hidden shrink-0 shadow-2xs relative">
                        <div id="editImgPlaceholder" class="flex flex-col items-center justify-center text-slate-400 text-center px-1">
                            <i data-lucide="image-plus" class="w-6 h-6 text-amber-500/80 mb-0.5"></i>
                            <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Sin foto</span>
                        </div>
                        <img id="editImgPreview" src="" alt="Vista previa del corte" class="w-full h-full object-cover hidden">
                    </div>

                    <div class="flex-1 min-w-0">
                        <input type="file" name="imagen" id="inputImagenEditar" accept="image/png,image/jpeg,image/webp,image/jpg"
                            onchange="previewServiceImage(this, 'editImgPreview', 'editImgPlaceholder', 'btnRemoveEditImg')" class="hidden">
                        
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" onclick="document.getElementById('inputImagenEditar').click()" 
                                    class="px-3.5 py-1.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition-all shadow-2xs cursor-pointer active:scale-95">
                                <i data-lucide="camera" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>Cambiar Foto</span>
                            </button>

                            <button type="button" id="btnRemoveEditImg" onclick="removeServiceImage('inputImagenEditar', 'editImgPreview', 'editImgPlaceholder', 'btnRemoveEditImg')" 
                                    class="hidden px-2.5 py-1.5 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold transition-all cursor-pointer">
                                Quitar
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5 leading-tight">
                            Selecciona una nueva imagen si deseas reemplazar la actual (máx. 5MB).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Nombre -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre del Servicio *</label>
                <input type="text" name="nombre" id="editNombre" required
                    class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
            </div>

            <!-- Categoría y Tarifa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Categoría *</label>
                    <select name="id_categoria" id="editCategoria" required class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tarifa al Público ($) *</label>
                    <input type="number" name="precio" id="editPrecio" min="0" step="1000" required
                        class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                </div>
            </div>

            <!-- Duración y Estado -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Duración (Minutos) *</label>
                    <input type="number" name="duracion_min" id="editDuracion" min="10" max="180" step="5" required
                        class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Estado *</label>
                    <select name="estado" id="editEstado" required class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                        <option value="ACTIVO">Activo (Visible al cliente)</option>
                        <option value="INACTIVO">Pausado (No disponible temporalmente)</option>
                    </select>
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Descripción</label>
                <textarea name="descripcion" id="editDescripcion" rows="3"
                        class="w-full text-xs rounded-xl border border-slate-300 p-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30"></textarea>
            </div>

            <div class="flex justify-end gap-2.5 pt-2">
                <button type="button" onclick="cerrarModalEditar()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold shadow-md shadow-amber-500/20 cursor-pointer active:scale-95">
                    Actualizar Servicio
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewServiceImage(input, previewImgId, placeholderId, removeBtnId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 5 * 1024 * 1024) {
                alert('La imagen seleccionada supera el límite máximo de 5MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById(previewImgId);
                const placeholder = document.getElementById(placeholderId);
                const removeBtn = document.getElementById(removeBtnId);

                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                }
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
                if (removeBtn) {
                    removeBtn.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function removeServiceImage(inputId, previewImgId, placeholderId, removeBtnId) {
        const input = document.getElementById(inputId);
        const previewImg = document.getElementById(previewImgId);
        const placeholder = document.getElementById(placeholderId);
        const removeBtn = document.getElementById(removeBtnId);

        if (input) input.value = '';
        if (previewImg) {
            previewImg.src = '';
            previewImg.classList.add('hidden');
        }
        if (placeholder) {
            placeholder.classList.remove('hidden');
        }
        if (removeBtn) {
            removeBtn.classList.add('hidden');
        }
    }

    function abrirModalCrear() {
        removeServiceImage('inputImagenCrear', 'createImgPreview', 'createImgPlaceholder', 'btnRemoveCreateImg');
        document.getElementById('modalCrear').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }
    function cerrarModalCrear() {
        document.getElementById('modalCrear').classList.add('hidden');
    }

    function abrirModalEditar(servicio) {
        document.getElementById('formEditar').action = `/barbero/servicios/${servicio.id_servicio}`;
        document.getElementById('editNombre').value = servicio.nombre;
        document.getElementById('editCategoria').value = servicio.id_categoria;
        document.getElementById('editPrecio').value = servicio.precio;
        document.getElementById('editDuracion').value = servicio.duracion_min;
        document.getElementById('editEstado').value = servicio.estado;
        document.getElementById('editDescripcion').value = servicio.descripcion || '';

        // Cargar imagen existente si tiene
        const editImgPreview = document.getElementById('editImgPreview');
        const editImgPlaceholder = document.getElementById('editImgPlaceholder');
        const btnRemoveEditImg = document.getElementById('btnRemoveEditImg');
        const inputImagenEditar = document.getElementById('inputImagenEditar');
        if (inputImagenEditar) inputImagenEditar.value = '';

        if (servicio.imagen) {
            if (editImgPreview) {
                editImgPreview.src = servicio.imagen;
                editImgPreview.classList.remove('hidden');
            }
            if (editImgPlaceholder) {
                editImgPlaceholder.classList.add('hidden');
            }
            if (btnRemoveEditImg) {
                btnRemoveEditImg.classList.remove('hidden');
            }
        } else {
            if (editImgPreview) {
                editImgPreview.src = '';
                editImgPreview.classList.add('hidden');
            }
            if (editImgPlaceholder) {
                editImgPlaceholder.classList.remove('hidden');
            }
            if (btnRemoveEditImg) {
                btnRemoveEditImg.classList.add('hidden');
            }
        }

        document.getElementById('modalEditar').classList.remove('hidden');
        if (window.lucide) lucide.createIcons();
    }
    function cerrarModalEditar() {
        document.getElementById('modalEditar').classList.add('hidden');
    }

    function confirmarEliminarServicio(event, form) {
        if (typeof window.confirmarEliminacion === 'function') {
            window.confirmarEliminacion(event, form, {
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                confirmText: "¡Sí, eliminar!",
                cancelText: "No, cancelar!"
            });
        } else if (form) {
            form.submit();
        }
    }
</script>
@endpush
@endsection
