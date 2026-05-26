<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,receptionist']);
    }

    /**
     * Mostrar listado de pacientes.
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        // Búsqueda por texto
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo de sangre
        if ($request->filled('blood_type')) {
            $query->where('blood_type', $request->blood_type);
        }

        $patients = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        return view('admin.patients.index', compact('patients', 'bloodTypes'));
    }

    /**
     * Mostrar formulario para crear paciente.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Guardar nuevo paciente.
     */
    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create($request->validated());

        return redirect()
            ->route('admin.patients.show', $patient)
            ->with('success', '¡Paciente creado exitosamente!');
    }

    /**
     * Mostrar detalles del paciente.
     */
    public function show(Patient $patient)
    {
        $patient->load(['appointments' => function ($query) {
            $query->with(['doctor', 'service'])
                  ->orderBy('date', 'desc')
                  ->limit(10);
        }]);

        // Estadísticas del paciente
        $stats = [
            'total_appointments' => $patient->appointments()->count(),
            'completed_appointments' => $patient->appointments()->where('status', 'attended')->count(),
            'upcoming_appointments' => $patient->appointments()
                ->where('date', '>=', now())
                ->whereIn('status', ['scheduled', 'confirmed'])
                ->count(),
            'cancelled_appointments' => $patient->appointments()->where('status', 'cancelled')->count(),
        ];

        return view('admin.patients.show', compact('patient', 'stats'));
    }

    /**
     * Mostrar formulario para editar paciente.
     */
    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Actualizar paciente.
     */
    public function update(StorePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()
            ->route('admin.patients.show', $patient)
            ->with('success', '¡Paciente actualizado exitosamente!');
    }

    /**
     * Eliminar paciente.
     */
    public function destroy(Patient $patient)
    {
        // Verificar si tiene citas activas
        if ($patient->appointments()->whereIn('status', ['scheduled', 'confirmed'])->exists()) {
            return back()->withErrors([
                'error' => 'No se puede eliminar un paciente con citas activas. Por favor, cancele las citas pendientes primero.'
            ]);
        }

        $patient->delete();

        return redirect()
            ->route('admin.patients.index')
            ->with('success', '¡Paciente eliminado exitosamente!');
    }

    /**
     * Buscar pacientes para búsqueda AJAX.
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $patients = Patient::where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->limit(10)
            ->get()
            ->map(function ($patient) {
                return [
                    'id' => $patient->id,
                    'text' => $patient->full_name . ' (' . $patient->email . ')',
                    'full_name' => $patient->full_name,
                    'email' => $patient->email,
                    'phone' => $patient->phone,
                ];
            });

        return response()->json($patients);
    }
}
