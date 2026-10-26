<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Configuracion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminConfiguracionController extends Controller
{
    /**
     * Muestra la pantalla de configuración global del sistema y reglas de negocio.
     */
    public function index()
    {
        $config = Configuracion::with('administrador')->first();

        if (! $config) {
            $admin = Usuario::where('id_rol', Usuario::ROL_ADMIN)->first();
            $adminId = $admin ? $admin->id_usuario : (Auth::id() ?? 1);

            $config = Configuracion::create([
                'nombre_negocio' => 'Barbershop Premium Studio',
                'horario_apertura' => '08:00:00',
                'horario_cierre' => '20:00:00',
                'duracion_cita_min' => 45,
                'tiempo_cancelacion_min' => 60,
                'tiempo_reprogramacion_min' => 60,
                'tiempo_notificacion_min' => 15,
                'id_administrador_actualizacion' => $adminId,
                'fecha_actualizacion' => now(),
            ]);
        }

        return view('administrador.configuracion.index', compact('config'));
    }

    /**
     * Actualiza los parámetros de negocio y configuración del sistema.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nombre_negocio' => ['required', 'string', 'max:255'],
            'horario_apertura' => ['required', 'date_format:H:i:s,H:i'],
            'horario_cierre' => ['required', 'date_format:H:i:s,H:i'],
            'duracion_cita_min' => ['required', 'integer', 'min:15', 'max:180'],
            'tiempo_cancelacion_min' => ['required', 'integer', 'min:0', 'max:1440'],
            'tiempo_reprogramacion_min' => ['required', 'integer', 'min:0', 'max:1440'],
            'tiempo_notificacion_min' => ['required', 'integer', 'min:0', 'max:1440'],
        ]);

        $adminId = Auth::id() ?? 1;

        $config = Configuracion::first();
        if ($config) {
            $config->update(array_merge($validated, [
                'id_administrador_actualizacion' => $adminId,
                'fecha_actualizacion' => now(),
            ]));
        } else {
            $config = Configuracion::create(array_merge($validated, [
                'id_administrador_actualizacion' => $adminId,
                'fecha_actualizacion' => now(),
            ]));
        }

        // Registrar en Auditoría
        Auditoria::create([
            'id_usuario' => $adminId,
            'accion' => 'ACTUALIZAR_CONFIGURACION',
            'resultado' => 'EXITO',
            'entidad_afectada' => 'configuracion_sistema',
            'detalle' => 'Parámetros del negocio actualizados por '.(Auth::user()->nombre ?? 'Administrador'),
            'observacion' => "Horarios: {$config->horario_apertura} - {$config->horario_cierre}. Citas: {$config->duracion_cita_min} min. Cancelación: {$config->tiempo_cancelacion_min} min.",
        ]);

        return redirect()->route('admin.configuracion.index')
            ->with('¡Configuración del sistema y reglas de negocio actualizadas con éxito!');
    }
}
