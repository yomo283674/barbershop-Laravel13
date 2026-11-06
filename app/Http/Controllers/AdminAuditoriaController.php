<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Cita;
use App\Models\Reporte;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminAuditoriaController extends Controller
{
    /**
     * Centro de control de Auditoría del Sistema y Reportes Ejecutivos.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'auditoria');

        // 1. Auditoría Logs
        $queryAudit = Auditoria::with('usuario');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $queryAudit->where(function ($q) use ($buscar) {
                $q->where('accion', 'like', "%{$buscar}%")
                    ->orWhere('entidad_afectada', 'like', "%{$buscar}%")
                    ->orWhere('detalle', 'like', "%{$buscar}%")
                    ->orWhere('observacion', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('resultado') && $request->resultado !== 'TODOS') {
            $queryAudit->where('resultado', $request->resultado);
        }

        if ($request->filled('fecha')) {
            $queryAudit->whereDate('fecha_hora', $request->fecha);
        }

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [8, 10, 15, 20, 30, 50])) {
            $perPage = 10;
        }

        $logs = $queryAudit->orderBy('fecha_hora', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        // Métricas de Auditoría
        $totalLogs = Auditoria::count();
        $logsHoy = Auditoria::whereDate('fecha_hora', now()->toDateString())->count();
        $logsExitosos = Auditoria::where('resultado', 'EXITO')->count();
        $entidadesModificadas = Auditoria::distinct('entidad_afectada')->count('entidad_afectada');

        // 2. Reportes Ejecutivos y Business Intelligence
        $reportes = Reporte::with('generador')->orderBy('fecha_generacion', 'desc')->get();

        $citasPorEstado = Cita::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        $ingresosEstimados = (float) Cita::where('citas.estado', 'COMPLETADA')
            ->join('servicios', 'citas.id_servicio', '=', 'servicios.id_servicio')
            ->sum('servicios.precio');

        $topServicios = Servicio::withCount('citas')
            ->orderBy('citas_count', 'desc')
            ->take(5)
            ->get();

        $topBarberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)
            ->activos()
            ->withCount([
                'citasComoBarbero',
                'citasComoBarbero as completadas_count' => function ($q) {
                    $q->where('estado', 'COMPLETADA');
                },
            ])
            ->orderBy('completadas_count', 'desc')
            ->take(4)
            ->get();

        $turnosHoyCount = Turno::whereDate('fecha', now()->toDateString())->count();

        return view('administrador.auditoria.index', compact(
            'tab',
            'logs',
            'totalLogs',
            'logsHoy',
            'logsExitosos',
            'entidadesModificadas',
            'reportes',
            'citasPorEstado',
            'ingresosEstimados',
            'topServicios',
            'topBarberos',
            'turnosHoyCount'
        ));
    }

    /**
     * Genera y consolida un nuevo reporte ejecutivo del negocio.
     */
    public function generarReporte(Request $request)
    {
        $validated = $request->validate([
            'tipo_reporte' => ['required', 'string', 'in:FINANCIERO_VENTAS,PRODUCTIVIDAD_EQUIPO,OPERACION_SALA,RESUMEN_EJECUTIVO'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ]);

        $adminId = Auth::id() ?? 1;

        // Consolidación de datos analíticos para el periodo
        $citasPeriodo = Cita::whereBetween('fecha', [$validated['fecha_inicio'], $validated['fecha_fin']])
            ->with('servicio')
            ->get();

        $totalCitas = $citasPeriodo->count();
        $completadas = $citasPeriodo->where('estado', 'COMPLETADA')->count();
        $canceladas = $citasPeriodo->where('estado', 'CANCELADA')->count();
        $recaudo = $citasPeriodo->where('estado', 'COMPLETADA')->sum(function ($c) {
            return $c->servicio->precio ?? 0;
        });

        $datos = [
            'total_citas' => $totalCitas,
            'citas_completadas' => $completadas,
            'citas_canceladas' => $canceladas,
            'tasa_efectividad' => $totalCitas > 0 ? round(($completadas / $totalCitas) * 100, 1).'%' : '0%',
            'ingresos_totales' => $recaudo,
            'periodo' => "{$validated['fecha_inicio']} a {$validated['fecha_fin']}",
            'generado_en' => now()->toDateTimeString(),
        ];

        $reporte = Reporte::create([
            'id_generador' => $adminId,
            'tipo_reporte' => $validated['tipo_reporte'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'datos' => $datos,
        ]);

        // Registrar en Auditoría
        Auditoria::create([
            'id_usuario' => $adminId,
            'accion' => 'GENERAR_REPORTE',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'reportes',
            'detalle' => "Generado reporte tipo '{$reporte->tipo_reporte}'",
            'observacion' => "Periodo: {$reporte->fecha_inicio} a {$reporte->fecha_fin}. Citas analizadas: {$totalCitas}.",
        ]);

        return redirect()->route('admin.auditoria.index', ['tab' => 'reportes'])
            ->with('success', "¡Reporte ejecutivo '{$reporte->tipo_reporte}' generado exitosamente!");
    }
}
