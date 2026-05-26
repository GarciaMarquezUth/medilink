<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Medico;
use Livewire\WithPagination;

class MedicosIndex extends Component
{
    use WithPagination;

    // Propiedades que se conectan con los inputs del formulario modal
    public $medicoId;
    public $nombre;
    public $especialidad;
    public $telefono;

    // Propiedades para la búsqueda y control del Modal
    public $search = '';
    public $isModalOpen = false;

    // Reglas de validación para el formulario
    protected $rules = [
        'nombre' => 'required|string|min:3|max:100',
        'especialidad' => 'required|string|min:3|max:100',
        'telefono' => 'nullable|string|max:20',
    ];

    // Resetea la paginación cada vez que el usuario escribe en el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Renderiza la vista apuntando correctamente a la carpeta components/admin
    public function render()
    {
        // CORREGIDO: Apunta a components.admin para que encuentre tu archivo HTML
        return view('components.admin.medicos-index', [
            'medicos' => Medico::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('especialidad', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'desc')
                ->paginate(10)
        ]);
    }

    // Abre el modal limpio para registrar un nuevo médico
    public function openCreateModal()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }

    // Guarda o actualiza un registro en la base de datos
    public function save()
    {
        $this->validate();

        Medico::updateOrCreate(
            ['id' => $this->medicoId],
            [
                'nombre' => $this->nombre,
                'especialidad' => $this->especialidad,
                'telefono' => $this->telefono,
            ]
        );

        $this->isModalOpen = false;
        $this->resetFields();
        
        session()->flash('message', $this->medicoId ? 'Médico actualizado con éxito.' : 'Médico registrado con éxito.');
    }

    // Carga los datos del médico seleccionado en el formulario y abre el modal
    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        $this->medicoId = $medico->id;
        $this->nombre = $medico->nombre;
        $this->especialidad = $medico->especialidad;
        $this->telefono = $medico->telefono;

        $this->isModalOpen = true;
    }

    // Elimina un médico de la base de datos
    public function delete($id)
    {
        Medico::findOrFail($id)->delete();
        session()->flash('message', 'Médico eliminado correctamente.');
    }

    // Limpia los campos del formulario para que no se queden ciclados
    private function resetFields()
    {
        $this->medicoId = null;
        $this->nombre = '';
        $this->especialidad = '';
        $this->telefono = '';
    }
}