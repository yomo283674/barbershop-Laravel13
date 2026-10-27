<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminTurnoController extends Controller
{
    /**
     * Muestra la pantalla de control de Turnos y Sala de Espera.
     */
    public function index(Request $request)
    {
        $fecha = $request->input('fecha', Carbon::now()->toDateString());
        $estado = $request->input('estado', 'TODOS');

        $query = Turno::with(['cliente', 'cita.barbero', 'cita.servicio'])
            ->whereDate('fecha', $fecha);

        if ($estado !== 'TODOS') {
            $query->where('estado', $estado);
        }

        // Métricas de la sala de espera
        $todosTurnosHoy = Turno::whereDate('fecha', $fecha)->get();

        $perPage = (int) $request->input('per_page', 8);
        if (! in_array($perPage, [5, 8, 12, 20])) {
            $perPage = 8;
        }

        $turnos = $query->orderBy('posicion', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        $totalTurnos = $todosTurnosHoy->count();
        $turnosEnEspera = $todosTurnosHoy->where('estado', 'EN_ESPERA')->count();
        $turnosEnAtencion = $todosTurnosHoy->where('estado', 'EN_ATENCION')->count();
        $turnosFinalizados = $todosTurnosHoy->where('estado', 'FINALIZADO')->count();

        // Turno que está actualmente en el puesto de atención
        $turnoActual = $todosTurnosHoy->where('estado', 'EN_ATENCION')->first();

        // Siguiente en la fila
        $siguienteTurno = $todosTurnosHoy->where('estado', 'EN_ESPERA')->sortBy('posicion')->first();

        // Datos para modal de emisión de turno
        $clientes = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->activos()->orderBy('nombre')->get();

        // Citas de hoy que aún no tienen turno generado
        $citasHoySinTurno = Cita::with(['cliente', 'barbero', 'servicio'])
            ->whereDate('fecha', $fecha)
            ->whereNotIn('estado', ['CANCELADA', 'COMPLETADA'])
            ->whereDoesntHave('turno')
            ->get();

        return view('administrador.turnos.index', compact(
            'turnos',
            'fecha',
            'estado',
            'totalTurnos',
            'turnosEnEspera',
            'turnosEnAtencion',
            'turnosFinalizados',
            'turnoActual',
            'siguienteTurno',
            'clientes',
            'citasHoySinTurno'
        ));
    }

    /**
     * Emite un nuevo turno presencial para un cliente en sala.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cliente' => ['required', 'exists:usuarios,id_usuario'],
            'id_cita' => ['nullable', 'exists:citas,id_cita'],
        ]);

        $hoy = Carbon::now()->toDateString();
        $maxPosicion = Turno::whereDate('fecha', $hoy)->max('posicion') ?? 0;

        $turno = Turno::create([
            'id_cliente' => $validated['id_cliente'],
            'id_cita' => $validated['id_cita'] ?? null,
            'fecha' => $hoy,
            'posicion' => $maxPosicion + 1,
            'estado' => 'EN_ESPERA',
        ]);

        return redirect()->route('admin.turnos.index')
            ->with("{$turno->posicion} generado con éxito en sala de espera.");
    }

    /**
     * Llama a un cliente para pasar a la silla de atención (EN_ATENCION).
     */
    public function llamar(Turno $turno)
    {
        $turno->estado = 'EN_ATENCION';
        $turno->save();

        return back()->with("{$turno->posicion} llamado a la estación de atención.");
    }

    /**
     * Finaliza la atención de un turno (FINALIZADO).
     */
    public function finalizar(Turno $turno)
    {
        $turno->estado = 'FINALIZADO';
        $turno->save();

        // Si el turno estaba asociado a una cita, marcamos la cita como COMPLETADA
        if ($turno->cita) {
            $turno->cita->update(['estado' => 'COMPLETADA']);
        }

        return back()->with("{$turno->posicion} completado y finalizado.");
    }

    /**
     * Cancela o elimina un turno de la fila.
     */
    public function destroy(Turno $turno)
    {
        $pos = $turno->posicion;
        $turno->delete();

        return back()->with("Turno {$pos} cancelado de la fila de espera.");
    }
}
