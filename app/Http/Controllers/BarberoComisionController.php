<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BarberoComisionController extends Controller
{
    /**
     * Muestra el resumen financiero, liquidación y comisiones devengadas por el Barbero.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth()->toDateString());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->toDateString());

        // Citas completadas en el rango de fechas
        $citasQuery = Cita::with(['cliente', 'servicio'])
            ->where('id_barbero', $user->id_usuario)
            ->where('estado', 'COMPLETADA')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

        $citas = (clone $citasQuery)->orderBy('fecha', 'desc')->orderBy('hora', 'desc')->paginate(15)->withQueryString();

        // Totales calculados en el período mediante agregados en base de datos
        $totalServiciosPeriodo = (clone $citasQuery)->count();
        $ingresosBrutosPeriodo = (float) Cita::where('citas.id_barbero', $user->id_usuario)
            ->where('citas.estado', 'COMPLETADA')
            ->whereBetween('citas.fecha', [$fechaInicio, $fechaFin])
            ->join('servicios', 'citas.id_servicio', '=', 'servicios.id_servicio')
            ->sum('servicios.precio');
        $comisionPeriodo = $ingresosBrutosPeriodo * 0.40;

        // Comisiones de Hoy
        $hoy = Carbon::today()->toDateString();
        $serviciosHoy = Cita::where('id_barbero', $user->id_usuario)
            ->where('estado', 'COMPLETADA')
            ->whereDate('fecha', $hoy)
            ->count();
        $ingresosHoy = (float) Cita::where('citas.id_barbero', $user->id_usuario)
            ->where('citas.estado', 'COMPLETADA')
            ->whereDate('citas.fecha', $hoy)
            ->join('servicios', 'citas.id_servicio', '=', 'servicios.id_servicio')
            ->sum('servicios.precio');
        $comisionHoy = $ingresosHoy * 0.40;

        // Comisiones de la Semana Actual
        $inicioSemana = Carbon::now()->startOfWeek()->toDateString();
        $ingresosSemana = (float) Cita::where('citas.id_barbero', $user->id_usuario)
            ->where('citas.estado', 'COMPLETADA')
            ->whereBetween('citas.fecha', [$inicioSemana, $hoy])
            ->join('servicios', 'citas.id_servicio', '=', 'servicios.id_servicio')
            ->sum('servicios.precio');
        $comisionSemana = $ingresosSemana * 0.40;

        // Comisiones del Mes Actual
        $inicioMes = Carbon::now()->startOfMonth()->toDateString();
        $ingresosMes = (float) Cita::where('citas.id_barbero', $user->id_usuario)
            ->where('citas.estado', 'COMPLETADA')
            ->whereBetween('citas.fecha', [$inicioMes, $hoy])
            ->join('servicios', 'citas.id_servicio', '=', 'servicios.id_servicio')
            ->sum('servicios.precio');
        $comisionMes = $ingresosMes * 0.40;

        return view('barbero.comisiones.index', compact(
            'citas',
            'fechaInicio',
            'fechaFin',
            'totalServiciosPeriodo',
            'ingresosBrutosPeriodo',
            'comisionPeriodo',
            'comisionHoy',
            'serviciosHoy',
            'comisionSemana',
            'comisionMes'
        ));
    }
}
