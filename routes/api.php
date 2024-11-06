<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\ProfileController;
use App\Models\User;

/*Rutas de autenticación generadas por Breeze
Route::get('/', function () {
    return view('welcome');
});

// Ruta de activación de cuenta con enlace firmado
Route::get('/activate-account/{id}', [ActivationController::class, 'activate'])
    ->name('activation.verify')
    ->middleware('signed');

// Ruta para reenviar el correo de activación
Route::get('/resend-activation', [ActivationController::class, 'resend'])
    ->name('activation.resend')
    ->middleware('auth');

// Rutas de perfil para usuarios autenticados
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
require __DIR__.'/auth.php';*/
