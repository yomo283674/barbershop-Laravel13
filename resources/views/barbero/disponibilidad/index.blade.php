@extends('layouts.app')

@section('title', 'Mi Horario & Disponibilidad')
@section('breadcrumb', 'Barbero / Mi Horario')

@section('content')
<div class="space-y-6">

    <!-- 1. Header con Acciones Rápidas -->
    <div class="relative overflow-hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>

        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Mi Horario y Disponibilidad
            </h1>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl">
                Autogestiona tus descansos, pausas de almuerzo o habilitación de franjas especiales para evitar citas en momentos no disponibles.
            </p>
        </div>

        <div class="relative z-10 flex flex-wrap items-center gap-2.5">
            <!-- Botón Registrar Descanso -->
            <button onclick="abrirModalBloqueo()" 
                    class="px-5 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 font-bold text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-amber-500/20 transition-all shrink-0 cursor-pointer">
                <i data-lucide="clock-4" class="w-4 h-4"></i>
                <span>Registrar Descanso</span>
            </button>
        </div>
    </div>

    <!-- 2. KPIs de Disponibilidad (Estructura Arquitectónica 3-Tier de Lujo) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <!-- 1. Horario General del Estudio (Ámbar / Oro) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-amber-300/80 hover:shadow-lg hover:shadow-amber-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Horario General del Estudio</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="store" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Value Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        08:00 AM – 08:00 PM
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/80">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Fijado por administración
                </span>
                <span class="text-[11px] font-medium text-slate-400">Jornada comercial</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-400 group-hover:bg-amber-500 transition-colors"></div>
        </div>

        <!-- 2. Descansos Programados (Rosa / Coral) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-rose-300/80 hover:shadow-lg hover:shadow-rose-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-rose-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Descansos Programados</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-50 to-rose-100/70 border border-rose-200/80 text-rose-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="coffee" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $totalBloqueos }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $totalBloqueos > 0 ? 'bg-rose-50 text-rose-700 border border-rose-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $totalBloqueos > 0 ? 'bg-rose-500' : 'bg-slate-300' }}"></span>
                    {{ $totalBloqueos > 0 ? 'Franjas no laborables' : 'Sin descansos' }}
                </span>
                <span class="text-[11px] font-medium text-slate-400">Pausas activas</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-rose-400 group-hover:bg-rose-500 transition-colors"></div>
        </div>

        <!-- 3. Jornadas Especiales (Esmeralda) -->
        <div class="relative bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-300/80 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5 transition-all duration-300 group flex flex-col justify-between overflow-hidden">
            <!-- Destello ambiental sutil -->
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-emerald-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>

            <div>
                <!-- Tier 1: Header de Categoría & Icono Elevado -->
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">Jornadas Especiales</span>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100/70 border border-emerald-200/80 text-emerald-600 flex items-center justify-center shadow-2xs group-hover:scale-110 group-hover:rotate-2 transition-transform duration-300">
                        <i data-lucide="sparkles" class="w-5 h-5 stroke-[1.9]"></i>
                    </div>
                </div>

                <!-- Tier 2: Hero Numeral Principal -->
                <div class="mt-2.5 mb-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-sans tabular-nums leading-none">
                        {{ $totalJornadasEspeciales }}
                    </div>
                </div>
            </div>

            <!-- Tier 3: Repisa de Estado & Contexto -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $totalJornadasEspeciales > 0 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200/80' : 'bg-slate-50 text-slate-600 border border-slate-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $totalJornadasEspeciales > 0 ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                    {{ $totalJornadasEspeciales > 0 ? 'Habilitadas' : 'Horario regular' }}
                </span>
                <span class="text-[11px] font-medium text-slate-400">Días especiales</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-400 group-hover:bg-emerald-500 transition-colors"></div>
        </div>
    </div>

    <!-- 3. Tabla de Franjas Registradas -->
    <div class="relative bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <!-- Destello ambiental sutil -->
        <div class="absolute -right-12 -top-12 w-36 h-36 rounded-full bg-amber-500/5 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs shrink-0">
                    <i data-lucide="calendar-range" class="w-5 h-5 stroke-[1.9]"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight font-serif">Mis Franjas Horarias Registradas</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Historial de descansos y excepciones activas de los últimos 7 días y fechas futuras</p>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-700 shadow-2xs self-start sm:self-auto">
                <span class="w-2 h-2 rounded-full {{ $disponibilidades->total() > 0 ? 'bg-amber-500 animate-pulse' : 'bg-slate-300' }}"></span>
                <span class="tabular-nums font-bold text-slate-900">{{ $disponibilidades->total() }}</span>
                <span class="text-slate-400 font-medium">registros</span>
            </div>
        </div>

        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider font-sans">
                    <tr>
                        <th class="px-6 py-3.5 text-left">Fecha</th>
                        <th class="px-5 py-3.5 text-left">Franja Horaria</th>
                        <th class="px-5 py-3.5 text-left">Tipo de Franja</th>
                        <th class="px-5 py-3.5 text-left">Estado</th>
                        <th class="px-6 py-3.5 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($disponibilidades as $disp)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <!-- Fecha -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200/80 flex items-center justify-center text-slate-700 font-bold text-xs shrink-0">
                                        <i data-lucide="calendar" class="w-4 h-4 text-slate-500"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">
                                            {{ \Carbon\Carbon::parse($disp->fecha)->format('d/m/Y') }}
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-400 capitalize">
                                            {{ \Carbon\Carbon::parse($disp->fecha)->isoFormat('dddd, D [de] MMMM') }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Franja Horaria -->
                            <td class="px-5 py-4">
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 font-bold text-slate-800 text-xs shadow-2xs">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-500"></i>
                                    <span>{{ \Carbon\Carbon::parse($disp->hora_inicio)->format('h:i A') }} – {{ \Carbon\Carbon::parse($disp->hora_fin)->format('h:i A') }}</span>
                                </div>
                            </td>

                            <!-- Tipo de Franja -->
                            <td class="px-5 py-4">
                                @if(!$disp->disponible)
                                    <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold inline-flex items-center gap-1.5 shadow-2xs">
                                        <i data-lucide="coffee" class="w-3.5 h-3.5"></i>
                                        Pausa / Almuerzo / Descanso
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold inline-flex items-center gap-1.5 shadow-2xs">
                                        <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                                        Jornada Extra Habilitada
                                    </span>
                                @endif
                            </td>

                            <!-- Estado -->
                            <td class="px-5 py-4">
                                @if(\Carbon\Carbon::parse($disp->fecha)->isFuture() || \Carbon\Carbon::parse($disp->fecha)->isToday())
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Próxima / Vigente
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                        Pasada
                                    </span>
                                @endif
                            </td>

                            <!-- Acción -->
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('barbero.disponibilidad.destroy', $disp->id_disponibilidad) }}" method="POST" onsubmit="return confirm('¿Liberar esta franja de horario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-8 h-8 rounded-xl flex items-center justify-center text-rose-500 hover:text-white hover:bg-rose-500 border border-rose-200/60 hover:border-rose-500 transition-all shadow-2xs ml-auto cursor-pointer" 
                                            title="Eliminar franja">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 px-6 text-center">
                                <div class="max-w-md mx-auto flex flex-col items-center">
                                    <!-- Icono elevado con aura ambiental -->
                                    <div class="relative flex items-center justify-center mb-4">
                                        <div class="absolute w-16 h-16 rounded-2xl bg-amber-500/10 blur-xl pointer-events-none"></div>
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-xs leading-none relative z-10">
                                            <i data-lucide="calendar-clock" class="w-8 h-8 stroke-[1.75] block translate-y-[2px]"></i>
                                        </div>
                                    </div>

                                    <h4 class="text-base font-bold text-slate-900 font-serif tracking-tight">Sin descansos registrados</h4>
                                    <p class="text-xs text-slate-500 mt-1.5 max-w-sm leading-relaxed">
                                        No tienes bloqueos o pausas programadas. Tu disponibilidad actual coincide con el horario general del estudio.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($disponibilidades->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $disponibilidades->links() }}
            </div>
        @endif
    </div>

</div>

<!-- MODAL: REGISTRAR PAUSA / DESCANSO -->
<div id="modalBloqueo" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 transition-all">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-amber-500/10 blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex items-center justify-between pb-3.5 border-b border-slate-100">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200/80 text-amber-600 flex items-center justify-center shadow-2xs">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
                <h3 class="font-bold text-slate-900 font-serif text-lg">Registrar Franja de Horario</h3>
            </div>
            <button onclick="cerrarModalBloqueo()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('barbero.disponibilidad.store') }}" method="POST" class="relative z-10 mt-4 space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Fecha *</label>
                <input type="date" name="fecha" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                    class="w-full text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/70 p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:bg-white transition-all">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hora Inicio *</label>
                    <input type="time" name="hora_inicio" required value="13:00"
                        class="w-full text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/70 p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hora Fin *</label>
                    <input type="time" name="hora_fin" required value="14:00"
                        class="w-full text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/70 p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:bg-white transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipo de Registro *</label>
                <select name="disponible" required class="w-full text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/70 p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:bg-white transition-all">
                    <option value="0">Bloqueo por Descanso / Almuerzo / Pausa (No disponible)</option>
                    <option value="1">Jornada Especial Habilitada (Disponible)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Motivo (Opcional)</label>
                <input type="text" name="motivo" placeholder="Ej: Almuerzo, cita médica, descanso personal..."
                    class="w-full text-xs font-semibold rounded-xl border border-slate-200 bg-slate-50/70 p-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:bg-white transition-all">
            </div>

            <div class="flex justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="cerrarModalBloqueo()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl gold-gradient gold-gradient-hover text-slate-950 text-xs font-bold shadow-md shadow-amber-500/20 transition-all cursor-pointer flex items-center gap-1.5">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Guardar Franja</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function abrirModalBloqueo() {
        document.getElementById('modalBloqueo').classList.remove('hidden');
    }
    function cerrarModalBloqueo() {
        document.getElementById('modalBloqueo').classList.add('hidden');
    }
</script>
@endpush
@endsection
