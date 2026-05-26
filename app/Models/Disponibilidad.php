<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    // 🔒 Forzamos a Laravel a usar el nombre en español de tu migración
    protected $table = 'disponibilidades';

    // 📝 Permitimos la escritura masiva de estos campos desde Livewire
    protected $fillable = [
        'medico_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin'
    ];

    /**
     * Relación inversa: Una disponibilidad le pertenece a un único médico.
     */
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }
}