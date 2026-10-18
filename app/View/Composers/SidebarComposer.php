<?php

namespace App\View\Composers;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the sidebar view, keeping database queries out of the Blade template.
     */
    public function compose(View $view): void
    {
        /** @var Usuario|null $user */
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $hoy = Carbon::today()->toDateString();

        if ($user->esAdmin()) {
            // Métricas exclusivas para la barra de navegación del Administrador
            $view->with([
                'adminCitasPendientes' => Cita::where('estado', 'PENDIENTE')->count(),
                'adminTurnosEnEspera' => Turno::whereDate('fecha', $hoy)->where('estado', 'EN_ESPERA')->count(),
                'adminBarberosCount' => Usuario::where('id_rol', Usuario::ROL_BARBERO)->activos()->count(),
                'adminServiciosCount' => Servicio::where('estado', 'ACTIVO')->count(),
                'adminClientesCount' => Usuario::where('id_rol', Usuario::ROL_CLIENTE)->count(),
            ]);
        } elseif ($user->esBarbero()) {
            // Métricas exclusivas para la barra de navegación del Barbero
            $view->with([
                'misServiciosCount' => Servicio::where('id_barbero', $user->id_usuario)->where('estado', 'ACTIVO')->count(),
                'misCitasPendientes' => Cita::where('id_barbero', $user->id_usuario)->where('estado', 'PENDIENTE')->count(),
                'misTurnosEnEspera' => Turno::whereHas('cita', function ($q) use ($user) {
                    $q->where('id_barbero', $user->id_usuario);
                })->whereDate('fecha', $hoy)->where('estado', 'EN_ESPERA')->count(),
            ]);
        }
    }
}
