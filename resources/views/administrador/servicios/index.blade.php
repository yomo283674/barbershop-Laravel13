@extends('layouts.app')

@section('title', 'Catálogo de Servicios')
@section('breadcrumb', 'Servicios')



@section('content')
<div class="space-y-6">

    <!-- Header Section de Lujo -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 font-serif">
                    Catálogo de Servicios
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Gestiona la carta de cortes, barbería clásica, tratamientos VIP y sus tarifas oficiales.
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button type="button" onclick="openModal('modalNuevaCategoria')" 
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl font-bold text-xs text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-all cursor-pointer">
                <i data-lucide="folder-plus" class="w-4 h-4 text-amber-600"></i>
                <span>Nueva Categoría</span>
            </button>

            <button type="button" onclick="openModal('modalNuevoServicio')" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md hover:shadow-lg transition-all cursor-pointer shrink-0">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Nuevo Servicio</span>
            </button>
        </div>
    </div>

    <!-- 4 Métricas de Servicios con Estilo Premium -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Carta -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Carta</span>
                <span class="p-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-slate-700 group-hover:scale-110 transition-transform">
                    <i data-lucide="layers" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">{{ $totalServicios }}</h3>
                <p class="text-xs text-slate-400 mt-1">Servicios registrados</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-800"></div>
        </div>

        <!-- Activos en Menú -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Activos en Menú</span>
                <span class="p-2.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="sparkles" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight font-arial">{{ $serviciosActivos }}</h3>
                <p class="text-xs text-slate-400 mt-1">Disponibles para reserva</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
        </div>

        <!-- Precio Promedio -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Precio Promedio</span>
                <span class="p-2.5 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-amber-600 tracking-tight font-arial">${{ number_format($precioPromedio, 0) }}</h3>
                <p class="text-xs text-slate-400 mt-1">Tarifa media por servicio</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
        </div>

        <!-- Duración Media -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Duración Media</span>
                <span class="p-2.5 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">{{ $duracionPromedio }} <span class="text-lg font-bold text-slate-400">min</span></h3>
                <p class="text-xs text-slate-400 mt-1">Tiempo de atención base</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-indigo-500"></div>
        </div>
    </div>

    <!-- Barra de Búsqueda y Filtros Rápidos -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.servicios.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            @if(request('categoria') && request('categoria') !== 'TODAS')
                <input type="hidden" name="categoria" value="{{ request('categoria') }}">
            @endif
            @if(request('per_page'))
                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
            @endif

            <div class="sm:col-span-8 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-amber-500">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" 
                    name="buscar" 
                    value="{{ request('buscar') }}" 
                    placeholder="Buscar por nombre o descripción de servicio..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-medium outline-none focus:ring-2 focus:ring-amber-400/30 transition-all">
            </div>

            <div class="sm:col-span-3">
                <select name="estado" class="w-full py-2.5 px-3 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-amber-400/30 transition-all cursor-pointer">
                    <option value="TODOS">Todos los estados</option>
                    <option value="ACTIVO" {{ request('estado') === 'ACTIVO' ? 'selected' : '' }}>Activos</option>
                    <option value="INACTIVO" {{ request('estado') === 'INACTIVO' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>

            <div class="sm:col-span-1 flex items-center gap-1.5">
                <button type="submit" class="flex-1 py-2.5 px-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-2xs transition-all flex items-center justify-center gap-1 cursor-pointer" title="Aplicar filtros">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                </button>
                @if(request()->hasAny(['buscar', 'categoria', 'estado']))
                    <a href="{{ route('admin.servicios.index') }}" class="py-2.5 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-all shadow-2xs flex items-center justify-center" title="Limpiar filtros">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Barra de Pestañas de Categoría (Segmented Pills para Navegación Rápida) -->
    <div class="flex items-center gap-1.5 bg-slate-100/90 p-1.5 rounded-2xl border border-slate-200/70 overflow-x-auto max-w-full text-xs font-semibold">
        <a href="{{ route('admin.servicios.index', request()->except('categoria', 'page')) }}" 
           class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 {{ !request('categoria') || request('categoria') === 'TODAS' ? 'bg-white text-slate-950 font-bold shadow-xs border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
            <i data-lucide="layers" class="w-3.5 h-3.5 {{ !request('categoria') || request('categoria') === 'TODAS' ? 'text-amber-600' : 'text-slate-400' }}"></i>
            <span>Todas las Categorías</span>
            <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold font-arial {{ !request('categoria') || request('categoria') === 'TODAS' ? 'bg-slate-900 text-white' : 'bg-slate-200 text-slate-600' }}">
                {{ $totalServicios }}
            </span>
        </a>

        @foreach($categorias as $cat)
            @php
                $catActiva = request('categoria') == $cat->id_categoria;
            @endphp
            <a href="{{ route('admin.servicios.index', array_merge(request()->except('page'), ['categoria' => $cat->id_categoria])) }}" 
               class="px-3.5 py-2 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 {{ $catActiva ? 'bg-white text-amber-900 font-bold shadow-xs border border-amber-300' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $catActiva ? 'bg-amber-500 animate-pulse' : 'bg-amber-400' }}"></span>
                <span>{{ $cat->nombre }}</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold font-arial {{ $catActiva ? 'bg-amber-100 text-amber-900 border border-amber-200' : 'bg-slate-200 text-slate-600' }}">
                    {{ $cat->servicios_count }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Contenedor Principal del Catálogo de Servicios (Sin hilera infinita vertical) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
        
        <!-- Header del Contenedor de Servicios -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0 shadow-2xs">
                    <i data-lucide="scissors" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 font-serif">
                            Carta Oficial de Servicios
                        </h2>
                        <span class="text-xs font-bold text-slate-700 bg-slate-100 border border-slate-200/80 px-2.5 py-0.5 rounded-full">
                            <span class="font-arial font-bold">{{ $servicios->total() }}</span> {{ $servicios->total() === 1 ? 'Servicio' : 'Servicios' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Precios oficiales, duraciones estimadas y barberos especialistas asignados</p>
                </div>
            </div>

            <!-- Selector de Vista (Filas Compactas vs Cuadrícula) -->
            <div class="inline-flex items-center gap-1 bg-slate-100/90 p-1 rounded-2xl border border-slate-200/70 shrink-0">
                <button type="button" 
                        id="btnViewFilas"
                        onclick="setServiciosView('filas')" 
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 bg-white text-slate-950 shadow-xs border border-slate-200/80 cursor-pointer"
                        title="Vista en Filas Compactas">
                    <i data-lucide="rows-3" class="w-3.5 h-3.5 text-amber-600"></i>
                    <span>Compacta</span>
                </button>
                <button type="button" 
                        id="btnViewGrid"
                        onclick="setServiciosView('grid')" 
                        class="px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-500 hover:text-slate-900 transition-all flex items-center gap-1.5 border border-transparent cursor-pointer"
                        title="Vista en Cuadrícula">
                    <i data-lucide="grid-2x2" class="w-3.5 h-3.5"></i>
                    <span>Cuadrícula</span>
                </button>
            </div>
        </div>

        <!-- Contenedor Limpio y Organizado por Categorías -->
        <div id="contenedorServicios" class="p-4 sm:p-5 min-h-[360px] space-y-6">
            @php
                $serviciosAgrupados = $servicios->getCollection()->groupBy(function($s) {
                    return $s->categoria->nombre ?? 'Otras Categorías';
                });
            @endphp

            @forelse($serviciosAgrupados as $nombreCategoria => $itemsDeCategoria)
                <div class="category-block space-y-3">
                    
                    <!-- Subencabezado de Categoría con Resumen -->
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-serif">
                                {{ $nombreCategoria }}
                            </h3>
                            <span class="text-[11px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full font-arial">
                                {{ $itemsDeCategoria->count() }} {{ $itemsDeCategoria->count() === 1 ? 'servicio' : 'servicios' }}
                            </span>
                        </div>
                        <span class="text-xs text-slate-400 font-medium hidden sm:inline-block">
                            Tarifa: <span class="font-arial font-bold text-slate-700">${{ number_format($itemsDeCategoria->min('precio'), 0) }}{{ $itemsDeCategoria->min('precio') != $itemsDeCategoria->max('precio') ? ' - $' . number_format($itemsDeCategoria->max('precio'), 0) : '' }}</span>
                        </span>
                    </div>

                    <!-- VISTA 1: Filas Compactas y Responsivas (Por Defecto) -->
                    <div class="view-filas space-y-2.5">
                        @foreach($itemsDeCategoria as $servicio)
                            <div class="group p-3.5 sm:p-4 rounded-2xl bg-white hover:bg-slate-50/90 border border-slate-200/80 hover:border-amber-400/50 shadow-2xs hover:shadow-xs transition-all flex flex-col md:flex-row md:items-center justify-between gap-3 {{ $servicio->estado === 'INACTIVO' ? 'opacity-70 bg-slate-50/40' : '' }}">
                                
                                <!-- Columna 1: Imagen del Servicio + Nombre + Descripción -->
                                <div class="flex items-center gap-3.5 min-w-0 md:w-5/12">
                                    <div class="relative w-12 h-12 rounded-2xl overflow-hidden shrink-0 border border-slate-200/90 group-hover:border-amber-400/60 shadow-2xs group-hover:scale-105 transition-all duration-300 bg-slate-900 flex items-center justify-center cursor-pointer"
                                         @if($servicio->imagen) onclick="verFotoServicio('{{ asset($servicio->imagen) }}', '{{ addslashes($servicio->nombre) }}')" title="Clic para ampliar foto" @endif>
                                        @if($servicio->imagen)
                                            <img src="{{ asset($servicio->imagen) }}" 
                                                alt="{{ $servicio->nombre }}" 
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                 loading="lazy">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/25 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                <i data-lucide="maximize-2" class="w-3.5 h-3.5 text-white drop-shadow-md"></i>
                                            </div>
                                        @else
                                            <div class="w-full h-full bg-amber-500/10 text-amber-700 flex items-center justify-center font-bold">
                                                <i data-lucide="scissors" class="w-4 h-4"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-900 text-sm truncate group-hover:text-amber-800 transition-colors font-serif">
                                            {{ $servicio->nombre }}
                                        </h4>
                                        <p class="text-xs text-slate-400 truncate mt-0.5" title="{{ $servicio->descripcion }}">
                                            {{ $servicio->descripcion ?? 'Servicio profesional de barbería con acabados premium.' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Columna 2: Atributos (Duración & Especialista) -->
                                <div class="flex items-center gap-2 flex-wrap text-xs md:w-3/12">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 border border-slate-200/80 font-medium text-slate-700 shrink-0">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i>
                                        <span><strong class="font-arial font-bold">{{ $servicio->duracion_min }}</strong> min</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 border border-slate-200/80 font-medium text-slate-700 truncate" title="{{ $servicio->barbero ? $servicio->barbero->nombre : 'Cualquier barbero' }}">
                                        <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span class="truncate">{{ $servicio->barbero ? $servicio->barbero->nombre : 'General' }}</span>
                                    </span>
                                </div>

                                <!-- Columna 3: Tarifa + Estado + Acciones -->
                                <div class="flex items-center justify-between md:justify-end gap-3.5 shrink-0 pt-2.5 md:pt-0 border-t md:border-t-0 border-slate-100 md:w-4/12">
                                    <!-- Tarifa Oficial con Tipografía Arial -->
                                    <div class="text-right">
                                        <span class="text-sm sm:text-base font-extrabold font-arial text-slate-900 block leading-none tracking-tight">
                                            ${{ number_format($servicio->precio, 0) }}
                                        </span>
                                    </div>

                                    <!-- Estado Badge -->
                                    <div>
                                        @if($servicio->estado === 'ACTIVO')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/90 shadow-2xs">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                <span>Activo</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200 shadow-2xs">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                <span>Inactivo</span>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Botones de Acción -->
                                    <div class="flex items-center gap-1.5">
                                        <!-- Toggle Estado -->
                                        <form method="POST" action="{{ route('admin.servicios.estado', $servicio) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="p-2 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $servicio->estado === 'ACTIVO' ? 'text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200/70' : 'text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/70' }}"
                                                    title="{{ $servicio->estado === 'ACTIVO' ? 'Pausar disponibilidad' : 'Activar en carta' }}">
                                                <i data-lucide="{{ $servicio->estado === 'ACTIVO' ? 'pause' : 'play' }}" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>

                                        <!-- Editar Servicio -->
                                        <button type="button" 
                                                onclick="abrirModalEditarServicio({{ json_encode($servicio) }})" 
                                                class="p-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer"
                                                title="Editar detalles del servicio">
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-400"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <!-- VISTA 2: Cuadrícula con Tarjetas Visuales y Fotos -->
                    <div class="view-grid hidden grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($itemsDeCategoria as $servicio)
                            <div class="group rounded-3xl bg-white hover:bg-slate-50/90 border border-slate-200/80 hover:border-amber-400/50 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between overflow-hidden {{ $servicio->estado === 'INACTIVO' ? 'opacity-75 bg-slate-50/40' : '' }}">
                                <!-- Header Visual con Imagen del Servicio -->
                                <div class="relative w-full h-36 bg-slate-950 overflow-hidden flex items-center justify-center cursor-pointer"
                                    @if($servicio->imagen) onclick="verFotoServicio('{{ asset($servicio->imagen) }}', '{{ addslashes($servicio->nombre) }}')" title="Clic para ampliar foto" @endif>
                                    @if($servicio->imagen)
                                        <img src="{{ asset($servicio->imagen) }}" 
                                            alt="{{ $servicio->nombre }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                            loading="lazy">
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/30 pointer-events-none"></div>
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <span class="p-2 rounded-xl bg-slate-950/80 backdrop-blur-md text-white border border-white/20 shadow-lg">
                                                <i data-lucide="maximize-2" class="w-4 h-4 text-amber-400"></i>
                                            </span>
                                        </div>
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-[#182032] via-[#0f1422] to-[#0a0d17] flex flex-col items-center justify-center text-amber-400">
                                            <div class="w-12 h-12 rounded-2xl bg-white/5 border border-amber-500/30 flex items-center justify-center text-amber-400 shadow-md">
                                                <i data-lucide="scissors" class="w-6 h-6"></i>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Badges flotantes sobre la imagen -->
                                    <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between pointer-events-none">
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-amber-300 bg-slate-950/85 backdrop-blur-md px-2.5 py-1 rounded-lg border border-amber-500/30 shadow-xs">
                                            <i data-lucide="scissors" class="w-3 h-3 text-amber-400"></i>
                                            {{ $nombreCategoria }}
                                        </span>

                                        @if($servicio->estado === 'ACTIVO')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/90 text-white backdrop-blur-md shadow-xs border border-emerald-400/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-900/90 text-slate-300 backdrop-blur-md shadow-xs border border-slate-700/60">
                                                Inactivo
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Contenido de la Tarjeta -->
                                <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-base font-serif group-hover:text-amber-800 transition-colors">
                                            {{ $servicio->nombre }}
                                        </h4>
                                        <p class="text-xs text-slate-400 line-clamp-2 mt-1 leading-relaxed">
                                            {{ $servicio->descripcion ?? 'Servicio profesional de barbería con acabados premium.' }}
                                        </p>

                                        <div class="mt-3.5 flex items-center justify-between text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                            <span class="flex items-center gap-1.5 font-medium">
                                                <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-600"></i>
                                                <span><strong class="font-arial font-bold">{{ $servicio->duracion_min }}</strong> min</span>
                                            </span>
                                            <span class="truncate max-w-[130px] font-semibold text-slate-700 flex items-center gap-1">
                                                <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                                                <span class="truncate">{{ $servicio->barbero ? $servicio->barbero->nombre : 'General' }}</span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                        <div>
                                            <span class="text-xs text-slate-400 block font-medium">Tarifa</span>
                                            <span class="text-base sm:text-lg font-extrabold font-arial text-slate-900 tracking-tight">
                                                ${{ number_format($servicio->precio, 0) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <form method="POST" action="{{ route('admin.servicios.estado', $servicio) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="p-2 rounded-xl text-xs font-bold transition-all cursor-pointer {{ $servicio->estado === 'ACTIVO' ? 'text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200/70' : 'text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/70' }}"
                                                        title="{{ $servicio->estado === 'ACTIVO' ? 'Pausar disponibilidad' : 'Activar en carta' }}">
                                                    <i data-lucide="{{ $servicio->estado === 'ACTIVO' ? 'pause' : 'play' }}" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                            <button type="button" 
                                                    onclick="abrirModalEditarServicio({{ json_encode($servicio) }})" 
                                                    class="p-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer"
                                                    title="Editar detalles del servicio">
                                                <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-400"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            @empty
                <!-- Empty State de Servicios -->
                <div class="py-14 px-4 text-center">
                    <div class="max-w-md mx-auto flex flex-col items-center bg-gradient-to-b from-slate-50/70 to-white border border-slate-200/80 rounded-3xl p-8 sm:p-10 shadow-xs relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-36 h-36 bg-amber-500/5 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="relative mb-4">
                            <div class="w-16 h-16 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shadow-inner">
                                <i data-lucide="sparkles" class="w-8 h-8 text-amber-600"></i>
                            </div>
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white border border-slate-200 text-amber-600 flex items-center justify-center shadow-xs">
                                <i data-lucide="tag" class="w-3.5 h-3.5"></i>
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight font-serif">
                            No se encontraron servicios
                        </h3>
                        <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                            @if(request()->hasAny(['buscar', 'categoria', 'estado']))
                                No hay servicios registrados que coincidan con los filtros aplicados.
                            @else
                                Aún no se han configurado servicios en la carta. Añade el primer servicio para habilitar citas.
                            @endif
                        </p>

                        <div class="mt-6 flex flex-wrap items-center justify-center gap-2.5">
                            @if(request()->hasAny(['buscar', 'categoria', 'estado']))
                                <a href="{{ route('admin.servicios.index') }}" 
                                   class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors shadow-2xs flex items-center gap-1.5">
                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                    <span>Limpiar Filtros</span>
                                </a>
                            @endif
                            <button type="button" onclick="openModal('modalNuevoServicio')" 
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md hover:shadow-lg transition-all cursor-pointer">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                <span>Nuevo Servicio</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Footer con Paginación Premium Rediseñada -->
        <div class="px-5 py-3.5 sm:px-6 border-t border-slate-100 bg-slate-50/60 flex flex-col md:flex-row items-center justify-between gap-3.5">
            <!-- Indicador de Resultados Elegante y Limpio -->
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span>Mostrando</span>
                <span class="font-bold text-slate-900 font-arial">{{ $servicios->firstItem() ?? 0 }}–{{ $servicios->lastItem() ?? 0 }}</span>
                <span class="text-slate-400">de</span>
                <span class="font-bold text-slate-900 font-arial">{{ $servicios->total() }}</span>
                <span>servicios en carta</span>
            </div>

            <!-- Toolbar Derecha: Selector de Filas + Navegación -->
            <div class="flex items-center gap-3 flex-wrap justify-center md:justify-end">
                <!-- Selector Cantidad por Página (Segmented Control Armonioso) -->
                <div class="inline-flex items-center gap-1.5">
                    <span class="text-xs text-slate-400 font-semibold hidden sm:inline">Mostrar:</span>
                    <div class="inline-flex items-center bg-slate-100/90 p-1 rounded-2xl border border-slate-200/70">
                        @foreach([6, 8, 12, 16] as $cant)
                            <a href="{{ request()->fullUrlWithQuery(['per_page' => $cant, 'page' => 1]) }}"
                               class="px-2.5 py-1 rounded-xl text-xs font-arial transition-all {{ request('per_page', 8) == $cant ? 'bg-white text-slate-950 font-bold shadow-xs border border-slate-200/80' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60 font-semibold' }}">
                                {{ $cant }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if($servicios->hasPages())
                    <span class="h-4 w-px bg-slate-200 hidden sm:block"></span>

                    {{-- Controles de Paginación con Números Arial --}}
                    <div>
                        {{ $servicios->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- ================= MODALES ================= -->

<!-- 1. Modal Nuevo Servicio -->
<div id="modalNuevoServicio" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif">Nuevo Servicio en Carta</h3>
                    <p class="text-xs text-slate-400">Crear y publicar nuevo procedimiento o tarifa</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalNuevoServicio')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.servicios.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf

            <!-- Foto del Servicio -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto / Imagen del Servicio (Opcional)</label>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3.5">
                    <div id="crearImgWrapper" class="w-16 h-16 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center overflow-hidden shrink-0 shadow-2xs relative">
                        <div id="crearImgPlaceholder" class="flex flex-col items-center justify-center text-slate-400 text-center px-1">
                            <i data-lucide="image-plus" class="w-5 h-5 text-amber-500 mb-0.5"></i>
                            <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Sin foto</span>
                        </div>
                        <img id="crearImgPreview" src="" alt="Vista previa" class="w-full h-full object-cover hidden">
                    </div>
                    <div class="flex-1 min-w-0">
                        <input type="file" name="imagen" id="inputImagenCrearAdmin" accept="image/png,image/jpeg,image/webp,image/jpg" onchange="previewImagenAdmin(this, 'crearImgPreview', 'crearImgPlaceholder', 'btnRemoveCrearImgAdmin')" class="hidden">
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" onclick="document.getElementById('inputImagenCrearAdmin').click()" class="px-3 py-1.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition-all shadow-2xs cursor-pointer active:scale-95">
                                <i data-lucide="camera" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>Subir Foto</span>
                            </button>
                            <button type="button" id="btnRemoveCrearImgAdmin" onclick="removeImagenAdmin('inputImagenCrearAdmin', 'crearImgPreview', 'crearImgPlaceholder', 'btnRemoveCrearImgAdmin')" class="hidden px-2.5 py-1.5 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold cursor-pointer">
                                Quitar
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">JPG, PNG o WebP (máx. 5MB).</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre del Servicio *</label>
                <input type="text" name="nombre" required placeholder="Ej: Corte Degradado + Barba Express" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Categoría *</label>
                    <select name="id_categoria" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estado *</label>
                    <select name="estado" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Precio ($ COP) *</label>
                    <input type="number" step="1000" name="precio" required placeholder="35000" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Duración (Minutos) *</label>
                    <input type="number" step="5" min="5" max="240" name="duracion_min" required value="45" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Barbero Especialista (Opcional)</label>
                <select name="id_barbero" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                    <option value="">Disponible para cualquier barbero</option>
                    @foreach($barberos as $b)
                        <option value="{{ $b->id_usuario }}">{{ $b->nombre }} ({{ $b->especialidad }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Descripción del Servicio</label>
                <textarea name="descripcion" rows="2" placeholder="Detalla los procedimientos incluidos, productos aplicados y acabado final..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalNuevoServicio')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover rounded-xl shadow-md transition-all cursor-pointer">
                    Guardar Servicio
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Editar Servicio -->
<div id="modalEditarServicio" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="edit-3" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif" id="tituloEditarServicio">Editar Servicio</h3>
                    <p class="text-xs text-slate-400">Modificar tarifas, duración o detalles</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalEditarServicio')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="formEditarServicio" method="POST" action="" enctype="multipart/form-data" class="mt-5 space-y-4">
            @csrf
            @method('PUT')

            <!-- Foto del Servicio en Edición -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto / Imagen del Servicio</label>
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3.5">
                    <div id="editImgWrapper" class="w-16 h-16 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center overflow-hidden shrink-0 shadow-2xs relative">
                        <div id="editImgPlaceholder" class="flex flex-col items-center justify-center text-slate-400 text-center px-1">
                            <i data-lucide="image-plus" class="w-5 h-5 text-amber-500 mb-0.5"></i>
                            <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Sin foto</span>
                        </div>
                        <img id="editImgPreview" src="" alt="Foto del servicio" class="w-full h-full object-cover hidden">
                    </div>
                    <div class="flex-1 min-w-0">
                        <input type="file" name="imagen" id="inputImagenEditarAdmin" accept="image/png,image/jpeg,image/webp,image/jpg" onchange="previewImagenAdmin(this, 'editImgPreview', 'editImgPlaceholder', 'btnRemoveEditImgAdmin')" class="hidden">
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" onclick="document.getElementById('inputImagenEditarAdmin').click()" class="px-3 py-1.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition-all shadow-2xs cursor-pointer active:scale-95">
                                <i data-lucide="camera" class="w-3.5 h-3.5 text-amber-500"></i>
                                <span>Cambiar Foto</span>
                            </button>
                            <button type="button" id="btnRemoveEditImgAdmin" onclick="removeImagenAdmin('inputImagenEditarAdmin', 'editImgPreview', 'editImgPlaceholder', 'btnRemoveEditImgAdmin')" class="hidden px-2.5 py-1.5 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold cursor-pointer">
                                Quitar
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Selecciona una nueva foto si deseas actualizarla.</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre del Servicio *</label>
                <input type="text" name="nombre" id="edit_servicio_nombre" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Categoría *</label>
                    <select name="id_categoria" id="edit_servicio_categoria" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estado *</label>
                    <select name="estado" id="edit_servicio_estado" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Precio ($ COP) *</label>
                    <input type="number" step="1000" name="precio" id="edit_servicio_precio" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Duración (Minutos) *</label>
                    <input type="number" step="5" min="5" max="240" name="duracion_min" id="edit_servicio_duracion" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Barbero Especialista</label>
                <select name="id_barbero" id="edit_servicio_barbero" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                    <option value="">Disponible para cualquier barbero</option>
                    @foreach($barberos as $b)
                        <option value="{{ $b->id_usuario }}">{{ $b->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Descripción</label>
                <textarea name="descripcion" id="edit_servicio_descripcion" rows="2" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalEditarServicio')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white rounded-xl shadow-md transition-all cursor-pointer">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Modal Nueva Categoría -->
<div id="modalNuevaCategoria" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="folder-plus" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif">Nueva Categoría</h3>
                    <p class="text-xs text-slate-400">Crear sección para agrupar servicios</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalNuevaCategoria')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.servicios.categoria') }}" class="mt-5 space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre de la Categoría *</label>
                <input type="text" name="nombre" required placeholder="Ej: Tratamientos Capilares VIP" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Descripción (Opcional)</label>
                <input type="text" name="descripcion" placeholder="Ej: Servicios de estética y exfoliación facial" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalNuevaCategoria')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover rounded-xl shadow-md transition-all cursor-pointer">
                    Crear Categoría
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Modal Lightbox: Visualizar Foto del Servicio Ampliada -->
<div id="modalVerFotoServicio" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4" onclick="if(event.target === this) closeModal('modalVerFotoServicio')">
    <div class="relative bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-200 animate-scale-up">
        <div class="p-4 sm:p-5 flex items-center justify-between border-b border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                <h3 id="verFotoTitulo" class="font-bold text-slate-900 font-serif text-base sm:text-lg">Foto del Servicio</h3>
            </div>
            <button type="button" onclick="closeModal('modalVerFotoServicio')" class="p-1.5 rounded-xl hover:bg-slate-200 text-slate-500 transition-colors cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-4 bg-slate-950 flex items-center justify-center min-h-[260px] max-h-[70vh] overflow-hidden">
            <img id="verFotoImg" src="" alt="Foto de servicio" class="w-full h-auto max-h-[65vh] object-contain rounded-xl shadow-lg">
        </div>
        <div class="p-4 border-t border-slate-100 bg-white flex justify-end">
            <button type="button" onclick="closeModal('modalVerFotoServicio')" class="px-5 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer">
                Cerrar
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function setServiciosView(viewType) {
        const filasViews = document.querySelectorAll('.view-filas');
        const gridViews = document.querySelectorAll('.view-grid');
        const btnFilas = document.getElementById('btnViewFilas');
        const btnGrid = document.getElementById('btnViewGrid');

        if (viewType === 'grid') {
            filasViews.forEach(el => el.classList.add('hidden'));
            gridViews.forEach(el => {
                el.classList.remove('hidden');
                el.classList.add('grid');
            });
            btnGrid.classList.add('bg-white', 'text-slate-950', 'shadow-xs', 'border-slate-200/80');
            btnGrid.classList.remove('text-slate-500');
            btnFilas.classList.remove('bg-white', 'text-slate-950', 'shadow-xs', 'border-slate-200/80');
            btnFilas.classList.add('text-slate-500');
        } else {
            filasViews.forEach(el => el.classList.remove('hidden'));
            gridViews.forEach(el => {
                el.classList.add('hidden');
                el.classList.remove('grid');
            });
            btnFilas.classList.add('bg-white', 'text-slate-950', 'shadow-xs', 'border-slate-200/80');
            btnFilas.classList.remove('text-slate-500');
            btnGrid.classList.remove('bg-white', 'text-slate-950', 'shadow-xs', 'border-slate-200/80');
            btnGrid.classList.add('text-slate-500');
        }
    }

    function previewImagenAdmin(input, previewImgId, placeholderId, removeBtnId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 5 * 1024 * 1024) {
                alert('La imagen seleccionada supera el límite de 5MB.');
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

    function removeImagenAdmin(inputId, previewImgId, placeholderId, removeBtnId) {
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

    function verFotoServicio(imgUrl, nombreServicio) {
        if (!imgUrl) return;
        const img = document.getElementById('verFotoImg');
        const titulo = document.getElementById('verFotoTitulo');
        if (img) img.src = imgUrl;
        if (titulo) titulo.innerText = nombreServicio || 'Foto del Servicio';
        openModal('modalVerFotoServicio');
    }

    function abrirModalEditarServicio(servicio) {
        const form = document.getElementById('formEditarServicio');
        form.action = `/administrador/servicios/${servicio.id_servicio}`;
        document.getElementById('tituloEditarServicio').innerText = `Editar: ${servicio.nombre}`;
        
        document.getElementById('edit_servicio_nombre').value = servicio.nombre || '';
        document.getElementById('edit_servicio_categoria').value = servicio.id_categoria || '';
        document.getElementById('edit_servicio_estado').value = servicio.estado || 'ACTIVO';
        document.getElementById('edit_servicio_precio').value = Math.round(servicio.precio) || '';
        document.getElementById('edit_servicio_duracion').value = servicio.duracion_min || 45;
        document.getElementById('edit_servicio_barbero').value = servicio.id_barbero || '';
        document.getElementById('edit_servicio_descripcion').value = servicio.descripcion || '';

        // Previsualizar foto actual si existe
        const editPreview = document.getElementById('editImgPreview');
        const editPlaceholder = document.getElementById('editImgPlaceholder');
        const editBtnRemove = document.getElementById('btnRemoveEditImgAdmin');
        const inputEditar = document.getElementById('inputImagenEditarAdmin');
        if (inputEditar) inputEditar.value = '';

        if (servicio.imagen) {
            const imgPath = servicio.imagen.startsWith('http') || servicio.imagen.startsWith('/') 
                ? servicio.imagen 
                : '/' + servicio.imagen;
            editPreview.src = imgPath;
            editPreview.classList.remove('hidden');
            editPlaceholder.classList.add('hidden');
            editBtnRemove.classList.add('hidden');
        } else {
            editPreview.src = '';
            editPreview.classList.add('hidden');
            editPlaceholder.classList.remove('hidden');
            editBtnRemove.classList.add('hidden');
        }

        openModal('modalEditarServicio');
    }
</script>
@endpush
