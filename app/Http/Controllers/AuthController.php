<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuarios,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'terms' => ['accepted'],
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->first_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->phone,
            'id_rol' => Usuario::ROL_CLIENTE,
            'estado' => 'ACTIVO',
        ]);

        Auth::login($usuario);

        // Redirigir de vuelta al registro para mostrar la alerta
        return back()->with('¡Tu cuenta ha sido creada exitosamente!');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var Usuario $user */
            $user = Auth::user();

            // Redirigir dependiendo del rol del usuario
            if ($user->esAdmin()) {
                return redirect()->intended('/administrador/dashboard1');
            }

            if ($user->esBarbero()) {
                return redirect()->intended('/barbero/dashboard2');
            }

            return redirect()->intended('/cliente/dashboard3');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
