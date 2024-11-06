<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ActivateAccount;
use App\Notifications\UserActivated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    /**
     * Activar la cuenta del usuario a través del enlace de activación.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Verifica si la cuenta ya está activada
        if ($user->is_active) {
            return redirect()->route('login')->with('status', 'Your account is already activated.');
        }

        // Activa la cuenta del usuario
        $user->is_active = true;
        $user->save();

        // Notificar al administrador que el usuario ha activado su cuenta
        $admin = User::where('role', 'Administrador')->first();
        if ($admin) {
            $admin->notify(new UserActivated($user));
        }

        return redirect()->route('login')->with('status', 'Your account has been activated! You can now log in.');
    }

    /**
     * Reenviar el enlace de activación al usuario.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        $user = Auth::user();

        // Verifica si la cuenta ya está activada
        if ($user->is_active) {
            return redirect()->route('dashboard')->with('status', 'Your account is already activated.');
        }

        // Reenviar el enlace de activación
        $user->notify(new ActivateAccount());

        return back()->with('status', 'Activation link resent to your email.');
    }
}
