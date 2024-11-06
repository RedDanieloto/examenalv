<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ActivateAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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

        if ($user->is_active) {
            return redirect()->route('login')->with('status', 'Your account is already activated.');
        }

        $user->is_active = true;
        $user->save();

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

        if (!$user) {
            return redirect()->route('login')->with('status', 'Please log in to resend the activation link.');
        }

        if ($user->is_active) {
            return redirect()->route('dashboard')->with('status', 'Your account is already activated.');
        }

        $activationUrl = URL::temporarySignedRoute(
            'activation.verify',
            now()->addMinutes(5),
            ['id' => $user->id]
        );

        $user->notify(new ActivateAccount($activationUrl));

        return redirect()->route('activation.wait')->with('status', 'A new verification link has been sent to your email address.');
    }
}
