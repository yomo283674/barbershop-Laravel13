@extends('layouts.app')

@section('title', 'Mis Citas & Historial')
@section('breadcrumb', 'Cliente / Mis Citas')

@section('content')
<div class="space-y-6">

    <!-- Header Principal -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Mis Citas e Historial
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Consulta el estado de tus reservas, notas técnicas de tus estilos y gestiona tus citas.
            </p>
        </div>
    </div>

    <!-- Barra de Filtros y Búsqueda -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Tabs de Estados -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
            <a href="{{ route('cliente.citas.index') }}" 
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ !request('estado') || request('estado') === 'TODAS' ? 'bg-[#0b0c10] text-[#c5a059] shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Todas (<span class="font-arial font-bold">{{ $totalCitas }}</span>)
            </a>
            <a href="{{ route('cliente.citas.index', ['estado' => 'PENDIENTE']) }}" 
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ request('estado') === 'PENDIENTE' ? 'bg-[#c5a059] text-slate-950 shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                Pendientes (<span class="font-arial font-bold">{{ $totalPendientes }}</span>)
            </a>
            <a href="{{ route('cliente.citas.index', ['estado' => 'ACEPTADA']) }}" 
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ request('estado') === 'ACEPTADA' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Confirmadas (<span class="font-arial font-bold">{{ $totalAceptadas }}</span>)
            </a>
            <a href="{{ route('cliente.citas.index', ['estado' => 'REPROGRAMADA']) }}" 
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ request('estado') === 'REPROGRAMADA' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Reprogramadas (<span class="font-arial font-bold">{{ $totalReprogramadas }}</span>)
            </a>
            <a href="{{ route('cliente.citas.index', ['estado' => 'COMPLETADA']) }}" 
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ request('estado') === 'COMPLETADA' ? 'bg-slate-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Completadas (<span class="font-arial font-bold">{{ $totalCompletadas }}</span>)
            </a>
            <a href="{{ route('cliente.citas.index', ['estado' => 'CANCELADA']) }}" 
            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all {{ request('estado') === 'CANCELADA' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Canceladas (<span class="font-arial font-bold">{{ $totalCanceladas }}</span>)
            </a>
        </div>

        <!-- Búsqueda y Fecha -->
        <form method="GET" action="{{ route('cliente.citas.index') }}" class="flex items-center gap-2 w-full md:w-auto">
            @if(request('estado'))
                <input type="hidden" name="estado" value="{{ request('estado') }}">
            @endif
            <input type="date" name="fecha" value="{{ request('fecha') }}" onchange="this.form.submit()"
                class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs text-slate-700 bg-slate-50 focus:bg-white outline-none">
            <div class="relative flex-1 md:w-48">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Barbero o servicio..."
                    class="w-full pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs text-slate-700 bg-slate-50 focus:bg-white outline-none">
                <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
            </div>
            @if(request('buscar') || request('fecha') || request('estado'))
                <a href="{{ route('cliente.citas.index') }}" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100" title="Limpiar filtros">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Listado de Citas -->
    <div class="space-y-3">
        @forelse($citas as $cita)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:border-amber-400/60 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <!-- Icono o Imagen del Barbero / Servicio -->
                    <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200/80 shrink-0 flex items-center justify-center">
                        @if($cita->barbero && $cita->barbero->foto_perfil)
                            <img src="{{ asset($cita->barbero->foto_perfil) }}" 
                                alt="{{ $cita->barbero->nombre }}" 
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="display: none;" class="w-full h-full gold-gradient items-center justify-center text-slate-950 font-bold">
                                <i data-lucide="scissors" class="w-6 h-6"></i>
                            </div>
                        @elseif($cita->servicio && $cita->servicio->imagen)
                            <img src="{{ asset($cita->servicio->imagen) }}" alt="{{ $cita->servicio->nombre }}" class="w-full h-full object-cover">
                        @elseif($cita->barbero && $cita->barbero->nombre)
                            <div class="w-full h-full bg-gradient-to-br from-slate-900 to-[#14151b] text-[#c5a059] flex items-center justify-center font-bold font-serif text-lg">
                                {{ strtoupper(substr($cita->barbero->nombre, 0, 1)) }}
                            </div>
                        @else
                            <div class="w-full h-full gold-gradient flex items-center justify-center text-slate-950 font-bold">
                                <i data-lucide="scissors" class="w-6 h-6"></i>
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="font-bold text-slate-900 text-base font-serif">
                                {{ $cita->servicio->nombre ?? 'Servicio' }}
                            </h3>
                            <span class="text-xs font-extrabold font-arial text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200/50">
                                ${{ number_format($cita->servicio->precio ?? 0, 0) }} COP
                            </span>
                            <span class="text-[11px] text-slate-400 font-medium flex items-center gap-1 font-arial">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                {{ $cita->servicio->duracion_min ?? 45 }} min
                            </span>
                        </div>

                        <div class="mt-1.5 text-xs text-slate-500 space-y-1">
                            <p class="flex flex-wrap items-center gap-2">
                                <span class="font-medium text-slate-700 flex items-center gap-1">
                                    <i data-lucide="user" class="w-3.5 h-3.5 text-amber-600"></i>
                                    Barbero: <strong>{{ $cita->barbero->nombre ?? 'Por asignar' }}</strong>
                                </span>
                                <span>•</span>
                                <span class="font-medium text-slate-700 flex items-center gap-1 font-arial">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                    {{ \Carbon\Carbon::parse($cita->fecha)->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                                </span>
                                <span>•</span>
                                <span class="font-bold font-arial text-slate-900 flex items-center gap-1">
                                    <i data-lucide="clock-4" class="w-3.5 h-3.5 text-amber-600"></i>
                                    {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                                </span>
                            </p>

                            @if($cita->observacion)
                                <p class="bg-slate-50 p-2 rounded-xl border border-slate-200/60 text-slate-600 text-xs mt-2">
                                    <span class="font-bold text-slate-700">Nota técnica / Instrucción:</span> {{ $cita->observacion }}
                                </p>
                            @endif

                            @if($cita->motivo_cancelacion)
                                <p class="bg-rose-50 p-2 rounded-xl border border-rose-200/60 text-rose-700 text-xs mt-2 flex items-center gap-1.5">
                                    <i data-lucide="alert-octagon" class="w-3.5 h-3.5 text-rose-500 shrink-0"></i>
                                    <span><strong>Motivo de cancelación:</strong> {{ $cita->motivo_cancelacion }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Estado y Acciones -->
                <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-2.5 shrink-0 pt-3 md:pt-0 border-t md:border-t-0 border-slate-100">
                    <!-- Badges de Estado -->
                    @if($cita->estado === 'ACEPTADA')
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-100/90 px-3 py-1 rounded-full border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Confirmada
                        </span>
                    @elseif($cita->estado === 'PENDIENTE')
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-800 bg-amber-100/90 px-3 py-1 rounded-full border border-amber-200 animate-pulse">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Pendiente
                        </span>
                    @elseif($cita->estado === 'COMPLETADA')
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                            <i data-lucide="check" class="w-3 h-3 text-slate-500"></i>
                            Completada
                        </span>
                    @elseif($cita->estado === 'REPROGRAMADA')
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-800 bg-blue-100/90 px-3 py-1 rounded-full border border-blue-200">
                            <i data-lucide="calendar-sync" class="w-3 h-3 text-blue-600"></i>
                            Reprogramada
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-800 bg-rose-100/90 px-3 py-1 rounded-full border border-rose-200">
                            Cancelada
                        </span>
                    @endif

                    <!-- Botón Cancelar si está activa -->
                    @if(in_array($cita->estado, ['PENDIENTE', 'ACEPTADA', 'REPROGRAMADA']))
                        <button type="button" 
                                onclick="confirmarCancelacionCita(event, this.closest('div').querySelector('.form-cancelar-cita'))"
                                class="text-xs font-semibold text-rose-600 hover:text-rose-800 hover:bg-rose-50 px-3 py-1.5 rounded-xl border border-rose-200/80 transition-colors cursor-pointer flex items-center gap-1">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            <span>Cancelar Cita</span>
                        </button>
                        <form action="{{ route('cliente.citas.cancelar', $cita->id_cita) }}" method="POST" class="form-cancelar-cita hidden">
                            @csrf
                            @method('PATCH')
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="calendar-x" class="w-7 h-7"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">No se encontraron citas</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">No hay registros con los filtros seleccionados. Agenda tu próxima cita en unos clics.</p>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-6 flex justify-center">
        {{ $citas->links() }}
    </div>

</div>

@push('scripts')
<script>
    function confirmarCancelacionCita(event, form) {
        event.preventDefault();
        Swal.fire({
            title: "¿Deseas cancelar esta cita?",
            text: "Ten presente que las cancelaciones están sujetas al tiempo mínimo de anticipación configurado.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e11d48",
            cancelButtonColor: "#64748b",
            confirmButtonText: "Sí, cancelar cita",
            cancelButtonText: "Conservar cita",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection
