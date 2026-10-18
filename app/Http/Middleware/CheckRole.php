<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     * @param  string|int  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var Usuario $user */
        $user = Auth::user();

        // Roles permitidos pasados como argumentos (ej: '1', '2', o 'admin', 'barbero')
        $allowedRoleIds = [];
        foreach ($roles as $role) {
            if (is_numeric($role)) {
                $allowedRoleIds[] = (int) $role;
            } elseif (in_array(strtolower((string) $role), ['admin', 'administrador'], true)) {
                $allowedRoleIds[] = Usuario::ROL_ADMIN;
            } elseif (strtolower((string) $role) === 'barbero') {
                $allowedRoleIds[] = Usuario::ROL_BARBERO;
            } elseif (strtolower((string) $role) === 'cliente') {
                $allowedRoleIds[] = Usuario::ROL_CLIENTE;
            }
        }

        if (! in_array((int) $user->id_rol, $allowedRoleIds, true)) {
            // Si no tiene el rol, redirigir a su propio dashboard según su rol
            if ($user->esAdmin()) {
                return redirect()->route('admin.dashboard1')->with('error', 'No tienes permisos para acceder a esa sección.');
            }

            if ($user->esBarbero()) {
                return redirect()->route('barbero.dashboard2')->with('error', 'No tienes permisos para acceder a esa sección.');
            }

            return redirect()->route('cliente.dashboard3')->with('error', 'No tienes permisos para acceder a esa sección.');
        }

        return $next($request);
    }
}
