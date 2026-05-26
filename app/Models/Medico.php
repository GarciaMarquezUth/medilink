<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
<<<<<<< Updated upstream
    public function disponibilidades() { return $this->hasMany(Disponibilidad::class); }
    public function citas() { return $this->hasMany(Cita::class); }
}
=======
    // Corregimos el plural automático que Laravel busca en la base de datos
    protected $table = 'medicos';

    // 🔓 CAMPOS ACTUALIZADOS: Agregamos 'apellido' y 'email' para que MySQL los reciba
    protected $fillable = [
        'nombre', 
        'apellido', 
        'especialidad', 
        'email', 
        'telefono'
    ];

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
>>>>>>> Stashed changes
