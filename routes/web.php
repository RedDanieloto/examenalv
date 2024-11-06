<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Registro de usuario
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Ruta para esperar activación
Route::get('/activation/wait', function () {
    return view('auth.activation-wait');
})->name('activation.wait')->middleware('auth');

// Ruta para reenviar el correo de activación
Route::post('/activation/resend', [ActivationController::class, 'resend'])
    ->name('activation.resend')
    ->middleware('auth');

// Ruta para activar la cuenta
Route::get('/activation/verify/{id}', [ActivationController::class, 'activate'])
    ->name('activation.verify');

// Rutas de autenticación
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Ruta de dashboard (protegida por autenticación y verificación)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
