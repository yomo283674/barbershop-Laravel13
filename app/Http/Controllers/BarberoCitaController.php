<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Cita;
use App\Models\Reprogramacion;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BarberoCitaController extends Controller
{
    /**
     * Muestra la agenda personal de citas del Barbero autenticado.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Cita::with(['cliente', 'servicio', 'turno', 'reprogramaciones'])
            ->where('id_barbero', $user->id_usuario);

        // Filtro por Estado
        if ($request->filled('estado') && $request->estado !== 'TODAS') {
            $query->where('estado', $request->estado);
        }

        // Filtro por Fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        // Búsqueda por cliente
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('cliente', function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('telefono', 'like', "%{$buscar}%");
            });
        }

        $citas = $query->orderBy('fecha', 'desc')
            ->orderBy('hora', 'asc')
            ->paginate(15)
            ->withQueryString();

        // Conteos consolidados para tabs de navegación rápida del barbero
        $conteos = Cita::where('id_barbero', $user->id_usuario)
            ->selectRaw("
                count(*) as total,
                count(case when estado = 'PENDIENTE' then 1 end) as pendientes,
                count(case when estado = 'ACEPTADA' then 1 end) as aceptadas,
                count(case when estado = 'COMPLETADA' then 1 end) as completadas,
                count(case when estado = 'CANCELADA' then 1 end) as canceladas
            ")->first();

        $totalCitas = (int) ($conteos->total ?? 0);
        $totalPendientes = (int) ($conteos->pendientes ?? 0);
        $totalAceptadas = (int) ($conteos->aceptadas ?? 0);
        $totalCompletadas = (int) ($conteos->completadas ?? 0);
        $totalCanceladas = (int) ($conteos->canceladas ?? 0);

        return view('barbero.citas.index', compact(
            'citas',
            'totalCitas',
            'totalPendientes',
            'totalAceptadas',
            'totalCompletadas',
            'totalCanceladas'
        ));
    }

    /**
     * Acepta, cancela o actualiza el estado de una cita asignada al barbero.
     */
    public function cambiarEstado(Request $request, Cita $cita)
    {
        $user = Auth::user();

        if ($cita->id_barbero != $user->id_usuario) {
            return back()->with('No puedes gestionar citas de otros barberos.');
        }

        $validated = $request->validate([
            'estado' => ['required', 'in:ACEPTADA,CANCELADA,REPROGRAMADA'],
            'motivo_cancelacion' => ['required_if:estado,CANCELADA', 'nullable', 'string', 'max:500'],
        ]);

        $estadoAnterior = $cita->estado;
        $cita->estado = $validated['estado'];

        if ($validated['estado'] === 'CANCELADA') {
            $cita->motivo_cancelacion = $validated['motivo_cancelacion'];
            // Si tenía turno en sala, cancelarlo/eliminarlo
            if ($cita->turno) {
                $cita->turno->delete();
            }
        } elseif ($validated['estado'] === 'ACEPTADA') {
            // Si la cita es de hoy y no tiene turno, generarlo para sala
            if ($cita->fecha && Carbon::parse($cita->fecha)->isToday() && ! $cita->turno) {
                $maxPosicion = Turno::whereDate('fecha', Carbon::today())->max('posicion') ?? 0;
                Turno::create([
                    'id_cliente' => $cita->id_cliente,
                    'id_cita' => $cita->id_cita,
                    'fecha' => Carbon::today(),
                    'posicion' => $maxPosicion + 1,
                    'estado' => 'EN_ESPERA',
                ]);
            }
        }

        $cita->save();

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'CAMBIO_ESTADO_CITA_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'citas',
            'detalle' => "Cita #{$cita->id_cita} cambiada de {$estadoAnterior} a {$cita->estado}",
            'observacion' => $validated['motivo_cancelacion'] ?? null,
        ]);

        $msg = $cita->estado === 'ACEPTADA' ? '¡Cita confirmada y agendada exitosamente!' : 'Cita marcada como cancelada.';

        return back()->with('success', $msg);
    }

    /**
     * Pone al cliente en la silla e inicia el servicio (cambia turno a EN_ATENCION).
     */
    public function iniciarServicio(Cita $cita)
    {
        $user = Auth::user();

        if ($cita->id_barbero != $user->id_usuario) {
            return back()->with('Acción no permitida.');
        }

        // Si ya hay un cliente en atención para este barbero, advertir o finalizarlo
        $clienteEnAtencion = Turno::whereHas('cita', function ($q) use ($user) {
            $q->where('id_barbero', $user->id_usuario);
        })->where('estado', 'EN_ATENCION')->first();

        if ($clienteEnAtencion && $clienteEnAtencion->id_cita != $cita->id_cita) {
            return back()->with('Ya tienes un cliente en silla de atención. Finaliza el servicio actual primero.');
        }

        // Crear o actualizar turno a EN_ATENCION
        if ($cita->turno) {
            $cita->turno->estado = 'EN_ATENCION';
            $cita->turno->save();
        } else {
            $maxPos = Turno::whereDate('fecha', Carbon::today())->max('posicion') ?? 0;
            Turno::create([
                'id_cliente' => $cita->id_cliente,
                'id_cita' => $cita->id_cita,
                'fecha' => Carbon::today(),
                'posicion' => $maxPos + 1,
                'estado' => 'EN_ATENCION',
            ]);
        }

        $cita->estado = 'ACEPTADA';
        $cita->save();

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'INICIO_SERVICIO_SILLA',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'citas',
            'detalle' => "El barbero {$user->nombre} inició atención de la cita #{$cita->id_cita} (Cliente: {$cita->cliente->nombre})",
            'observacion' => "Servicio: {$cita->servicio->nombre}",
        ]);

        return back()->with("¡Servicio iniciado en silla con {$cita->cliente->nombre}!");
    }

    /**
     * Finaliza el servicio en silla, guarda las notas técnicas del corte y calcula la comisión.
     */
    public function finalizar(Request $request, Cita $cita)
    {
        $user = Auth::user();

        if ($cita->id_barbero != $user->id_usuario) {
            return back()->with('Acción no permitida.');
        }

        $validated = $request->validate([
            'observacion' => ['nullable', 'string', 'max:1000'],
        ]);

        $cita->estado = 'COMPLETADA';
        if (! empty($validated['observacion'])) {
            $cita->observacion = $validated['observacion'];
        }
        $cita->save();

        // Finalizar turno asociado si existe
        if ($cita->turno) {
            $cita->turno->estado = 'FINALIZADO';
            $cita->turno->save();
        }

        $comision = ($cita->servicio->precio ?? 0) * 0.40;

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'FINALIZACION_SERVICIO_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'citas',
            'detalle' => "Servicio completado: {$cita->servicio->nombre} para {$cita->cliente->nombre}. Comisión devengada: \${$comision}",
            'observacion' => $validated['observacion'] ?? 'Servicio finalizado con satisfacción',
        ]);

        return back()->with('¡Servicio completado exitosamente! Has sumado $'.number_format($comision, 2).' en comisión.');
    }

    /**
     * Propone o gestiona una reprogramación de horario para la cita.
     */
    public function reprogramar(Request $request, Cita $cita)
    {
        $user = Auth::user();

        if ($cita->id_barbero != $user->id_usuario) {
            return back()->with('Acción no autorizada.');
        }

        $validated = $request->validate([
            'nueva_fecha' => ['required', 'date', 'after_or_equal:today'],
            'nueva_hora' => ['required', 'date_format:H:i'],
            'motivo' => ['nullable', 'string', 'max:500'],
        ]);

        $cita->fecha = $validated['nueva_fecha'];
        $cita->hora = $validated['nueva_hora'];
        $cita->estado = 'REPROGRAMADA';
        if (! empty($validated['motivo'])) {
            $cita->observacion = 'Reprogramada por el barbero: '.$validated['motivo'];
        }
        $cita->save();

        Reprogramacion::create([
            'id_cita' => $cita->id_cita,
            'nueva_fecha' => $validated['nueva_fecha'],
            'nueva_hora' => $validated['nueva_hora'],
            'estado' => 'CONFIRMADA',
        ]);

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'REPROGRAMACION_CITA_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'citas',
            'detalle' => "Cita #{$cita->id_cita} reprogramada para el {$validated['nueva_fecha']} a las {$validated['nueva_hora']}",
            'observacion' => $validated['motivo'] ?? null,
        ]);

        return back()->with("Cita reprogramada con éxito para el {$validated['nueva_fecha']} a las {$validated['nueva_hora']}.");
    }
}
