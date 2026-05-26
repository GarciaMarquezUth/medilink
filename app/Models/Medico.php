<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    // Corregimos el plural automático que Laravel busca en la base de datos
    protected $table = 'medicos';

    // Campos que se pueden llenar desde el formulario
    protected $fillable = ['nombre', 'especialidad', 'telefono'];

    /**
     * Relación: Un médico tiene muchos bloques de disponibilidad semanal.
     */
    public function disponibilidades()
    {
        return $this->hasMany(Disponibilidad::class, 'medico_id');
    }

    /**
     * Relación: Un médico tiene muchas citas agendadas.
     */
    public function citas()
    {
        return $this->hasMany(Cita::class, 'medico_id');
    }
}