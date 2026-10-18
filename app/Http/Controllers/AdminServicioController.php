<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Categoria;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminServicioController extends Controller
{
    /**
     * Muestra el catálogo de servicios de la barbería.
     */
    public function index(Request $request)
    {
        $query = Servicio::with(['categoria', 'barbero']);

        // Filtro por Búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        // Filtro por Categoría
        if ($request->filled('categoria') && $request->categoria !== 'TODAS') {
            $query->where('id_categoria', $request->categoria);
        }

        // Filtro por Estado
        if ($request->filled('estado') && $request->estado !== 'TODOS') {
            $query->where('estado', $request->estado);
        }

        $perPage = (int) $request->input('per_page', 8);
        if (! in_array($perPage, [6, 8, 10, 12, 16, 24])) {
            $perPage = 8;
        }

        $servicios = $query->orderBy('id_categoria', 'asc')
            ->orderBy('nombre', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        // Métricas de negocio
        $totalServicios = Servicio::count();
        $serviciosActivos = Servicio::where('estado', 'ACTIVO')->count();
        $precioPromedio = round(Servicio::where('estado', 'ACTIVO')->avg('precio') ?? 0, 0);
        $duracionPromedio = round(Servicio::where('estado', 'ACTIVO')->avg('duracion_min') ?? 0, 0);

        // Listas auxiliares para modales y filtros
        $categorias = Categoria::withCount('servicios')->orderBy('nombre')->get();
        $barberos = Usuario::where('id_rol', Usuario::ROL_BARBERO)->activos()->orderBy('nombre')->get();

        return view('administrador.servicios.index', compact(
            'servicios',
            'totalServicios',
            'serviciosActivos',
            'precioPromedio',
            'duracionPromedio',
            'categorias',
            'barberos'
        ));
    }

    /**
     * Registra un nuevo servicio en el catálogo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'id_categoria' => ['required', 'exists:categorias_servicio,id_categoria'],
            'precio' => ['required', 'numeric', 'min:0'],
            'duracion_min' => ['required', 'integer', 'min:5', 'max:240'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'id_barbero' => ['nullable', 'exists:usuarios,id_usuario'],
            'estado' => ['required', 'in:ACTIVO,INACTIVO'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('servicios', 'public');
            $validated['imagen'] = '/storage/'.$path;
        }

        $servicio = Servicio::create($validated);

        // Registro de Auditoría
        Auditoria::create([
            'id_usuario' => Auth::id() ?? 1,
            'accion' => 'CREAR_SERVICIO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'servicios',
            'detalle' => "Servicio creado: '{$servicio->nombre}' ($".number_format($servicio->precio, 0).')',
            'observacion' => "Duración: {$servicio->duracion_min} min. Estado: {$servicio->estado}.".($servicio->imagen ? ' Con foto.' : ''),
        ]);

        return redirect()->route('admin.servicios.index')
            ->with('success', "¡Servicio '{$servicio->nombre}' añadido con éxito al catálogo!");
    }

    /**
     * Actualiza la información de un servicio.
     */
    public function update(Request $request, Servicio $servicio)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'id_categoria' => ['required', 'exists:categorias_servicio,id_categoria'],
            'precio' => ['required', 'numeric', 'min:0'],
            'duracion_min' => ['required', 'integer', 'min:5', 'max:240'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'id_barbero' => ['nullable', 'exists:usuarios,id_usuario'],
            'estado' => ['required', 'in:ACTIVO,INACTIVO'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        if ($request->hasFile('imagen')) {
            if ($servicio->imagen && str_starts_with($servicio->imagen, '/storage/servicios/')) {
                $oldPath = str_replace('/storage/', '', $servicio->imagen);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('imagen')->store('servicios', 'public');
            $validated['imagen'] = '/storage/'.$path;
        }

        $servicio->update($validated);

        // Registro de Auditoría
        Auditoria::create([
            'id_usuario' => Auth::id() ?? 1,
            'accion' => 'ACTUALIZAR_SERVICIO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'servicios',
            'detalle' => "Servicio actualizado: '{$servicio->nombre}'",
            'observacion' => 'Precio: $'.number_format($servicio->precio, 0)." COP. Duración: {$servicio->duracion_min} min.",
        ]);

        return redirect()->route('admin.servicios.index')
            ->with('success', "¡Servicio '{$servicio->nombre}' actualizado correctamente!");
    }

    /**
     * Elimina la foto de un servicio.
     */
    public function eliminarImagen(Servicio $servicio)
    {
        if ($servicio->imagen && str_starts_with($servicio->imagen, '/storage/servicios/')) {
            $oldPath = str_replace('/storage/', '', $servicio->imagen);
            Storage::disk('public')->delete($oldPath);
        }

        $servicio->imagen = null;
        $servicio->save();

        Auditoria::create([
            'id_usuario' => Auth::id() ?? 1,
            'accion' => 'ELIMINAR_FOTO_SERVICIO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'servicios',
            'detalle' => "Foto eliminada del servicio '{$servicio->nombre}'",
            'observacion' => 'El servicio ahora no posee foto personalizada.',
        ]);

        return back()->with('success', "Foto del servicio '{$servicio->nombre}' eliminada con éxito.");
    }

    /**
     * Alterna el estado ACTIVO / INACTIVO de un servicio.
     */
    public function cambiarEstado(Request $request, Servicio $servicio)
    {
        $nuevoEstado = $servicio->estado === 'ACTIVO' ? 'INACTIVO' : 'ACTIVO';
        $servicio->estado = $nuevoEstado;
        $servicio->save();

        Auditoria::create([
            'id_usuario' => Auth::id() ?? 1,
            'accion' => 'ESTADO_SERVICIO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'servicios',
            'detalle' => "Estado de servicio '{$servicio->nombre}' modificado a {$nuevoEstado}",
            'observacion' => 'Visibilidad en reservas modificada por el administrador.',
        ]);

        return back()->with('success', "El servicio '{$servicio->nombre}' ahora está {$nuevoEstado}.");
    }

    /**
     * Crea una nueva categoría de servicios.
     */
    public function storeCategoria(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:categorias_servicio,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        $categoria = Categoria::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'estado' => 'ACTIVO',
        ]);

        Auditoria::create([
            'id_usuario' => Auth::id() ?? 1,
            'accion' => 'CREAR_CATEGORIA',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'categorias_servicio',
            'detalle' => "Categoría creada: '{$categoria->nombre}'",
            'observacion' => 'Agrupación para el catálogo de servicios.',
        ]);

        return back()->with('success', "¡Categoría '{$categoria->nombre}' creada exitosamente!");
    }
}
