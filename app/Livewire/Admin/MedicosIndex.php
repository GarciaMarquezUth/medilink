<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Medico;
use Livewire\WithPagination;

class MedicosIndex extends Component
{
    use WithPagination;

    public $medicoId;
    public $nombre;
    public $apellido;
    public $especialidad;
    public $email;
    public $telefono;

    public $search = '';
    public $isModalOpen = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|min:3|max:100',
            'apellido' => 'required|string|min:3|max:100',
            'especialidad' => 'required|string|min:3|max:100',
            'email' => 'nullable|email|max:150|unique:medicos,email,' . $this->medicoId,
            'telefono' => 'nullable|string|max:20',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('components.admin.medicos-index', [
            'medicos' => Medico::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('apellido', 'like', '%' . $this->search . '%')
                ->orWhere('especialidad', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'desc')
                ->paginate(10)
        ]);
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $esActualizacion = !is_null($this->medicoId);

        Medico::updateOrCreate(
            ['id' => $this->medicoId],
            [
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'especialidad' => $this->especialidad,
                'email' => $this->email,
                'telefono' => $this->telefono,
            ]
        );

        $this->isModalOpen = false;
        $this->resetFields();
        
        // 💾 Guardamos el mensaje en la sesión clásica de Laravel
        $mensaje = $esActualizacion ? 'Médico actualizado correctamente.' : 'Médico creado correctamente.';
        session()->flash('message', $mensaje);
    }

    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        $this->medicoId = $medico->id;
        $this->nombre = $medico->nombre;
        $this->apellido = $medico->apellido;
        $this->especialidad = $medico->especialidad;
        $this->email = $medico->email;
        $this->telefono = $medico->telefono;

        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        Medico::findOrFail($id)->delete();
        session()->flash('message', 'Médico eliminado correctamente.');
    }

    private function resetFields()
    {
        $this->medicoId = null;
        $this->nombre = '';
        $this->apellido = '';
        $this->especialidad = '';
        $this->email = '';
        $this->telefono = '';
    }
}