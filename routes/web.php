<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ActivationController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/resend-activation', [ActivationController::class, 'resend'])->name('activation.resend');

// Rutas de autenticación generadas por Breeze
Route::get('/', function () {
    return view('welcome');
});

// Ruta de activación de cuenta
Route::get('/activate-account/{id}', function ($id) {
    $user = User::findOrFail($id);

    // Verifica si el usuario ya está activado
    if ($user->is_active) {
        return redirect('/login')->with('status', 'Account is already activated.');
    }

    // Activa la cuenta
    $user->is_active = true;
    $user->save();

    return redirect('/login')->with('status', 'Account activated! You can now log in.');
})->name('activation.verify')->middleware('signed');

// Rutas de perfil (ejemplo de protección de ruta para usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas protegidas por roles
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:User'])->group(function () {
    Route::get('/user', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Rutas de autenticación generadas por Laravel Breeze
require __DIR__.'/auth.php';
