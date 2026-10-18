<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AdminCitaController extends Controller
{
    /**
     * Muestra el listado de citas con filtros avanzados (estado, fecha, barbero, búsqueda).
     */
    public function index(Request $request)
    {
        $query = Cita::with(['cliente', 'barbero', 'servicio', 'reprogramaciones']);

        // Filtro por Estado
        if ($request->filled('estado') && $request->estado !== 'TODAS') {
            $query->where('estado', $request->estado);
        }

        // Filtro por Fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        // Filtro por Barbero
        if ($request->filled('id_barbero')) {
            $query->where('id_barbero', $request->id_barbero);
        }

        // Búsqueda por cliente (nombre, cédula, teléfono)
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('cliente', function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('numero_identificacion', 'like', "%{$buscar}%")
                    ->orWhere('telefono', 'like', "%{$buscar}%");
            });
        }

        $citas = $query->orderBy('fecha', 'desc')
            ->orderBy('hora', 'asc')
            ->paginate(15)
            ->withQueryString();

        // Conteos consolidados para tabs de navegación rápida
        $conteos = Cita::selectRaw("
            count(*) as total,
            count(case when estado = 'PENDIENTE' then 1 end) as pendientes,
            count(case when estado = 'ACEPTADA' then 1 end) as aceptadas,
            count(case when estado = 'REPROGRAMADA' then 1 end) as reprogramadas,
            count(case when estado = 'COMPLETADA' then 1 end) as completadas,
            count(case when estado = 'CANCELADA' then 1 end) as canceladas
        ")->first();

        $conteoTotal = (int) ($conteos->total ?? 0);
        $conteoPendientes = (int) ($conteos->pendientes ?? 0);
        $conteoAceptadas = (int) ($conteos->aceptadas ?? 0);
        $conteoReprogramadas = (int) ($conteos->reprogramadas ?? 0);
        $conteoCompletadas = (int) ($conteos->completadas ?? 0);
        $conteoCanceladas = (int) ($conteos->canceladas ?? 0);

        // Datos para modales y selectores
        $clientes = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->activos()->orderBy('nombre')->get();
        $barberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)->activos()->orderBy('nombre')->get();
        $servicios = Servicio::where('estado', 'ACTIVO')->orderBy('nombre')->get();

        return view('administrador.citas.index', compact(
            'citas',
            'conteoTotal',
            'conteoPendientes',
            'conteoAceptadas',
            'conteoReprogramadas',
            'conteoCompletadas',
            'conteoCanceladas',
            'clientes',
            'barberos',
            'servicios'
        ));
    }

    /**
     * Guarda una nueva cita.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cliente' => ['required', 'exists:usuarios,id_usuario'],
            'id_barbero' => ['required', 'exists:usuarios,id_usuario'],
            'id_servicio' => ['required', 'exists:servicios,id_servicio'],
            'fecha' => ['required', 'date'],
            'hora' => ['required'],
            'estado' => ['nullable', 'in:ACEPTADA,PENDIENTE'],
            'observacion' => ['nullable', 'string', 'max:500'],
        ]);

        $cita = Cita::create([
            'id_cliente' => $validated['id_cliente'],
            'id_barbero' => $validated['id_barbero'],
            'id_servicio' => $validated['id_servicio'],
            'fecha' => $validated['fecha'],
            'hora' => $validated['hora'],
            'estado' => $validated['estado'] ?? 'ACEPTADA',
            'observacion' => $validated['observacion'] ?? null,
        ]);

        return redirect()->route('admin.citas.index')
            ->with('success', "¡Cita #{$cita->id_cita} agendada exitosamente!");
    }

    /**
     * Actualiza los datos de una cita existente.
     */
    public function update(Request $request, Cita $cita)
    {
        $validated = $request->validate([
            'id_barbero' => ['required', 'exists:usuarios,id_usuario'],
            'id_servicio' => ['required', 'exists:servicios,id_servicio'],
            'fecha' => ['required', 'date'],
            'hora' => ['required'],
            'estado' => ['required', 'in:ACEPTADA,PENDIENTE,REPROGRAMADA,COMPLETADA,CANCELADA'],
            'observacion' => ['nullable', 'string', 'max:500'],
            'motivo_cancelacion' => ['nullable', 'string', 'max:500'],
        ]);

        $cita->update($validated);

        return redirect()->route('admin.citas.index')
            ->with('success', "Cita #{$cita->id_cita} actualizada correctamente.");
    }

    /**
     * Cambia rápidamente el estado de una cita.
     */
    public function cambiarEstado(Request $request, Cita $cita)
    {
        $validated = $request->validate([
            'estado' => ['required', 'in:ACEPTADA,PENDIENTE,REPROGRAMADA,COMPLETADA,CANCELADA'],
            'motivo_cancelacion' => ['nullable', 'string', 'max:500'],
        ]);

        $cita->estado = $validated['estado'];

        if ($validated['estado'] === 'CANCELADA' && ! empty($validated['motivo_cancelacion'])) {
            $cita->motivo_cancelacion = $validated['motivo_cancelacion'];
        }

        $cita->save();

        return back()->with('success', "La cita #{$cita->id_cita} cambió al estado: {$cita->estado}.");
    }

    /**
     * Cancela o elimina una cita.
     */
    public function destroy(Request $request, Cita $cita)
    {
        $cita->estado = 'CANCELADA';
        $cita->motivo_cancelacion = $request->input('motivo_cancelacion', 'Cancelada por el administrador');
        $cita->save();

        return back()->with('success', "Cita #{$cita->id_cita} cancelada.");
    }
}
