<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Cita;
use App\Models\Configuracion;
use App\Models\Disponibilidad;
use App\Models\Reprogramacion;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClienteDashboardController extends Controller
{
    /**
     * Muestra el panel principal del cliente: próxima cita, turno en vivo, accesos rápidos y resumen.
     */
    public function index(): View
    {
        /** @var Usuario $user */
        $user = Auth::user();
        $hoy = Carbon::today()->toDateString();

        $misCitas = $user ? $user->citasComoCliente()
            ->with(['barbero', 'servicio', 'turno', 'reprogramaciones'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'asc')
            ->get() : collect();

        // Próxima cita agendada activa
        $proximaCita = $misCitas->where('fecha', '>=', $hoy)
            ->whereIn('estado', ['ACEPTADA', 'PENDIENTE', 'REPROGRAMADA'])
            ->first();

        // Turno activo en sala hoy (si tiene cita hoy y está en espera o en atención)
        $miTurnoHoy = Turno::where('id_cliente', $user->id_usuario)
            ->whereDate('fecha', $hoy)
            ->whereIn('estado', ['EN_ESPERA', 'EN_ATENCION'])
            ->with(['cita.barbero', 'cita.servicio'])
            ->first();

        $turnosPorDelante = 0;
        if ($miTurnoHoy && $miTurnoHoy->estado === 'EN_ESPERA') {
            $turnosPorDelante = Turno::whereDate('fecha', $hoy)
                ->where('estado', 'EN_ESPERA')
                ->where('posicion', '<', $miTurnoHoy->posicion)
                ->count();
        }

        // Solicitudes de reprogramación pendientes enviadas por el barbero para citas de este cliente
        $reprogramacionesPendientes = Reprogramacion::whereHas('cita', function ($q) use ($user) {
            $q->where('id_cliente', $user->id_usuario);
        })
            ->where('estado', 'PENDIENTE')
            ->with(['cita.barbero', 'cita.servicio'])
            ->latest()
            ->get();

        // Barberos activos con sus respectivos servicios paginados
        $barberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)
            ->activos()
            ->with(['servicios' => function ($q) {
                $q->where('estado', 'ACTIVO')->with('categoria');
            }])
            ->orderBy('nombre')
            ->paginate(4, ['*'], 'barberos_page')
            ->withQueryString();

        $todosLosBarberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)
            ->activos()
            ->with(['servicios' => function ($q) {
                $q->where('estado', 'ACTIVO')->with('categoria');
            }])
            ->orderBy('nombre')
            ->get();

        return view('cliente.dashboard3', compact(
            'misCitas',
            'proximaCita',
            'miTurnoHoy',
            'turnosPorDelante',
            'reprogramacionesPendientes',
            'barberos',
            'todosLosBarberos'
        ));
    }

    /**
     * Muestra el catálogo e historial completo de citas del cliente con filtros y paginación.
     */
    public function citas(Request $request): View
    {
        /** @var Usuario $user */
        $user = Auth::user();

        $query = Cita::with(['barbero', 'servicio', 'turno', 'reprogramaciones'])
            ->where('id_cliente', $user->id_usuario);

        // Filtro por Estado
        if ($request->filled('estado') && $request->estado !== 'TODAS') {
            $query->where('estado', $request->estado);
        }

        // Filtro por Fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        // Búsqueda por servicio o barbero
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->whereHas('servicio', function ($sq) use ($buscar) {
                    $sq->where('nombre', 'like', "%{$buscar}%");
                })->orWhereHas('barbero', function ($bq) use ($buscar) {
                    $bq->where('nombre', 'like', "%{$buscar}%");
                });
            });
        }

        $citas = $query->orderBy('fecha', 'desc')
            ->orderBy('hora', 'asc')
            ->paginate(10)
            ->withQueryString();

        // Conteos por estado
        $conteos = Cita::where('id_cliente', $user->id_usuario)
            ->selectRaw("
                count(*) as total,
                count(case when estado = 'PENDIENTE' then 1 end) as pendientes,
                count(case when estado = 'ACEPTADA' then 1 end) as aceptadas,
                count(case when estado = 'REPROGRAMADA' then 1 end) as reprogramadas,
                count(case when estado = 'COMPLETADA' then 1 end) as completadas,
                count(case when estado = 'CANCELADA' then 1 end) as canceladas
            ")->first();

        $totalCitas = (int) ($conteos->total ?? 0);
        $totalPendientes = (int) ($conteos->pendientes ?? 0);
        $totalAceptadas = (int) ($conteos->aceptadas ?? 0);
        $totalReprogramadas = (int) ($conteos->reprogramadas ?? 0);
        $totalCompletadas = (int) ($conteos->completadas ?? 0);
        $totalCanceladas = (int) ($conteos->canceladas ?? 0);

        return view('cliente.citas.index', compact(
            'citas',
            'totalCitas',
            'totalPendientes',
            'totalAceptadas',
            'totalReprogramadas',
            'totalCompletadas',
            'totalCanceladas'
        ));
    }

    /**
     * Muestra el directorio visual del equipo de barberos y sus portafolios con fotos.
     */
    public function barberos(): View
    {
        $barberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)
            ->activos()
            ->with(['servicios' => function ($q) {
                $q->where('estado', 'ACTIVO')->with('categoria');
            }])
            ->withCount(['citasComoBarbero as completadas_count' => function ($q) {
                $q->where('estado', 'COMPLETADA');
            }])
            ->orderBy('nombre')
            ->paginate(4)
            ->withQueryString();

        $todosLosBarberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)
            ->activos()
            ->with(['servicios' => function ($q) {
                $q->where('estado', 'ACTIVO')->with('categoria');
            }])
            ->orderBy('nombre')
            ->get();

        return view('cliente.barberos.index', compact('barberos', 'todosLosBarberos'));
    }

    /**
     * Endpoint AJAX: Retorna los horarios disponibles calculados dinámicamente según duración y bloqueos.
     */
    public function horariosDisponibles(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_barbero' => ['required', 'exists:usuarios,id_usuario'],
            'id_servicio' => ['required', 'exists:servicios,id_servicio'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $servicio = Servicio::findOrFail($validated['id_servicio']);
        $duracionMin = (int) ($servicio->duracion_min ?? 45);

        $config = Configuracion::first();
        $horaAperturaStr = $config->horario_apertura ?? '08:00:00';
        $horaCierreStr = $config->horario_cierre ?? '20:00:00';

        $fechaReq = Carbon::parse($validated['fecha'])->toDateString();
        $esHoy = $fechaReq === Carbon::today()->toDateString();
        $ahora = Carbon::now();

        // 1. Obtener citas activas del barbero en la fecha seleccionada
        $citasExistentes = Cita::where('id_barbero', $validated['id_barbero'])
            ->whereDate('fecha', $fechaReq)
            ->whereIn('estado', ['PENDIENTE', 'ACEPTADA', 'REPROGRAMADA'])
            ->with('servicio')
            ->get();

        // 2. Obtener descansos/bloqueos del barbero en la fecha seleccionada
        $bloqueos = Disponibilidad::where('id_barbero', $validated['id_barbero'])
            ->whereDate('fecha', $fechaReq)
            ->where('disponible', false)
            ->get();

        // 3. Generar franjas horarias cada 30 minutos
        $horaInicio = Carbon::parse("{$fechaReq} {$horaAperturaStr}");
        $horaFin = Carbon::parse("{$fechaReq} {$horaCierreStr}");

        $slotsDisponibles = [];
        $cursor = clone $horaInicio;

        while ($cursor->copy()->addMinutes($duracionMin) <= $horaFin) {
            $slotInicio = clone $cursor;
            $slotFin = $cursor->copy()->addMinutes($duracionMin);
            $slotStr = $slotInicio->format('H:i');

            // Si es hoy, verificar que la hora tenga margen de al menos 15 minutos en el futuro
            if ($esHoy && $slotInicio <= $ahora->copy()->addMinutes(15)) {
                $cursor->addMinutes(30);

                continue;
            }

            // Validar que no solape con ninguna cita existente
            $chocaConCita = $citasExistentes->first(function ($cita) use ($slotInicio, $slotFin, $fechaReq) {
                $citaInicio = Carbon::parse("{$fechaReq} {$cita->hora}");
                $citaDuracion = (int) ($cita->servicio->duracion_min ?? 45);
                $citaFin = $citaInicio->copy()->addMinutes($citaDuracion);

                return $slotInicio < $citaFin && $slotFin > $citaInicio;
            });

            // Validar que no solape con ningún descanso o bloqueo
            $chocaConBloqueo = $bloqueos->first(function ($b) use ($slotInicio, $slotFin, $fechaReq) {
                $bInicio = Carbon::parse("{$fechaReq} {$b->hora_inicio}");
                $bFin = Carbon::parse("{$fechaReq} {$b->hora_fin}");

                return $slotInicio < $bFin && $slotFin > $bInicio;
            });

            if (! $chocaConCita && ! $chocaConBloqueo) {
                $slotsDisponibles[] = [
                    'hora' => $slotStr,
                    'formato' => $slotInicio->format('h:i A'),
                ];
            }

            $cursor->addMinutes(30);
        }

        return response()->json([
            'fecha' => $fechaReq,
            'servicio' => $servicio->nombre,
            'duracion_min' => $duracionMin,
            'slots' => $slotsDisponibles,
            'total_disponibles' => count($slotsDisponibles),
        ]);
    }

    /**
     * Permite al cliente reservar una nueva cita con validación estricta de anticolisión horaria.
     */
    public function reservar(Request $request): RedirectResponse
    {
        /** @var Usuario $user */
        $user = Auth::user();

        $validated = $request->validate([
            'id_barbero' => ['required', 'exists:usuarios,id_usuario'],
            'id_servicio' => ['required', 'exists:servicios,id_servicio'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required'],
            'observacion' => ['nullable', 'string', 'max:500'],
        ]);

        // Verificar que el servicio pertenece al barbero seleccionado (o es general)
        $servicio = Servicio::findOrFail($validated['id_servicio']);
        if ($servicio->id_barbero && $servicio->id_barbero != $validated['id_barbero']) {
            return back()->with('error', 'El servicio seleccionado no corresponde al barbero elegido.');
        }

        $duracion = (int) ($servicio->duracion_min ?? 45);
        $fechaReq = Carbon::parse($validated['fecha'])->toDateString();
        $horaInicioReq = Carbon::parse("{$fechaReq} {$validated['hora']}");
        $horaFinReq = (clone $horaInicioReq)->addMinutes($duracion);

        // Validación de no agendar en el pasado para citas de hoy
        if ($fechaReq === Carbon::today()->toDateString() && $horaInicioReq <= Carbon::now()) {
            return back()->with('error', 'No es posible agendar una cita en una hora que ya ha transcurrido.');
        }

        // Validación anticolisión: Verificar si choca con otra cita activa del barbero
        $citasExistentes = Cita::where('id_barbero', $validated['id_barbero'])
            ->whereDate('fecha', $fechaReq)
            ->whereIn('estado', ['PENDIENTE', 'ACEPTADA', 'REPROGRAMADA'])
            ->with('servicio')
            ->get();

        $conflictoCita = $citasExistentes->first(function ($c) use ($horaInicioReq, $horaFinReq, $fechaReq) {
            $cInicio = Carbon::parse("{$fechaReq} {$c->hora}");
            $cDuracion = (int) ($c->servicio->duracion_min ?? 45);
            $cFin = (clone $cInicio)->addMinutes($cDuracion);

            return $horaInicioReq < $cFin && $horaFinReq > $cInicio;
        });

        if ($conflictoCita) {
            return back()->with('error', 'El barbero ya cuenta con una cita programada en esa franja horaria. Por favor selecciona otra hora.');
        }

        // Validación anticolisión: Verificar bloqueos de disponibilidad (descanso/receso)
        $bloqueos = Disponibilidad::where('id_barbero', $validated['id_barbero'])
            ->whereDate('fecha', $fechaReq)
            ->where('disponible', false)
            ->get();

        $conflictoBloqueo = $bloqueos->first(function ($d) use ($horaInicioReq, $horaFinReq, $fechaReq) {
            $dInicio = Carbon::parse("{$fechaReq} {$d->hora_inicio}");
            $dFin = Carbon::parse("{$fechaReq} {$d->hora_fin}");

            return $horaInicioReq < $dFin && $horaFinReq > $dInicio;
        });

        if ($conflictoBloqueo) {
            return back()->with('El barbero tiene un receso o bloqueo programado en ese horario.');
        }

        $cita = Cita::create([
            'id_cliente' => $user->id_usuario,
            'id_barbero' => $validated['id_barbero'],
            'id_servicio' => $validated['id_servicio'],
            'fecha' => $fechaReq,
            'hora' => $horaInicioReq->format('H:i:s'),
            'estado' => 'PENDIENTE',
            'observacion' => $validated['observacion'] ?? null,
        ]);

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'RESERVA_CITA_CLIENTE',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'citas',
            'detalle' => "El cliente {$user->nombre} solicitó la cita #{$cita->id_cita} para el {$fechaReq} a las {$validated['hora']}",
            'observacion' => "Barbero ID: {$cita->id_barbero} | Servicio: {$servicio->nombre} ($".number_format($servicio->precio, 0).')',
        ]);

        return back()->with('success', "¡Tu reserva para '{$servicio->nombre}' ha sido registrada con éxito! El barbero confirmará tu horario.");
    }

    /**
     * Permite al cliente cancelar una cita validando la política de tiempo de cancelación configurada.
     */
    public function cancelar(Request $request, Cita $cita): RedirectResponse
    {
        /** @var Usuario $user */
        $user = Auth::user();

        // Seguridad: el cliente solo puede cancelar sus propias citas
        if ($cita->id_cliente != $user->id_usuario) {
            return back()->with('No tienes permiso para modificar esta cita.');
        }

        if (! in_array($cita->estado, ['PENDIENTE', 'ACEPTADA', 'REPROGRAMADA'])) {
            return back()->with('Solo puedes cancelar citas que estén pendientes, confirmadas o reprogramadas.');
        }

        // Regla de Negocio: Validar tiempo_cancelacion_min configurado en el sistema
        $config = Configuracion::first();
        $minutosLimite = (int) ($config->tiempo_cancelacion_min ?? 60);

        if ($cita->fecha) {
            $fechaCitaStr = $cita->fecha instanceof Carbon ? $cita->fecha->format('Y-m-d') : (string) $cita->fecha;
            $citaDateTime = Carbon::parse("{$fechaCitaStr} {$cita->hora}");

            if (Carbon::now()->diffInMinutes($citaDateTime, false) < $minutosLimite) {
                return back()->with("No es posible cancelar la cita. Según las políticas de la barbería, las cancelaciones deben realizarse con al menos {$minutosLimite} minutos de antelación.");
            }
        }

        $validated = $request->validate([
            'motivo_cancelacion' => ['nullable', 'string', 'max:500'],
        ]);

        $cita->estado = 'CANCELADA';
        $cita->motivo_cancelacion = $validated['motivo_cancelacion'] ?? 'Cancelada voluntariamente por el cliente';
        $cita->save();

        if ($cita->turno) {
            $cita->turno->delete();
        }

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'CANCELACION_CITA_CLIENTE',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'citas',
            'detalle' => "El cliente {$user->nombre} canceló su cita #{$cita->id_cita}",
            'observacion' => $cita->motivo_cancelacion,
        ]);

        return back()->with("Tu cita #{$cita->id_cita} ha sido cancelada.");
    }

    /**
     * Permite al cliente aceptar o rechazar una solicitud de reprogramación propuesta por el barbero.
     */
    public function responderReprogramacion(Request $request, Reprogramacion $reprogramacion): RedirectResponse
    {
        /** @var Usuario $user */
        $user = Auth::user();

        $cita = $reprogramacion->cita;
        if (! $cita || $cita->id_cliente != $user->id_usuario) {
            return back()->with('No tienes autorización para responder a esta solicitud.');
        }

        if ($reprogramacion->estado !== 'PENDIENTE') {
            return back()->with('Esta solicitud ya ha sido procesada previamente.');
        }

        $validated = $request->validate([
            'accion' => ['required', 'in:aceptar,rechazar'],
        ]);

        if ($validated['accion'] === 'aceptar') {
            $reprogramacion->estado = 'CONFIRMADA';
            $reprogramacion->save();

            $cita->fecha = $reprogramacion->nueva_fecha;
            $cita->hora = $reprogramacion->nueva_hora;
            $cita->estado = 'ACEPTADA';
            $cita->save();

            // Si la nueva fecha es hoy y no tiene turno asignado, emitir turno en sala
            $hoy = Carbon::today()->toDateString();
            $nuevaFechaStr = $reprogramacion->nueva_fecha instanceof Carbon ? $reprogramacion->nueva_fecha->format('Y-m-d') : (string) $reprogramacion->nueva_fecha;

            if ($nuevaFechaStr === $hoy && ! $cita->turno) {
                $maxPos = Turno::whereDate('fecha', $hoy)->max('posicion') ?? 0;
                Turno::create([
                    'id_cliente' => $user->id_usuario,
                    'id_cita' => $cita->id_cita,
                    'fecha' => $hoy,
                    'posicion' => $maxPos + 1,
                    'estado' => 'EN_ESPERA',
                ]);
            }

            Auditoria::create([
                'id_usuario' => $user->id_usuario,
                'accion' => 'APROBACION_REPROGRAMACION_CLIENTE',
                'resultado' => 'EXITO',
                'entidad_afectada' => 'reprogramaciones',
                'detalle' => "El cliente aceptó el nuevo horario para la cita #{$cita->id_cita} ({$nuevaFechaStr} a las {$reprogramacion->nueva_hora})",
                'observacion' => null,
            ]);

            return back()->with('¡Has aceptado el nuevo horario! Tu cita ha quedado confirmada.');
        }

        // Rechazo de reprogramación
        $reprogramacion->estado = 'CANCELADA';
        $reprogramacion->save();

        $cita->estado = 'CANCELADA';
        $cita->motivo_cancelacion = 'Reprogramación no aceptada por el cliente';
        $cita->save();

        if ($cita->turno) {
            $cita->turno->delete();
        }

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'RECHAZO_REPROGRAMACION_CLIENTE',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'reprogramaciones',
            'detalle' => "El cliente rechazó la reprogramación propuesta para la cita #{$cita->id_cita}",
            'observacion' => 'Cita marcada como cancelada por falta de coincidencia horaria',
        ]);

        return back()->with('Has rechazado la solicitud de reprogramación. La cita ha sido cancelada.');
    }
}
