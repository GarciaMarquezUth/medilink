<?php

use App\Http\Controllers\Admin\ServiceController;

// Rutas protegidas para administradores y recepcionistas
Route::middleware(['auth', 'role:admin,receptionist'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
    // CRUD completo de Servicios
    Route::resource('services', ServiceController::class);
});