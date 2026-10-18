<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BarberoDashboardController extends Controller
{
    /**
     * Muestra la estación de trabajo operativa del Barbero autenticado.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $fecha = $request->input('fecha', Carbon::now()->toDateString());

        // 1. Citas del día asignadas exclusivamente a este barbero
        $citasHoy = Cita::with(['cliente', 'servicio', 'turno'])
            ->where('id_barbero', $user->id_usuario)
            ->whereDate('fecha', $fecha)
            ->orderBy('hora', 'asc')
            ->get();

        // 2. Turnos de hoy en sala vinculados a este barbero
        $turnosHoy = Turno::with(['cliente', 'cita.servicio'])
            ->whereHas('cita', function ($q) use ($user) {
                $q->where('id_barbero', $user->id_usuario);
            })
            ->whereDate('fecha', $fecha)
            ->orderBy('posicion', 'asc')
            ->get();

        // 3. Cliente actualmente en silla (EN_ATENCION)
        $turnoEnSilla = $turnosHoy->where('estado', 'EN_ATENCION')->first();

        // 4. Siguiente cliente en fila de espera
        $siguienteEnEspera = $turnosHoy->where('estado', 'EN_ESPERA')->first();

        // 5. KPIs Personales
        $totalCitasHoy = $citasHoy->count();
        $citasPendientesCount = $citasHoy->where('estado', 'PENDIENTE')->count();
        $citasCompletadasCount = $citasHoy->where('estado', 'COMPLETADA')->count();
        $turnosEnEsperaCount = $turnosHoy->where('estado', 'EN_ESPERA')->count();

        // Comisión generada hoy (40% sobre servicios COMPLETADOS)
        $comisionEstimadaHoy = $citasHoy->where('estado', 'COMPLETADA')->sum(function ($cita) {
            return ($cita->servicio->precio ?? 0) * 0.40;
        });

        // Servicios propios activos en portafolio
        $serviciosPropiosCount = Servicio::where('id_barbero', $user->id_usuario)
            ->where('estado', 'ACTIVO')
            ->count();

        return view('barbero.dashboard2', compact(
            'user',
            'fecha',
            'citasHoy',
            'turnosHoy',
            'turnoEnSilla',
            'siguienteEnEspera',
            'totalCitasHoy',
            'citasPendientesCount',
            'citasCompletadasCount',
            'turnosEnEsperaCount',
            'comisionEstimadaHoy',
            'serviciosPropiosCount'
        ));
    }
}
