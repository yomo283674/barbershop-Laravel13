<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Categoria;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarberoServicioController extends Controller
{
    /**
     * Muestra el catálogo de servicios personalizados ofrecidos por el barbero autenticado.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Servicio::with('categoria')
            ->where('id_barbero', $user->id_usuario)
            ->where('estado', '!=', 'ELIMINADO');

        // Búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria') && $request->categoria !== 'TODAS') {
            $query->where('id_categoria', $request->categoria);
        }

        // Filtro por estado
        if ($request->filled('estado') && $request->estado !== 'TODOS') {
            $query->where('estado', $request->estado);
        }

        $servicios = $query->orderBy('nombre', 'asc')->get();

        // Métricas personales del catálogo
        $totalServicios = $servicios->count();
        $serviciosActivos = $servicios->where('estado', 'ACTIVO')->count();
        $precioPromedio = round($servicios->where('estado', 'ACTIVO')->avg('precio') ?? 0, 0);
        $duracionPromedio = round($servicios->where('estado', 'ACTIVO')->avg('duracion_min') ?? 0, 0);

        // Categorías disponibles
        $categorias = Categoria::orderBy('nombre')->get();

        return view('barbero.servicios.index', compact(
            'servicios',
            'totalServicios',
            'serviciosActivos',
            'precioPromedio',
            'duracionPromedio',
            'categorias'
        ));
    }

    /**
     * Registra un nuevo servicio personalizado en el portafolio del barbero (con soporte de foto del corte).
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'id_categoria' => ['required', 'exists:categorias_servicio,id_categoria'],
            'precio' => ['required', 'numeric', 'min:0'],
            'duracion_min' => ['required', 'integer', 'min:10', 'max:240'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $imagenUrl = null;
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('servicios', 'public');
            $imagenUrl = '/storage/'.$path;
        }

        $servicio = Servicio::create([
            'nombre' => $validated['nombre'],
            'id_categoria' => $validated['id_categoria'],
            'precio' => $validated['precio'],
            'duracion_min' => $validated['duracion_min'],
            'descripcion' => $validated['descripcion'] ?? null,
            'imagen' => $imagenUrl,
            'estado' => 'ACTIVO',
            'id_barbero' => $user->id_usuario, // Asignado exclusivamente a este barbero
        ]);

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'CREACION_SERVICIO_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'servicios',
            'detalle' => "El barbero {$user->nombre} creó el servicio: {$servicio->nombre}",
            'observacion' => "Tarifa: \${$servicio->precio} | Duración: {$servicio->duracion_min} min".($imagenUrl ? ' | Con foto' : ''),
        ]);

        return redirect()->route('barbero.servicios.index')
            ->with('success', "¡Servicio '{$servicio->nombre}' publicado en tu portafolio exitosamente!");
    }

    /**
     * Actualiza la información de un servicio propio (con actualización opcional de foto).
     */
    public function update(Request $request, Servicio $servicio)
    {
        $user = Auth::user();

        // Validar que el servicio pertenezca al barbero autenticado
        if ($servicio->id_barbero != $user->id_usuario) {
            return redirect()->route('barbero.servicios.index')
                ->with('error', 'No tienes permiso para modificar un servicio que no te pertenece.');
        }

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'id_categoria' => ['required', 'exists:categorias_servicio,id_categoria'],
            'precio' => ['required', 'numeric', 'min:0'],
            'duracion_min' => ['required', 'integer', 'min:10', 'max:240'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'estado' => ['required', 'in:ACTIVO,INACTIVO'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existía en storage local
            if ($servicio->imagen && str_starts_with($servicio->imagen, '/storage/servicios/')) {
                $oldPath = str_replace('/storage/', '', $servicio->imagen);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('imagen')->store('servicios', 'public');
            $validated['imagen'] = '/storage/'.$path;
        }

        $servicio->update($validated);

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'EDICION_SERVICIO_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'servicios',
            'detalle' => "El barbero {$user->nombre} actualizó el servicio: {$servicio->nombre}",
            'observacion' => "Tarifa: \${$servicio->precio} | Estado: {$servicio->estado}",
        ]);

        return redirect()->route('barbero.servicios.index')
            ->with('success', "Servicio '{$servicio->nombre}' actualizado con éxito.");
    }

    /**
     * Elimina la foto de un servicio.
     */
    public function eliminarImagen(Servicio $servicio)
    {
        $user = Auth::user();

        if ($servicio->id_barbero != $user->id_usuario) {
            return back()->with('error', 'Acción no permitida.');
        }

        if ($servicio->imagen && str_starts_with($servicio->imagen, '/storage/servicios/')) {
            $oldPath = str_replace('/storage/', '', $servicio->imagen);
            Storage::disk('public')->delete($oldPath);
        }

        $servicio->imagen = null;
        $servicio->save();

        return back()->with('success', 'Foto del servicio eliminada.');
    }

    /**
     * Activa o pausa la disponibilidad de un servicio para reservas de clientes.
     */
    public function cambiarEstado(Request $request, Servicio $servicio)
    {
        $user = Auth::user();

        if ($servicio->id_barbero != $user->id_usuario) {
            return redirect()->route('barbero.servicios.index')
                ->with('error', 'Acción no permitida en servicios ajenos.');
        }

        $nuevoEstado = $servicio->estado === 'ACTIVO' ? 'INACTIVO' : 'ACTIVO';
        $servicio->estado = $nuevoEstado;
        $servicio->save();

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'CAMBIO_ESTADO_SERVICIO_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'servicios',
            'detalle' => "El barbero cambió el estado de {$servicio->nombre} a {$nuevoEstado}",
            'observacion' => null,
        ]);

        $msg = $nuevoEstado === 'ACTIVO' ? 'Servicio activado para recibir reservas de clientes.' : 'Servicio pausado temporalmente.';

        return back()->with('success', $msg);
    }

    /**
     * Elimina lógicamente un servicio del portafolio del barbero.
     */
    public function destroy(Servicio $servicio)
    {
        $user = Auth::user();

        if ($servicio->id_barbero != $user->id_usuario) {
            return redirect()->route('barbero.servicios.index')
                ->with('error', 'Acción no permitida.');
        }

        $servicio->estado = 'ELIMINADO';
        $servicio->save();

        Auditoria::create([
            'id_usuario' => $user->id_usuario,
            'accion' => 'ELIMINACION_SERVICIO_BARBERO',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'servicios',
            'detalle' => "El barbero {$user->nombre} eliminó de su portafolio el servicio {$servicio->nombre}",
            'observacion' => null,
        ]);

        return redirect()->route('barbero.servicios.index')
            ->with('success', 'Servicio retirado de tu portafolio exitosamente.');
    }
}
