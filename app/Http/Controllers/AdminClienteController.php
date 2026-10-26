<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Cita;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminClienteController extends Controller
{
    /**
     * Directorio y gestión de clientes.
     */
    public function index(Request $request)
    {
        $query = Usuario::where('id_rol', Usuario::ROL_CLIENTE)
            ->withCount([
                'citasComoCliente',
                'citasComoCliente as citas_completadas_count' => function ($q) {
                    $q->where('estado', 'COMPLETADA');
                },
                'turnos',
            ])
            ->with([
                'citasComoCliente' => function ($q) {
                    $q->latest('fecha')->limit(1)->with(['servicio', 'barbero']);
                },
            ]);

        // Filtro por Búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%")
                    ->orWhere('telefono', 'like', "%{$buscar}%")
                    ->orWhere('numero_identificacion', 'like', "%{$buscar}%");
            });
        }

        // Filtro por Estado
        if ($request->filled('estado') && $request->estado !== 'TODOS') {
            $query->whereIn('estado', [strtolower($request->estado), strtoupper($request->estado)]);
        }

        $perPage = (int) $request->input('per_page', 8);
        if (! in_array($perPage, [6, 8, 10, 12, 16, 24])) {
            $perPage = 8;
        }

        $clientes = $query->orderBy('nombre', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        // Métricas clave del negocio
        $totalClientes = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->count();
        $clientesActivos = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->activos()->count();
        $clientesFrecuentes = Usuario::where('id_rol', Usuario::ROL_CLIENTE)->has('citasComoCliente', '>=', 2)->count();
        $totalCitasAtendidas = Cita::where('estado', 'COMPLETADA')->count();

        return view('administrador.clientes.index', compact(
            'clientes',
            'totalClientes',
            'clientesActivos',
            'clientesFrecuentes',
            'totalCitasAtendidas'
        ));
    }

    /**
     * Registra un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,email'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'numero_identificacion' => ['nullable', 'string', 'max:30'],
            'estado' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $cliente = Usuario::create([
            'id_rol' => Usuario::ROL_CLIENTE,
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'] ?? null,
            'numero_identificacion' => $validated['numero_identificacion'] ?? null,
            'password' => Hash::make($validated['password'] ?? 'cliente123'),
            'estado' => strtoupper($validated['estado']),
            'fecha_ingreso' => now()->toDateString(),
        ]);

        // Registrar Auditoría
        Auditoria::create([
            'id_usuario' => Auth::id() ?? 1,
            'accion' => 'CREAR_CLIENTE',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'usuarios',
            'detalle' => "Nuevo cliente registrado: '{$cliente->nombre}'",
            'observacion' => "Documento: {$cliente->numero_identificacion}. Tel: {$cliente->telefono}.",
        ]);

        return redirect()->route('admin.clientes.index')
            ->with("¡Cliente '{$cliente->nombre}' registrado exitosamente!");
    }

    /**
     * Actualiza la ficha de un cliente.
     */
    public function update(Request $request, Usuario $cliente)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,email,'.$cliente->id_usuario.',id_usuario'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'numero_identificacion' => ['nullable', 'string', 'max:30'],
            'estado' => ['required', 'string'],
        ]);

        $validated['estado'] = strtoupper($validated['estado']);
        $cliente->update($validated);

        Auditoria::create([
            'id_usuario' => Auth::id() ?? 1,
            'accion' => 'ACTUALIZAR_CLIENTE',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'usuarios',
            'detalle' => "Cliente modificado: '{$cliente->nombre}'",
            'observacion' => "Estado: {$cliente->estado}. Teléfono: {$cliente->telefono}.",
        ]);

        return redirect()->route('admin.clientes.index')
            ->with('success', "¡Datos de '{$cliente->nombre}' actualizados correctamente!");
    }

    /**
     * Alterna estado activo / inactivo de un cliente.
     */
    public function cambiarEstado(Request $request, Usuario $cliente)
    {
        $esActivo = in_array(strtoupper($cliente->estado), ['ACTIVO']);
        $nuevoEstado = $esActivo ? 'INACTIVO' : 'ACTIVO';
        $cliente->estado = $nuevoEstado;
        $cliente->save();

        Auditoria::create([
            'id_usuario' => Auth::id() ?? 1,
            'accion' => 'ESTADO_CLIENTE',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'usuarios',
            'detalle' => "Estado de cliente '{$cliente->nombre}' cambiado a {$nuevoEstado}",
            'observacion' => 'Modificación administrativa de acceso a reservas.',
        ]);

        return back()->with('success', "El estado de '{$cliente->nombre}' ha sido cambiado a {$nuevoEstado}.");
    }

    /**
     * Devuelve el historial de citas de un cliente en formato JSON (para modal interactivo).
     */
    public function historial(Usuario $cliente)
    {
        $citas = $cliente->citasComoCliente()
            ->with(['barbero', 'servicio'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        return response()->json([
            'cliente' => $cliente->nombre,
            'total' => $citas->count(),
            'citas' => $citas,
        ]);
    }
}
