@extends('layouts.app')

@section('title', 'Equipo de Barberos')
@section('breadcrumb', 'Barberos')



@section('content')
<div class="space-y-6">

    <!-- Header Section de Lujo -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 font-serif">
                    Equipo de Barberos
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Control de profesionales, especialidades, turnos operativos y rendimiento por puesto de trabajo.
            </p>
        </div>

        <button type="button" onclick="openModal('modalNuevoBarbero')" 
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md hover:shadow-lg transition-all cursor-pointer shrink-0">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Registrar Barbero</span>
        </button>
    </div>

    <!-- 4 Métricas de Barberos con Estilo Premium -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Equipo -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Equipo</span>
                <span class="p-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-slate-700 group-hover:scale-110 transition-transform">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight font-arial">{{ $totalBarberos }}</h3>
                <p class="text-xs text-slate-400 mt-1">Barberos registrados</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-800"></div>
        </div>

        <!-- Activos Hoy -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Activos Hoy</span>
                <span class="p-2.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="scissors" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight font-arial">{{ $barberosActivos }}</h3>
                <p class="text-xs text-slate-400 mt-1">En turno operativo hoy</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
        </div>

        <!-- Inactivos / Permiso -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Inactivos / Permiso</span>
                <span class="p-2.5 rounded-2xl bg-slate-100 border border-slate-200 text-slate-500 group-hover:scale-110 transition-transform">
                    <i data-lucide="user-x" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-slate-700 tracking-tight font-arial">{{ $barberosInactivos }}</h3>
                <p class="text-xs text-slate-400 mt-1">Fuera de servicio / permiso</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-400"></div>
        </div>

        <!-- Citas del Día -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Citas del Día</span>
                <span class="p-2.5 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="calendar-check" class="w-5 h-5"></i>
                </span>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-extrabold text-amber-600 tracking-tight font-arial">{{ $totalCitasHoy }}</h3>
                <p class="text-xs text-slate-400 mt-1">Asignadas al equipo hoy</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-amber-500"></div>
        </div>
    </div>

    <!-- Barra de Búsqueda y Filtros Optimizada -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('admin.barberos.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
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
                    placeholder="Buscar por nombre, especialidad, email o teléfono..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-medium outline-none focus:ring-2 focus:ring-amber-400/30 transition-all">
            </div>

            <div class="sm:col-span-3">
                <select name="estado" class="w-full py-2.5 px-3 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200/80 rounded-xl text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-amber-400/30 transition-all cursor-pointer">
                    <option value="TODOS">Todos los estados</option>
                    <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activos</option>
                    <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>

            <div class="sm:col-span-1 flex items-center gap-1.5">
                <button type="submit" class="flex-1 py-2.5 px-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-2xs transition-all flex items-center justify-center gap-1 cursor-pointer" title="Aplicar filtros">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                </button>
                @if(request()->hasAny(['buscar', 'estado']))
                    <a href="{{ route('admin.barberos.index') }}" class="py-2.5 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-all shadow-2xs flex items-center justify-center" title="Limpiar filtros">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Grid de Tarjetas de Barberos (Estilo Luxury VIP) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($barberos as $barbero)
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 hover:border-amber-400/50 shadow-xs hover:shadow-md transition-all flex flex-col justify-between relative overflow-hidden group">
                
                <!-- Glow ambiental sutil -->
                <div class="absolute -top-12 -right-12 w-36 h-36 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-all pointer-events-none"></div>

                <div>
                    <!-- Encabezado de la Tarjeta: Avatar + Info + Estado -->
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <!-- Avatar con Anillo Dorado -->
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#182032] via-[#0f1422] to-[#0a0d17] text-amber-400 font-extrabold font-serif text-lg flex items-center justify-center shrink-0 border border-amber-500/30 shadow-2xs group-hover:scale-105 transition-transform overflow-hidden">
                                @if($barbero->foto_perfil)
                                    <img src="{{ asset($barbero->foto_perfil) }}" 
                                        alt="{{ $barbero->nombre }}" 
                                        class="w-full h-full object-cover"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <span style="display: none;" class="w-full h-full items-center justify-center">
                                        {{ strtoupper(substr($barbero->nombre, 0, 2)) }}
                                    </span>
                                @else
                                    {{ strtoupper(substr($barbero->nombre, 0, 2)) }}
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-base font-bold text-slate-900 group-hover:text-amber-800 transition-colors font-serif truncate">
                                    {{ $barbero->nombre }}
                                </h3>
                                <p class="text-xs font-semibold text-slate-400 flex items-center gap-1 mt-0.5">
                                    <i data-lucide="award" class="w-3.5 h-3.5 text-amber-500"></i>
                                    <span>{{ $barbero->cargo ?? 'Master Barber' }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Estado Badge -->
                        <div class="shrink-0">
                            @if($barbero->estado === 'activo')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/90 shadow-2xs">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Activo</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span>Inactivo</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Especialidad Badge -->
                    <div class="mb-4">
                        <span class="inline-flex items-center gap-1.5 text-xs text-amber-900 bg-amber-50/80 border border-amber-200/70 px-3 py-1 rounded-xl font-semibold">
                            <i data-lucide="scissors" class="w-3.5 h-3.5 text-amber-600"></i>
                            <span>{{ $barbero->especialidad }}</span>
                        </span>
                    </div>

                    <!-- Datos de Contacto en Contenedor Suave -->
                    <div class="bg-slate-50/80 p-3.5 rounded-2xl border border-slate-100 text-xs space-y-2 text-slate-600">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 flex items-center gap-1.5">
                                <i data-lucide="mail" class="w-3.5 h-3.5 text-amber-600"></i> Email:
                            </span>
                            <span class="font-semibold text-slate-800 truncate max-w-[170px]" title="{{ $barbero->email }}">{{ $barbero->email }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 flex items-center gap-1.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-amber-600"></i> Teléfono:
                            </span>
                            <span class="font-semibold text-slate-800 font-arial">{{ $barbero->telefono ?? 'No registrado' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 flex items-center gap-1.5">
                                <i data-lucide="badge" class="w-3.5 h-3.5 text-amber-600"></i> Cédula:
                            </span>
                            <span class="font-semibold text-slate-800 font-arial">{{ $barbero->numero_identificacion ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Mini Métricas de Rendimiento del Barbero -->
                    <div class="grid grid-cols-2 gap-2.5 mt-3.5 text-center">
                        <div class="bg-white p-3 rounded-2xl border border-slate-200/70 shadow-2xs hover:border-amber-300 transition-colors">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Citas Hoy</span>
                            <span class="text-xl font-extrabold font-arial text-slate-900">{{ $barbero->citas_hoy_count }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-2xl border border-slate-200/70 shadow-2xs hover:border-amber-300 transition-colors">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Servicios</span>
                            <span class="text-xl font-extrabold font-arial text-slate-900">{{ $barbero->servicios_count }}</span>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción de la Tarjeta -->
                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                    <!-- Toggle Activo / Inactivo -->
                    <form method="POST" action="{{ route('admin.barberos.estado', $barbero) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 {{ $barbero->estado === 'activo' ? 'text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200/70' : 'text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/70' }}"
                                title="Cambiar disponibilidad de turno">
                            <i data-lucide="{{ $barbero->estado === 'activo' ? 'pause-circle' : 'play-circle' }}" class="w-3.5 h-3.5"></i>
                            <span>{{ $barbero->estado === 'activo' ? 'Pausar Turno' : 'Activar Barbero' }}</span>
                        </button>
                    </form>

                    <!-- Editar Barbero -->
                    <button type="button" 
                            onclick="abrirModalEditarBarbero({{ json_encode($barbero) }})" 
                            class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-2xs cursor-pointer">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span>Editar</span>
                    </button>
                </div>

            </div>
        @empty
            <!-- Empty State de Barberos -->
            <div class="col-span-full py-16 px-4 text-center">
                <div class="max-w-md mx-auto flex flex-col items-center bg-gradient-to-b from-slate-50/70 to-white border border-slate-200/80 rounded-3xl p-8 sm:p-10 shadow-xs relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-36 h-36 bg-amber-500/5 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="relative mb-4">
                        <div class="w-16 h-16 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shadow-inner">
                            <i data-lucide="scissors" class="w-8 h-8 text-amber-600"></i>
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-white border border-slate-200 text-amber-600 flex items-center justify-center shadow-xs">
                            <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                        </span>
                    </div>

                    <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight font-serif">
                        No se encontraron barberos
                    </h3>
                    <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                        @if(request()->hasAny(['buscar', 'estado']))
                            No hay barberos que coincidan con los criterios de búsqueda aplicados.
                        @else
                            Aún no hay profesionales registrados en el equipo. Comienza registrando al primer barbero.
                        @endif
                    </p>

                    <div class="mt-6 flex flex-wrap items-center justify-center gap-2.5">
                        @if(request()->hasAny(['buscar', 'estado']))
                            <a href="{{ route('admin.barberos.index') }}" 
                            class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors shadow-2xs flex items-center gap-1.5">
                                <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                                <span>Limpiar Filtros</span>
                            </a>
                        @endif
                        <button type="button" onclick="openModal('modalNuevoBarbero')" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-md hover:shadow-lg transition-all cursor-pointer">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            <span>Registrar Barbero</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Barra de Paginación Premium para Barberos -->
    <div class="px-5 py-3.5 sm:px-6 rounded-3xl border border-slate-200/80 bg-white shadow-xs flex flex-col md:flex-row items-center justify-between gap-3.5">
        <!-- Indicador de Resultados Elegante -->
        <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <span>Mostrando</span>
            <span class="font-bold text-slate-900 font-arial">{{ $barberos->firstItem() ?? 0 }}–{{ $barberos->lastItem() ?? 0 }}</span>
            <span class="text-slate-400">de</span>
            <span class="font-bold text-slate-900 font-arial">{{ $barberos->total() }}</span>
            <span>barberos en equipo</span>
        </div>

        <!-- Toolbar Derecha: Selector de Filas + Navegación -->
        <div class="flex items-center gap-3 flex-wrap justify-center md:justify-end">
            <!-- Selector Cantidad por Página -->
            <div class="inline-flex items-center gap-1.5">
                <span class="text-xs text-slate-400 font-semibold hidden sm:inline">Mostrar:</span>
                <div class="inline-flex items-center bg-slate-100/90 p-1 rounded-2xl border border-slate-200/70">
                    @foreach([3, 6, 9, 12] as $cant)
                        <a href="{{ request()->fullUrlWithQuery(['per_page' => $cant, 'page' => 1]) }}"
                        class="px-2.5 py-1 rounded-xl text-xs font-arial transition-all {{ request('per_page', 3) == $cant ? 'bg-white text-slate-950 font-bold shadow-xs border border-slate-200/80' : 'text-slate-500 hover:text-slate-900 hover:bg-white/60 font-semibold' }}">
                            {{ $cant }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if($barberos->hasPages())
                <span class="h-4 w-px bg-slate-200 hidden sm:block"></span>

                {{-- Controles de Paginación --}}
                <div>
                    {{ $barberos->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>

</div>

<!--MODALES-->

<!-- 1. Modal Registrar Barbero -->
<div id="modalNuevoBarbero" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="user-plus" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif">Registrar Nuevo Barbero</h3>
                    <p class="text-xs text-slate-400">Añadir profesional al catálogo del equipo</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalNuevoBarbero')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.barberos.store') }}" class="mt-5 space-y-4">
            @csrf

            <!-- Nombre -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Completo</label>
                <input type="text" name="nombre" required placeholder="Ej: Mateo Silva" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico</label>
                <input type="email" name="email" required placeholder="mateo@barbershop.com" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <!-- Teléfono y Cédula -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teléfono</label>
                    <input type="text" name="telefono" placeholder="310 987 6543" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cédula o Documento</label>
                    <input type="text" name="numero_identificacion" placeholder="1020304050" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
            </div>

            <!-- Especialidad -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Especialidad Principal</label>
                <input type="text" name="especialidad" required placeholder="Ej: Fade Moderno, Afeitado Tradicional, Diseños" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <!-- Cargo -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cargo</label>
                <input type="text" name="cargo" placeholder="Ej: Master Barber, Barbero Senior" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <!-- Contraseña de Acceso -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Contraseña de Acceso</label>
                <input type="password" name="password" placeholder="Mínimo 6 caracteres" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalNuevoBarbero')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-slate-950 gold-gradient gold-gradient-hover rounded-xl shadow-md transition-all cursor-pointer">
                    Guardar Barbero
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Editar Barbero -->
<div id="modalEditarBarbero" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-200 animate-scale-up max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 flex items-center justify-center shrink-0">
                    <i data-lucide="edit-3" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif" id="tituloEditarBarbero">Editar Barbero</h3>
                    <p class="text-xs text-slate-400">Actualizar datos profesionales del barbero</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalEditarBarbero')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="formEditarBarbero" method="POST" action="" class="mt-5 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Completo</label>
                <input type="text" name="nombre" id="edit_barbero_nombre" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Correo Electrónico</label>
                <input type="email" name="email" id="edit_barbero_email" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teléfono</label>
                    <input type="text" name="telefono" id="edit_barbero_telefono" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cédula</label>
                    <input type="text" name="numero_identificacion" id="edit_barbero_identificacion" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Especialidad</label>
                <input type="text" name="especialidad" id="edit_barbero_especialidad" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cargo</label>
                    <input type="text" name="cargo" id="edit_barbero_cargo" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estado</label>
                    <select name="estado" id="edit_barbero_estado" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white outline-none focus:ring-2 focus:ring-amber-400 transition-all font-medium cursor-pointer">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="bloqueado">Bloqueado</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalEditarBarbero')" class="px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white rounded-xl shadow-md transition-all cursor-pointer">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function abrirModalEditarBarbero(barbero) {
        const form = document.getElementById('formEditarBarbero');
        form.action = `/administrador/barberos/${barbero.id_usuario}`;
        document.getElementById('tituloEditarBarbero').innerText = `Editar: ${barbero.nombre}`;
        
        document.getElementById('edit_barbero_nombre').value = barbero.nombre || '';
        document.getElementById('edit_barbero_email').value = barbero.email || '';
        document.getElementById('edit_barbero_telefono').value = barbero.telefono || '';
        document.getElementById('edit_barbero_identificacion').value = barbero.numero_identificacion || '';
        document.getElementById('edit_barbero_especialidad').value = barbero.especialidad || '';
        document.getElementById('edit_barbero_cargo').value = barbero.cargo || '';
        document.getElementById('edit_barbero_estado').value = barbero.estado || 'activo';

        openModal('modalEditarBarbero');
    }
</script>
@endpush
