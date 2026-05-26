<?php

use App\Http\Controllers\Admin\PatientController;

// Rutas protegidas para administradores y recepcionistas
Route::middleware(['auth', 'role:admin,receptionist'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
    // CRUD completo de Pacientes
    Route::resource('patients', PatientController::class);
    
    // Ruta adicional para búsqueda AJAX
    Route::get('/api/search-patients', [PatientController::class, 'search'])
        ->name('api.search-patients');
});