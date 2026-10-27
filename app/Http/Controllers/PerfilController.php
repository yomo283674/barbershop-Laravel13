<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    /**
     * Actualiza la foto de perfil del usuario autenticado.
     */
    public function actualizarFoto(Request $request)
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
        ], [
            'foto.required' => 'Debes seleccionar una imagen.',
            'foto.image' => 'El archivo debe ser una imagen válida.',
            'foto.mimes' => 'Formatos permitidos: JPG, PNG, WEBP o GIF.',
            'foto.max' => 'La imagen no debe pesar más de 5MB.',
        ]);

        /** @var Usuario $user */
        $user = Auth::user();

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si estaba en storage/avatars
            if ($user->foto_perfil && str_starts_with($user->foto_perfil, '/storage/avatars/')) {
                $oldPath = str_replace('/storage/', '', $user->foto_perfil);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('foto')->store('avatars', 'public');
            $user->foto_perfil = '/storage/'.$path;
            $user->save();

            return back()->with('¡Foto de perfil actualizada con éxito!');
        }

        return back()->with('No se pudo procesar la imagen seleccionada.');
    }

    /**
     * Elimina la foto de perfil y vuelve al avatar por defecto (inicial).
     */
    public function eliminarFoto()
    {
        /** @var Usuario $user */
        $user = Auth::user();

        if ($user->foto_perfil) {
            if (str_starts_with($user->foto_perfil, '/storage/avatars/')) {
                $oldPath = str_replace('/storage/', '', $user->foto_perfil);
                Storage::disk('public')->delete($oldPath);
            }

            $user->foto_perfil = null;
            $user->save();

            return back()->with('Foto de perfil eliminada correctamente.');
        }

        return back()->with('No tienes una foto personalizada configurada.');
    }

    /**
     * Actualiza datos de contacto básicos del perfil.
     */
    public function actualizar(Request $request)
    {
        /** @var Usuario $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
        ]);

        $user->nombre = $validated['nombre'];
        $user->telefono = $validated['telefono'] ?? null;
        $user->save();

        return back()->with('¡Información de perfil actualizada!');
    }
}
