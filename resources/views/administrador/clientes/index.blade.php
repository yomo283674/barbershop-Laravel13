@extends('layouts.app')

@section('title', 'Directorio de Clientes VIP')
@section('breadcrumb', 'Clientes')

@section('content')
<div class="space-y-6">

    <!-- Header Section de Lujo -->
    <div class="relative overflow-hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/80 shadow-xs">
        <div class="absolute -right-8 -bottom-8 w-36 h-36 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Comunidad & Fidelización</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Directorio de Clientes
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                Base de datos de clientes, frecuencia de visitas, fidelización e historial de cortes.
            </p>
        </div>

        <button type="button" onclick="openModal('modalNuevoCliente')" 
                class="relative z-10 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md shadow-amber-500/10 hover:shadow-lg transition-all cursor-pointer active:scale-95 shrink-0">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Registrar Cliente</span>
        </button>
    </div>

    <!-- 4 Métricas de Negocio VIP (Arquitectura 3-Tier de Lujo con Tipografía Arial) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Base Total (Ámbar / Oro) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Base Total</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="users" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal en Tipografía Arial -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-arial tabular-nums leading-none">
                        {{ $totalClientes }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Directorio general
                </span>
                <span class="text-[11px] font-medium text-slate-400">Total base</span>
            </div>
        </div>

        <!-- 2. Clientes Activos (Esmeralda) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-300/80 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Clientes Activos</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="user-check" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal en Tipografía Arial -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-emerald-600 tracking-tight font-arial tabular-nums leading-none">
                        {{ $clientesActivos }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Habilitados reservas
                </span>
                <span class="text-[11px] font-medium text-slate-400">En vitrina</span>
            </div>
        </div>

        <!-- 3. Frecuentes & VIP (Oro Cálido / Corona) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Frecuentes & VIP</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-yellow-100/80 border border-amber-300/80 text-amber-700 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="crown" class="w-5 h-5 stroke-[1.9] text-amber-600"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal en Tipografía Arial -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-arial tabular-nums leading-none">
                        {{ $clientesFrecuentes }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-900 border border-amber-200/80">
                    <i data-lucide="crown" class="w-3 h-3 text-amber-600"></i>
                    2 o más visitas
                </span>
                <span class="text-[11px] font-medium text-slate-400">Fidelizados</span>
            </div>
        </div>

        <!-- 4. Citas Completadas (Obsidiana / Azul Marino) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-slate-300/80 hover:shadow-lg hover:shadow-slate-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-slate-900/5 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Citas Completadas</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200/80 border border-slate-300/80 text-slate-800 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="check-circle-2" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal en Tipografía Arial -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-arial tabular-nums leading-none">
                        {{ $totalCitasAtendidas }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                    Servicios exitosos
                </span>
                <span class="text-[11px] font-medium text-slate-400">Finalizadas</span>
            </div>
        </div>

    </div>

    <!-- Barra de Búsqueda y Filtros con Estilo Luxury -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.clientes.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <div class="sm:col-span-8 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-amber-500">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" 
                    name="buscar" 
                    value="{{ request('buscar') }}" 
                    placeholder="Buscar cliente por nombre, cédula, teléfono o email..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-medium outline-none focus:ring-2 focus:ring-amber-400/30 transition-all">
            </div>

            <div class="sm:col-span-3">
                <select name="estado" class="w-full py-2.5 px-3 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-amber-400/30 transition-all cursor-pointer">
                    <option value="TODOS">Todos los estados</option>
                    <option value="ACTIVO" {{ in_array(request('estado'), ['ACTIVO', 'activo']) ? 'selected' : '' }}>Activos</option>
                    <option value="INACTIVO" {{ in_array(request('estado'), ['INACTIVO', 'inactivo']) ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>

            <div class="sm:col-span-1 flex items-center gap-1.5">
                <button type="submit" class="flex-1 py-2.5 px-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-2xs transition-all flex items-center justify-center gap-1 cursor-pointer" title="Aplicar filtros">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                </button>
                @if(request()->hasAny(['buscar', 'estado']))
                    <a href="{{ route('admin.clientes.index') }}" class="py-2.5 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-all shadow-2xs flex items-center justify-center" title="Limpiar filtros">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Directorio y Tabla Elegante de Clientes -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Toolbar Superior de la Tabla -->
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-3 bg-slate-50/40">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-serif">
                    Directorio de Clientes
                </h3>
                <span class="text-[11px] font-bold text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-full font-arial">
                    {{ $clientes->total() }} {{ $clientes->total() === 1 ? 'cliente' : 'clientes' }}
                </span>
            </div>

            <span class="text-xs text-slate-400 font-medium hidden sm:inline-block">
                Página <span class="font-arial font-bold text-slate-700">{{ $clientes->currentPage() }}</span> de <span class="font-arial font-bold text-slate-700">{{ $clientes->lastPage() }}</span>
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">
                        <th class="py-3.5 px-5 sm:px-6">Cliente</th>
                        <th class="py-3.5 px-4 sm:px-6">Identificación</th>
                        <th class="py-3.5 px-4 sm:px-6">Contacto</th>
                        <th class="py-3.5 px-4 sm:px-6">Segmento</th>
                        <th class="py-3.5 px-4 sm:px-6 text-center">Citas</th>
                        <th class="py-3.5 px-4 sm:px-6 text-center">Estado</th>
                        <th class="py-3.5 px-5 sm:px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($clientes as $cliente)
                        @php
                            $esActivo = in_array(strtoupper($cliente->estado), ['ACTIVO', '1']);
                        @endphp
                        <tr class="hover:bg-amber-50/20 transition-colors group">
                            
                            <!-- Nombre y Avatar Luxury -->
                            <td class="py-4 px-5 sm:px-6">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#182032] via-[#0f1422] to-[#0a0d17] text-amber-400 font-serif font-extrabold text-sm flex items-center justify-center shrink-0 border border-amber-500/30 shadow-2xs group-hover:scale-105 group-hover:border-amber-400/60 transition-transform overflow-hidden">
                                        @if($cliente->foto_perfil)
                                            <img src="{{ asset($cliente->foto_perfil) }}" 
                                                alt="{{ $cliente->nombre }}" 
                                                class="w-full h-full object-cover"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span style="display: none;" class="w-full h-full items-center justify-center">
                                                {{ strtoupper(substr($cliente->nombre, 0, 2)) }}
                                            </span>
                                        @else
                                            {{ strtoupper(substr($cliente->nombre, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <span class="font-bold text-slate-900 block text-sm font-serif group-hover:text-amber-800 transition-colors truncate">
                                            {{ $cliente->nombre }}
                                        </span>
                                        <span class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                            <i data-lucide="calendar" class="w-3 h-3 text-slate-300"></i>
                                            <span>Desde: {{ $cliente->fecha_ingreso ? \Carbon\Carbon::parse($cliente->fecha_ingreso)->format('d M, Y') : 'Preexistente' }}</span>
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Documento con Badge Mono -->
                            <td class="py-4 px-4 sm:px-6 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100/90 border border-slate-200/80 font-mono text-xs font-semibold text-slate-700">
                                    <i data-lucide="credit-card" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <span>{{ $cliente->numero_identificacion ?? 'Sin cédula' }}</span>
                                </span>
                            </td>

                            <!-- Contacto con Enlaces Directos -->
                            <td class="py-4 px-4 sm:px-6 space-y-1">
                                <div class="flex items-center gap-1.5 text-slate-700 font-medium">
                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-amber-600"></i>
                                    @if($cliente->telefono)
                                        <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $cliente->telefono) }}" 
                                        target="_blank" 
                                        class="hover:text-amber-600 font-arial font-semibold transition-colors" 
                                        title="Contactar por WhatsApp">
                                            {{ $cliente->telefono }}
                                        </a>
                                    @else
                                        <span class="text-slate-400">Sin teléfono</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-400 text-[11px]">
                                    <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                                    <a href="mailto:{{ $cliente->email }}" class="hover:text-slate-700 transition-colors truncate max-w-[170px]" title="{{ $cliente->email }}">
                                        {{ $cliente->email }}
                                    </a>
                                </div>
                            </td>

                            <!-- Fidelidad / Segmento -->
                            <td class="py-4 px-4 sm:px-6 whitespace-nowrap">
                                @if($cliente->citas_completadas_count >= 3)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-extrabold bg-gradient-to-r from-amber-500/15 via-amber-400/20 to-yellow-500/15 text-amber-900 border border-amber-300/80 shadow-2xs">
                                        <i data-lucide="crown" class="w-3.5 h-3.5 text-amber-600 fill-amber-500/20"></i>
                                        <span>VIP GOLD</span>
                                    </span>
                                @elseif($cliente->citas_completadas_count >= 1)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200/90 shadow-2xs">
                                        <i data-lucide="award" class="w-3.5 h-3.5 text-blue-600"></i>
                                        <span>FRECUENTE</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>NUEVO</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Citas Históricas en Tipografía Arial -->
                            <td class="py-4 px-4 sm:px-6 text-center whitespace-nowrap">
                                <div class="inline-flex flex-col items-center">
                                    <span class="font-extrabold text-slate-900 text-base font-arial leading-none">
                                        {{ $cliente->citas_como_cliente_count }}
                                    </span>
                                    <span class="text-[10px] font-semibold text-slate-400 mt-1">
                                        (<span class="font-arial font-bold text-slate-600">{{ $cliente->citas_completadas_count }}</span> exitosas)
                                    </span>
                                </div>
                            </td>

                            <!-- Estado con Indicador Pulsante -->
                            <td class="py-4 px-4 sm:px-6 text-center whitespace-nowrap">
                                @if($esActivo)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/90 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>Activo</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Inactivo</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Botones de Acción -->
                            <td class="py-4 px-5 sm:px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    
                                    <!-- Ver Historial de Citas -->
                                    <button type="button" 
                                            onclick="verHistorialCliente({{ $cliente->id_usuario }}, '{{ addslashes($cliente->nombre) }}')" 
                                            class="p-2 rounded-xl text-slate-600 hover:text-amber-700 hover:bg-amber-50/80 border border-slate-200/80 hover:border-amber-300/80 transition-all shadow-2xs cursor-pointer"
                                            title="Ver historial de citas">
                                        <i data-lucide="history" class="w-3.5 h-3.5 text-amber-600"></i>
                                    </button>

                                    <!-- Alternar Estado (Pausar o Habilitar) -->
                                    <form method="POST" action="{{ route('admin.clientes.estado', $cliente) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="p-2 rounded-xl transition-all shadow-2xs cursor-pointer {{ $esActivo ? 'text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200/70' : 'text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/70' }}"
                                                title="{{ $esActivo ? 'Pausar cuenta del cliente' : 'Reactivar cliente' }}">
                                            <i data-lucide="{{ $esActivo ? 'user-x' : 'user-check' }}" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>

                                    <!-- Editar Cliente -->
                                    <button type="button" 
                                            onclick="abrirModalEditarCliente({{ json_encode($cliente) }})" 
                                            class="p-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer"
                                            title="Editar información del cliente">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-400"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <!-- Empty State de Clientes -->
                        <tr>
                            <td colspan="7" class="py-14 px-4 text-center">
                                <div class="max-w-md mx-auto flex flex-col items-center bg-gradient-to-b from-slate-50/70 to-white border border-slate-200/80 rounded-3xl p-8 sm:p-10 shadow-xs relative overflow-hidden">
                                    <div class="absolute -top-10 -right-10 w-36 h-36 bg-amber-500/5 rounded-full blur-2xl pointer-events-none"></div>

                                    <div class="relative mb-4">
                                        <div class="w-16 h-16 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shadow-inner">
                                            <i data-lucide="users" class="w-8 h-8 text-amber-600"></i>
                                        </div>
                                        <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white border border-slate-200 text-amber-600 flex items-center justify-center shadow-xs">
                                            <i data-lucide="search" class="w-3.5 h-3.5"></i>
                                        </span>
                                    </div>

                                    <h4 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight font-serif">
                                        No se encontraron clientes
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                                        @if(request()->hasAny(['buscar', 'estado']))
                                            No hay clientes registrados que coincidan con los filtros aplicados.
                                        @else
                                            Aún no hay clientes registrados en la base de datos de la barbería.
                                        @endif
                                    </p>

                                    <div class="mt-6 flex flex-wrap items-center justify-center gap-2.5">
                                        @if(request()->hasAny(['buscar', 'estado']))
                                            <a href="{{ route('admin.clientes.index') }}" 
                                            class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors shadow-2xs flex items-center gap-1.5">
                                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                                <span>Limpiar Filtros</span>
                                            </a>
                                        @endif
                                        <button type="button" onclick="openModal('modalNuevoCliente')" 
                                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md hover:shadow-lg transition-all cursor-pointer">
                                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                                            <span>Registrar Cliente</span>
                                        </button>
                                    </div>
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
                <span class="font-bold text-slate-900 font-arial">{{ $clientes->firstItem() ?? 0 }}–{{ $clientes->lastItem() ?? 0 }}</span>
                <span class="text-slate-400">de</span>
                <span class="font-bold text-slate-900 font-arial">{{ $clientes->total() }}</span>
                <span>clientes en directorio</span>
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

                @if($clientes->hasPages())
                    <span class="h-4 w-px bg-slate-200 hidden sm:block"></span>

                    {{-- Controles de Paginación con Números Arial --}}
                    <div>
                        {{ $clientes->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

<!--MODALES VIP-->

<!-- 1. Modal Registrar Cliente -->
<div id="modalNuevoCliente" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="user-plus" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif">Registrar Nuevo Cliente</h3>
                    <p class="text-xs text-slate-400">Añadir cliente a la base de datos de la barbería</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalNuevoCliente')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.clientes.store') }}" class="mt-5 space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Completo *</label>
                <input type="text" name="nombre" required placeholder="Ej: Camilo Andrés Martínez" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico *</label>
                <input type="email" name="email" required placeholder="camilo@cliente.com" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teléfono Móvil</label>
                    <input type="text" name="telefono" placeholder="310 123 4567" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cédula / Documento</label>
                    <input type="text" name="numero_identificacion" placeholder="1020304050" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estado Inicial *</label>
                <select name="estado" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                    <option value="ACTIVO">Activo (Habilitado para agendar citas)</option>
                    <option value="INACTIVO">Inactivo</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalNuevoCliente')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover rounded-xl shadow-md transition-all cursor-pointer">
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Editar Cliente -->
<div id="modalEditarCliente" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="edit-3" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif" id="tituloEditarCliente">Editar Cliente</h3>
                    <p class="text-xs text-slate-400">Modificar contacto, identificación o estado</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalEditarCliente')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="formEditarCliente" method="POST" action="" class="mt-5 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Completo *</label>
                <input type="text" name="nombre" id="edit_cliente_nombre" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico *</label>
                <input type="email" name="email" id="edit_cliente_email" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teléfono</label>
                    <input type="text" name="telefono" id="edit_cliente_telefono" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cédula / Documento</label>
                    <input type="text" name="numero_identificacion" id="edit_cliente_identificacion" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estado *</label>
                <select name="estado" id="edit_cliente_estado" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                    <option value="ACTIVO">Activo</option>
                    <option value="INACTIVO">Inactivo</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalEditarCliente')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white rounded-xl shadow-md transition-all cursor-pointer">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Modal Historial de Citas del Cliente (Timeline VIP) -->
<div id="modalHistorialCliente" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[88vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="history" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif" id="historialClienteNombre">Historial de Citas</h3>
                    <p class="text-xs text-slate-400">Registro cronológico de servicios y visitas del cliente</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalHistorialCliente')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div id="historialContenido" class="mt-5 space-y-3 min-h-[160px]">
            <div class="py-12 text-center text-slate-400">
                <i data-lucide="loader" class="w-6 h-6 animate-spin mx-auto text-amber-500 mb-2"></i>
                <p class="text-xs font-medium">Cargando historial de citas...</p>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end mt-4">
            <button type="button" onclick="closeModal('modalHistorialCliente')" class="px-5 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer">
                Cerrar
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function abrirModalEditarCliente(cliente) {
        const form = document.getElementById('formEditarCliente');
        form.action = `/administrador/clientes/${cliente.id_usuario}`;
        document.getElementById('tituloEditarCliente').innerText = `Editar Cliente: ${cliente.nombre}`;
        
        document.getElementById('edit_cliente_nombre').value = cliente.nombre || '';
        document.getElementById('edit_cliente_email').value = cliente.email || '';
        document.getElementById('edit_cliente_telefono').value = cliente.telefono || '';
        document.getElementById('edit_cliente_identificacion').value = cliente.numero_identificacion || '';
        document.getElementById('edit_cliente_estado').value = (cliente.estado || 'ACTIVO').toUpperCase();

        openModal('modalEditarCliente');
    }

    async function verHistorialCliente(id, nombre) {
        document.getElementById('historialClienteNombre').innerText = `Historial: ${nombre}`;
        const contenedor = document.getElementById('historialContenido');
        contenedor.innerHTML = '<div class="py-12 text-center text-slate-400"><i data-lucide="loader" class="w-6 h-6 animate-spin mx-auto text-amber-500 mb-2"></i><p class="text-xs font-medium">Cargando historial de citas...</p></div>';
        openModal('modalHistorialCliente');

        try {
            const resp = await fetch(`/administrador/clientes/${id}/historial`);
            const data = await resp.json();

            if (!data.citas || data.citas.length === 0) {
                contenedor.innerHTML = `
                    <div class="py-10 text-center text-slate-400 bg-slate-50 rounded-2xl border border-slate-200/70 p-6">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center mx-auto mb-2">
                            <i data-lucide="calendar-x" class="w-6 h-6"></i>
                        </div>
                        <h5 class="text-sm font-bold text-slate-800 font-serif">Sin citas registradas</h5>
                        <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Este cliente aún no ha agendado ni completado citas en el sistema.</p>
                    </div>
                `;
                if (window.lucide) lucide.createIcons();
                return;
            }

            let html = '<div class="space-y-2.5">';
            data.citas.forEach(cita => {
                const estadoClass = cita.estado === 'COMPLETADA' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' :
                                (cita.estado === 'CANCELADA' ? 'bg-rose-50 text-rose-800 border-rose-200' :
                                (cita.estado === 'ACEPTADA' ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-slate-100 text-slate-700 border-slate-200'));
                
                const precio = cita.servicio && cita.servicio.precio ? '$' + Number(cita.servicio.precio).toLocaleString('es-CO') : '';

                html += `
                    <div class="p-3.5 bg-slate-50/80 hover:bg-white rounded-2xl border border-slate-200/80 shadow-2xs transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-700 border border-amber-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="scissors" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-slate-900 font-serif text-sm">${cita.servicio ? cita.servicio.nombre : 'Servicio Especial'}</h5>
                                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1.5 flex-wrap">
                                    <span class="font-medium text-slate-700">Barbero: <b>${cita.barbero ? cita.barbero.nombre : 'Por asignar'}</b></span>
                                    <span class="text-slate-300">•</span>
                                    <span class="font-arial font-semibold text-slate-600">${cita.fecha} a las ${cita.hora}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 self-end sm:self-center shrink-0">
                            ${precio ? `<span class="font-arial font-extrabold text-sm text-slate-900">${precio}</span>` : ''}
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border shadow-2xs ${estadoClass}">${cita.estado}</span>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            contenedor.innerHTML = html;
            if (window.lucide) lucide.createIcons();
        } catch (err) {
            contenedor.innerHTML = '<div class="py-6 text-center text-rose-500 text-xs font-semibold">No se pudo cargar el historial de citas en este momento.</div>';
        }
    }
</script>
@endpush
