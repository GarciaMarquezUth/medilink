<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    public function paciente() { return $this->belongsTo(Paciente::class); }
    public function medico() { return $this->belongsTo(Medico::class); }
    public function servicio() { return $this->belongsTo(Servicio::class); }
}
