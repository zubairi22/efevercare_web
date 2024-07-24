<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\MenusController;
use App\Http\Controllers\Master\RolesController;
use App\Http\Controllers\Master\UsersController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\PatientController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::name('master.')->prefix('master')->group(function () {
        Route::resource('users', UsersController::class);
        Route::resource('menus', MenusController::class);
        Route::resource('roles', RolesController::class);
    });

    Route::get('patient' , [PatientController::class, 'index'])->name('patient.index');
    Route::patch('patient/{user}' , [PatientController::class, 'update'])->name('patient.update');

    Route::get('monitor/{user}' , [MonitorController::class, 'index'])->name('monitor.index');
    Route::get('monitor/{chat}', [MonitorController::class, 'show'])->name('monitor.show');
    Route::post('monitor/{chat}/messages', [MonitorController::class, 'storeMessage'])->name('monitor.messages.store');
});
