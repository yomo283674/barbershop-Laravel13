<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminBarberoController extends Controller
{
    /**
     * Muestra el catálogo y gestión de Barberos.
     */
    public function index(Request $request)
    {
        $query = Usuario::where('id_rol', Usuario::ROL_BARBERO)
            ->withCount([
                'citasComoBarbero',
                'citasComoBarbero as citas_hoy_count' => function ($q) {
                    $q->whereDate('fecha', now()->toDateString());
                },
                'servicios',
            ]);

        // Filtro por Búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('especialidad', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%")
                    ->orWhere('telefono', 'like', "%{$buscar}%");
            });
        }

        // Filtro por Estado
        if ($request->filled('estado') && $request->estado !== 'TODOS') {
            $query->where('estado', $request->estado);
        }

        $perPage = (int) $request->input('per_page', 3);
        if (! in_array($perPage, [3, 6, 9, 12])) {
            $perPage = 3;
        }

        $barberos = $query->orderBy('nombre', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        // Métricas
        $totalBarberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)->count();
        $barberosActivos = Usuario::where('id_rol', Usuario::ROL_BARBERO)->activos()->count();
        $barberosInactivos = Usuario::where('id_rol', Usuario::ROL_BARBERO)->whereIn('estado', ['INACTIVO', 'inactivo'])->count();
        $totalCitasHoy = Cita::whereDate('fecha', now()->toDateString())->count();

        return view('administrador.barberos.index', compact(
            'barberos',
            'totalBarberos',
            'barberosActivos',
            'barberosInactivos',
            'totalCitasHoy'
        ));
    }

    /**
     * Guarda un nuevo barbero en el sistema.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,email'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'numero_identificacion' => ['nullable', 'string', 'max:30'],
            'especialidad' => ['required', 'string', 'max:255'],
            'cargo' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $barbero = Usuario::create([
            'id_rol' => Usuario::ROL_BARBERO,
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'] ?? null,
            'numero_identificacion' => $validated['numero_identificacion'] ?? null,
            'especialidad' => $validated['especialidad'],
            'cargo' => $validated['cargo'] ?? 'Barbero Profesional',
            'password' => Hash::make($validated['password'] ?? 'barbero123'),
            'estado' => 'ACTIVO',
            'fecha_ingreso' => now()->toDateString(),
        ]);

        return redirect()->route('admin.barberos.index')
            ->with("'{$barbero->nombre}' registrado exitosamente!");
    }

    /**
     * Actualiza los datos de un barbero.
     */
    public function update(Request $request, Usuario $barbero)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,email,'.$barbero->id_usuario.',id_usuario'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'numero_identificacion' => ['nullable', 'string', 'max:30'],
            'especialidad' => ['required', 'string', 'max:255'],
            'cargo' => ['nullable', 'string', 'max:100'],
            'estado' => ['required', 'string'],
        ]);

        $validated['estado'] = strtoupper($validated['estado']);
        $barbero->update($validated);

        return redirect()->route('admin.barberos.index')
            ->with("Barbero '{$barbero->nombre}' actualizado con éxito.");
    }

    /**
     * Cambia el estado activo / inactivo de un barbero.
     */
    public function cambiarEstado(Request $request, Usuario $barbero)
    {
        $esActivo = in_array(strtoupper($barbero->estado), ['ACTIVO']);
        $nuevoEstado = $esActivo ? 'INACTIVO' : 'ACTIVO';
        $barbero->estado = $nuevoEstado;
        $barbero->save();

        return back()->with("Estado de '{$barbero->nombre}' cambiado a {$nuevoEstado}.");
    }
}
