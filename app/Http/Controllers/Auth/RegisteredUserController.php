<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ActivateAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Maneja una solicitud de registro de usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validación del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Crear el usuario con la cuenta inactiva
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => false,
        ]);

        // Genera la URL de activación con expiración de 5 minutos
        $activationUrl = URL::temporarySignedRoute(
            'activation.verify',
            now()->addMinutes(5),
            ['id' => $user->id]
        );

        // Enviar el correo de activación
        $user->notify(new ActivateAccount($activationUrl));

        // Inicia sesión automáticamente al usuario recién registrado
        Auth::login($user);

        // Redirige al usuario a la página de espera de activación
        return redirect()->route('activation.wait')->with('status', 'Please activate your account by clicking the link sent to your email.');
    }
}
