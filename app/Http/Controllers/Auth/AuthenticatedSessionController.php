<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
    // Validación del formulario de inicio de sesión
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Intento de autenticación
    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();

        // Verifica si el usuario está activo directamente
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('activation.wait')->with('status', 'Por favor activa tu cuenta antes de iniciar sesión.');
        }

        return redirect()->intended('dashboard');
    }

    // Si la autenticación falla, lanza una excepción
    throw ValidationException::withMessages([
        'email' => __('Las credenciales proporcionadas no coinciden con nuestros registros.'),
    ]);
}

    /**
     * Cierra la sesión del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
