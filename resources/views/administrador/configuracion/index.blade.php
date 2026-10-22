@extends('layouts.app')

@section('title', 'Configuración del Negocio')
@section('breadcrumb', 'Configuración')

@section('content')
    <div class="space-y-6 max-w-5xl mx-auto">

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                    Configuración del Sistema
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Parámetros operativos de la barbería, horarios de apertura, duración de slots y reglas de cancelación.
                </p>
            </div>

            @if($config->fecha_actualizacion)
                <div class="text-xs text-slate-400 bg-white border border-slate-200/80 rounded-xl px-3 py-2 shadow-2xs flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-amber-500"></i>
                    <span>Último ajuste: <b>{{ \Carbon\Carbon::parse($config->fecha_actualizacion)->format('d/m/Y H:i') }}</b> por <b>{{ $config->administrador->nombre ?? 'Admin' }}</b></span>
                </div>
            @endif
        </div>

        <!-- Formulario de Configuración -->
        <form method="POST" action="{{ route('admin.configuracion.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Identidad de la Barbería -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-600">
                        <i data-lucide="store" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Identidad del Establecimiento</h3>
                        <p class="text-xs text-slate-400">Datos comerciales visibles en reservas y comprobantes.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nombre Comercial del Negocio</label>
                        <input type="text" 
                            name="nombre_negocio" 
                            value="{{ old('nombre_negocio', $config->nombre_negocio) }}" 
                            required 
                            class="w-full p-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Estado Operativo del Local</label>
                        <div class="flex items-center gap-2.5 p-2 bg-emerald-50/60 border border-emerald-200/80 rounded-xl text-emerald-800 text-xs font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Estudio Abierto al Público y Reservas Online Activas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Jornada y Horarios de Atención -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-600">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Horarios de Atención y Agenda</h3>
                        <p class="text-xs text-slate-400">Determina el rango de citas que los clientes pueden agendar en línea.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Horario de Apertura</label>
                        <input type="time" 
                            name="horario_apertura" 
                            value="{{ old('horario_apertura', substr($config->horario_apertura, 0, 5)) }}" 
                            required 
                            class="w-full p-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 font-mono">
                        <p class="text-[11px] text-slate-400 mt-1">Hora de inicio de turnos</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Horario de Cierre</label>
                        <input type="time" 
                            name="horario_cierre" 
                            value="{{ old('horario_cierre', substr($config->horario_cierre, 0, 5)) }}" 
                            required 
                            class="w-full p-2.5 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 font-mono">
                        <p class="text-[11px] text-slate-400 mt-1">Hora límite para el último servicio</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Duración Estándar de Cita</label>
                        <div class="relative">
                            <input type="number" 
                                min="15" 
                                max="180" 
                                step="5" 
                                name="duracion_cita_min" 
                                value="{{ old('duracion_cita_min', $config->duracion_cita_min) }}" 
                                required 
                                class="w-full p-2.5 pr-14 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 font-medium">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-xs text-slate-400 font-semibold">minutos</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Bloque horario de base en calendario</p>
                    </div>
                </div>
            </div>

            <!-- 3. Políticas de Cancelación y Notificaciones -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-600">
                        <i data-lucide="shield-alert" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Políticas de Cancelación, Reprogramación y Alertas</h3>
                        <p class="text-xs text-slate-400">Reglas estrictas para mitigar ausencias (No-Shows) y proteger los turnos de los barberos.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tiempo Límite Cancelación</label>
                        <div class="relative">
                            <input type="number" 
                                min="0" 
                                max="1440" 
                                step="5" 
                                name="tiempo_cancelacion_min" 
                                value="{{ old('tiempo_cancelacion_min', $config->tiempo_cancelacion_min) }}" 
                                required 
                                class="w-full p-2.5 pr-14 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 font-medium">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-xs text-slate-400 font-semibold">min</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Antelación mínima requerida al cliente</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tiempo Límite Reprogramación *</label>
                        <div class="relative">
                            <input type="number" 
                                min="0" 
                                max="1440" 
                                step="5" 
                                name="tiempo_reprogramacion_min" 
                                value="{{ old('tiempo_reprogramacion_min', $config->tiempo_reprogramacion_min) }}" 
                                required 
                                class="w-full p-2.5 pr-14 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 font-medium">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-xs text-slate-400 font-semibold">min</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Plazo previo para mover de fecha/hora</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Recordatorio Previo Automático *</label>
                        <div class="relative">
                            <input type="number" 
                                min="0" 
                                max="1440" 
                                step="5" 
                                name="tiempo_notificacion_min" 
                                value="{{ old('tiempo_notificacion_min', $config->tiempo_notificacion_min) }}" 
                                required 
                                class="w-full p-2.5 pr-14 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-amber-400 font-medium">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-xs text-slate-400 font-semibold">min</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Anticipación de avisos al cliente</p>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-end gap-3 pt-4">
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 gold-gradient gold-gradient-hover shadow-lg shadow-amber-500/20 transition-all cursor-pointer">
                    <span>Guardar Parámetros de Configuración</span>
                </button>
            </div>
        </form>
    </div>
@endsection
