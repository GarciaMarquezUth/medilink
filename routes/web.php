<?php

use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
use App\Livewire\Admin\MedicosIndex;
// 🔌 Importamos el nuevo componente aquí arriba
use App\Livewire\Admin\DisponibilidadIndex;
>>>>>>> Stashed changes

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
<<<<<<< Updated upstream
=======
    
    // 🩺 Catálogo de Médicos
    Route::get('admin/medicos', MedicosIndex::class)->name('admin.medicos');

    // 📅 Nueva Gestión de Disponibilidad Horaria
    Route::get('admin/disponibilidad', DisponibilidadIndex::class)->name('admin.disponibilidad');
>>>>>>> Stashed changes
});

require __DIR__.'/settings.php';
