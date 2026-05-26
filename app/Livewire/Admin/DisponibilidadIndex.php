<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Medico;
use App\Models\Disponibilidad;
use Livewire\WithPagination;

class DisponibilidadIndex extends Component
{
    use WithPagination;

    // Variables de selección y formulario
    public $medico_id = '';
    public $dia_semana = '';
    public $hora_inicio = '';
    public $hora_fin = '';

    public $successMessage = '';

    protected function rules()
    {
        return [
            'medico_id' => 'required|exists:medicos,id',
            'dia_semana' => 'required|in:1,2,3,4,5,6,7',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ];
    }

    public function save()
    {
        $this->validate();

        // Guardamos el horario en la base de datos
        Disponibilidad::create([
            'medico_id'   => $this->medico_id,
            'dia_semana'  => $this->dia_semana,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin'    => $this->hora_fin,
        ]);

        // Limpiamos campos del formulario
        $this->dia_semana = '';
        $this->hora_inicio = '';
        $this->hora_fin = '';

        $this->successMessage = 'Horario de disponibilidad asignado correctamente.';
    }

    public function delete($id)
    {
        Disponibilidad::findOrFail($id)->delete();
        $this->successMessage = 'Horario eliminado correctamente.';
    }

    public function render()
    {
        // Diccionario para traducir los números del enum a texto en la vista
        $diasTexto = [
            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles',
            4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'
        ];

        // Traemos todos los médicos para el select
        $medicos = Medico::orderBy('nombre')->get();

        // Traemos los horarios del médico seleccionado
        $horarios = [];
        if ($this->medico_id) {
            $horarios = Disponibilidad::where('medico_id', $this->medico_id)
                ->orderBy('dia_semana')
                ->orderBy('hora_inicio')
                ->get();
        }

        // 🛠️ Corregido para que busque el archivo en components/admin/
        return view('components.admin.disponibilidad-index', [
            'medicos'   => $medicos,
            'horarios'  => $horarios,
            'diasTexto' => $diasTexto
        ]);
    }
}