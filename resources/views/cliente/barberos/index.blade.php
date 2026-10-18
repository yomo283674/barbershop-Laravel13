@extends('layouts.app')

@section('title', 'Nuestros Barberos & Estilos')
@section('breadcrumb', 'Cliente / Barberos')

@section('content')
<div class="space-y-6">

    <!-- Header Principal -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 font-serif">
                Equipo de Barberos y Estilos
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Conoce a nuestros maestros del corte tradicional y contemporáneo, explora sus especialidades y agenda directamente con tu favorito.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="openModal('modalNuevaReservaCliente')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-xs tracking-wide uppercase text-slate-950 gold-gradient gold-gradient-hover shadow-md shadow-amber-500/15 transition-all cursor-pointer">
                <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                <span>Agendar Cita</span>
            </button>
        </div>
    </div>

    <!-- Resumen del Equipo -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-700">
                <i data-lucide="award" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-900">Especialistas Certificados</h2>
                <p class="text-xs text-slate-500">Cada barbero cuenta con técnicas propias de degradado, toalla caliente y cuidado de barba.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold font-arial text-amber-700 bg-amber-50 px-3 py-1.5 rounded-xl border border-amber-200/60 flex items-center gap-1.5">
                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                <span>{{ method_exists($barberos, 'total') ? $barberos->total() : $barberos->count() }} profesionales activos</span>
            </span>
        </div>
    </div>

    <!-- Catálogo de Barberos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
        @forelse($barberos as $barbero)
            @include('cliente.partials.barbero_card', ['barbero' => $barbero, 'index' => $loop->index])
        @empty
            <div class="col-span-full bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-xs">
                <i data-lucide="users" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                <h3 class="text-base font-bold text-slate-900">No hay barberos disponibles en este momento</h3>
                <p class="text-xs text-slate-400 mt-1">El equipo se actualizará pronto con nuevos profesionales.</p>
            </div>
        @endforelse
    </div>

    @if(method_exists($barberos, 'links') && $barberos->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $barberos->links() }}
        </div>
    @endif

</div>

<!-- Modal Reutilizable de Reserva Inteligente -->
@include('cliente.partials.modal_reserva')
@endsection
