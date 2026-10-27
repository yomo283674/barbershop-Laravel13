<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BarberoTurnoController extends Controller
{
    /**
     * Monitor de turnos en sala de espera asignados a la estación del barbero.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $fecha = $request->input('fecha', Carbon::now()->toDateString());
        $estado = $request->input('estado', 'TODOS');

        $query = Turno::with(['cliente', 'cita.servicio'])
            ->whereHas('cita', function ($q) use ($user) {
                $q->where('id_barbero', $user->id_usuario);
            })
            ->whereDate('fecha', $fecha);

        if ($estado !== 'TODOS') {
            $query->where('estado', $estado);
        }

        $turnos = $query->orderBy('posicion', 'asc')->get();

        // Conteos específicos de su puesto (evita consulta duplicada si estado es TODOS)
        if ($estado === 'TODOS') {
            $todosTurnosHoy = $turnos;
        } else {
            $todosTurnosHoy = Turno::whereHas('cita', function ($q) use ($user) {
                $q->where('id_barbero', $user->id_usuario);
            })
                ->whereDate('fecha', $fecha)
                ->get();
        }

        $totalTurnos = $todosTurnosHoy->count();
        $turnosEnEspera = $todosTurnosHoy->where('estado', 'EN_ESPERA')->count();
        $turnosEnAtencion = $todosTurnosHoy->where('estado', 'EN_ATENCION')->count();
        $turnosFinalizados = $todosTurnosHoy->where('estado', 'FINALIZADO')->count();

        $turnoActual = $todosTurnosHoy->where('estado', 'EN_ATENCION')->first();
        $siguienteTurno = $todosTurnosHoy->where('estado', 'EN_ESPERA')->sortBy('posicion')->first();

        return view('barbero.turnos.index', compact(
            'turnos',
            'estado',
            'totalTurnos',
            'turnosEnEspera',
            'turnosEnAtencion',
            'turnosFinalizados',
            'turnoActual',
            'siguienteTurno'
        ));
    }

    /**
     * Llama al cliente de la sala de espera para pasar a la silla de atención.
     */
    public function llamar(Turno $turno)
    {
        $user = Auth::user();

        if ($turno->cita && $turno->cita->id_barbero != $user->id_usuario) {
            return back()->with('Este turno no está asignado a tu puesto.');
        }

        // Si ya hay un turno en atención para este barbero, ponerlo finalizado o avisar
        Turno::whereHas('cita', function ($q) use ($user) {
            $q->where('id_barbero', $user->id_usuario);
        })->where('estado', 'EN_ATENCION')->where('id_turno', '!=', $turno->id_turno)
            ->update(['estado' => 'FINALIZADO']);

        $turno->estado = 'EN_ATENCION';
        $turno->save();

        if ($turno->cita) {
            $turno->cita->estado = 'ACEPTADA';
            $turno->cita->save();
        }

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'LLAMADO_TURNO_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'turnos',
            'detalle' => "El barbero {$user->nombre} llamó al Turno #{$turno->posicion} (Cliente: {$turno->cliente->nombre}) a su silla",
            'observacion' => null,
        ]);

        return back()->with("¡Llamando al Turno #{$turno->posicion} ({$turno->cliente->nombre}) a tu silla de atención!");
    }

    /**
     * Finaliza la atención del turno en sala.
     */
    public function finalizar(Turno $turno)
    {
        $user = Auth::user();

        if ($turno->cita && $turno->cita->id_barbero != $user->id_usuario) {
            return back()->with('Acción no permitida.');
        }

        $turno->estado = 'FINALIZADO';
        $turno->save();

        if ($turno->cita) {
            $turno->cita->estado = 'COMPLETADA';
            $turno->cita->save();
        }

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'FINALIZAR_TURNO_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'turnos',
            'detalle' => "Turno #{$turno->posicion} finalizado con éxito",
            'observacion' => null,
        ]);

        return back()->with("Turno {$turno->posicion} finalizado exitosamente.");
    }
}
