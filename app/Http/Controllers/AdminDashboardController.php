<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Reprogramacion;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Muestra el panel principal de administración con datos 100% dinámicos.
     */
    public function index(Request $request)
    {
        $fecha = $request->input('fecha', Carbon::now()->toDateString());

        // 1. Citas del día seleccionado con relaciones eager loaded
        $citas = Cita::with(['cliente', 'barbero', 'servicio'])
            ->whereDate('fecha', $fecha)
            ->orderBy('hora')
            ->get();

        // 2. Turnos activos en sala de espera (hoy)
        $turnos = Turno::with(['cliente', 'cita.barbero', 'cita.servicio'])
            ->whereDate('fecha', $fecha)
            ->whereIn('estado', ['EN_ESPERA', 'EN_ATENCION'])
            ->orderBy('posicion')
            ->get();

        // 3. Solicitudes de reprogramación pendientes
        $reprogramaciones = Reprogramacion::with(['cita.cliente', 'cita.barbero', 'cita.servicio'])
            ->where('estado', 'PENDIENTE')
            ->latest()
            ->take(5)
            ->get();

        // 4. Métricas / KPIs calculados en tiempo real
        $totalCitasHoy = $citas->count();
        $citasAceptadas = $citas->where('estado', 'ACEPTADA')->count();
        $citasPendientes = $citas->where('estado', 'PENDIENTE')->count();
        $citasCompletadas = $citas->where('estado', 'COMPLETADA')->count();
        $citasCanceladas = $citas->where('estado', 'CANCELADA')->count();

        $turnosEnSalaCount = $turnos->count();
        $turnosEnAtencionCount = $turnos->where('estado', 'EN_ATENCION')->count();
        $turnosEnEsperaCount = $turnos->where('estado', 'EN_ESPERA')->count();

        // Ingresos proyectados (citas aceptadas o completadas)
        $ingresosEstimados = $citas
            ->whereIn('estado', ['ACEPTADA', 'COMPLETADA'])
            ->sum(function ($cita) {
                return $cita->servicio->precio ?? 0;
            });

        // Barberos activos en el sistema
        $barberosActivosCount = Usuario::where('id_rol', Usuario::ROL_BARBERO)
            ->activos()
            ->count();

        return view('administrador.dashboard1', compact(
            'fecha',
            'citas',
            'turnos',
            'reprogramaciones',
            'totalCitasHoy',
            'citasAceptadas',
            'citasPendientes',
            'citasCompletadas',
            'citasCanceladas',
            'turnosEnSalaCount',
            'turnosEnAtencionCount',
            'turnosEnEsperaCount',
            'ingresosEstimados',
            'barberosActivosCount'
        ));
    }

    /**
     * Aprueba o rechaza una solicitud de reprogramación.
     */
    public function gestionarReprogramacion(Request $request, Reprogramacion $reprogramacion)
    {
        $validated = $request->validate([
            'accion' => ['required', 'in:aprobar,rechazar'],
        ]);

        if ($validated['accion'] === 'aprobar') {
            $reprogramacion->estado = 'CONFIRMADA';
            $reprogramacion->save();

            // Actualizar la cita original
            $cita = $reprogramacion->cita;
            if ($cita) {
                $cita->fecha = $reprogramacion->nueva_fecha;
                $cita->hora = $reprogramacion->nueva_hora;
                $cita->estado = 'ACEPTADA';
                $cita->save();
            }

            return back()->with('Reprogramación aprobada. La cita se actualizó a la nueva fecha y hora.');
        } else {
            $reprogramacion->estado = 'CANCELADA';
            $reprogramacion->save();

            return back()->with('info', 'La solicitud de reprogramación ha sido rechazada.');
        }
    }
}
