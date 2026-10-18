<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Disponibilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BarberoDisponibilidadController extends Controller
{
    /**
     * Muestra el calendario de disponibilidad y bloqueos de descanso del Barbero.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $disponibilidades = Disponibilidad::where('id_barbero', $user->id_usuario)
            ->whereDate('fecha', '>=', Carbon::today()->subDays(7))
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'asc')
            ->paginate(15);

        $totalBloqueos = Disponibilidad::where('id_barbero', $user->id_usuario)
            ->where('disponible', false)
            ->whereDate('fecha', '>=', Carbon::today())
            ->count();

        $totalJornadasEspeciales = Disponibilidad::where('id_barbero', $user->id_usuario)
            ->where('disponible', true)
            ->whereDate('fecha', '>=', Carbon::today())
            ->count();

        return view('barbero.disponibilidad.index', compact(
            'disponibilidades',
            'totalBloqueos',
            'totalJornadasEspeciales'
        ));
    }

    /**
     * Registra un bloqueo de descanso, almuerzo o jornada especial.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'disponible' => ['required', 'boolean'],
            'motivo' => ['nullable', 'string', 'max:255'],
        ]);

        $disponibilidad = Disponibilidad::create([
            'id_barbero' => $user->id_usuario,
            'fecha' => $validated['fecha'],
            'hora_inicio' => $validated['hora_inicio'],
            'hora_fin' => $validated['hora_fin'],
            'disponible' => $validated['disponible'],
        ]);

        $tipo = $validated['disponible'] ? 'Disponibilidad habilitada' : 'Bloqueo por descanso/pausa';

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'REGISTRO_DISPONIBILIDAD_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'disponibilidad',
            'detalle' => "El barbero registró {$tipo} para el {$validated['fecha']} ({$validated['hora_inicio']} - {$validated['hora_fin']})",
            'observacion' => $validated['motivo'] ?? null,
        ]);

        return back()->with('success', 'Franja de horario actualizada exitosamente.');
    }

    /**
     * Elimina una franja de disponibilidad o desbloquea un descanso.
     */
    public function destroy(Disponibilidad $disponibilidad)
    {
        $user = Auth::user();

        if ($disponibilidad->id_barbero != $user->id_usuario) {
            return back()->with('error', 'Acción no permitida.');
        }

        $disponibilidad->delete();

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'ELIMINAR_DISPONIBILIDAD_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'disponibilidad',
            'detalle' => "Franja horaria del {$disponibilidad->fecha} eliminada con éxito",
            'observacion' => null,
        ]);

        return back()->with('success', 'Franja horaria liberada exitosamente.');
    }
}
