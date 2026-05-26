<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\MedicosIndex;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    // REVISA ESTA LÍNEA: Que no tenga un "/" extra al principio, debe ser 'admin/medicos'
    Route::get('admin/medicos', MedicosIndex::class)->name('admin.medicos');
});

require __DIR__.'/settings.php';