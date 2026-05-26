<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="rounded-md bg-green-50 p-4 mb-6 border border-green-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Encabezado --}}
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center mb-2">
                        <a href="{{ route('admin.patients.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Volver al listado de pacientes
                        </a>
                    </div>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ $patient->full_name }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Paciente registrado el {{ $patient->created_at->format('d \d\e F \d\e Y') }} 
                        a las {{ $patient->created_at->format('H:i') }}
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('admin.patients.edit', $patient) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar Paciente
                    </a>
                    <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" 
                          onsubmit="return confirm('¿Está seguro de que desea eliminar a {{ $patient->full_name }}?\n\nEsta acción es permanente y no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar Paciente
                        </button>
                    </form>
                </div>
            </div>

            {{-- Tarjetas de Estadísticas --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                {{-- Total Citas --}}
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total de Citas
                                    </dt>
                                    <dd class="text-2xl font-semibold text-gray-900">
                                        {{ $stats['total_appointments'] }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Citas Completadas --}}
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Citas Completadas
                                    </dt>
                                    <dd class="text-2xl font-semibold text-green-600">
                                        {{ $stats['completed_appointments'] }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Próximas Citas --}}
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Próximas Citas
                                    </dt>
                                    <dd class="text-2xl font-semibold text-blue-600">
                                        {{ $stats['upcoming_appointments'] }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Citas Canceladas --}}
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Citas Canceladas
                                    </dt>
                                    <dd class="text-2xl font-semibold text-red-600">
                                        {{ $stats['cancelled_appointments'] }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contenido Principal --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Columna Izquierda: Información --}}
                <div class="lg:col-span-1 space-y-6">
                    
                    {{-- Datos Personales --}}
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Datos Personales
                            </h3>
                            
                            <dl class="space-y-4">
                                <div class="border-b border-gray-100 pb-3">
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Nombre Completo</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $patient->full_name }}</dd>
                                </div>

                                <div class="border-b border-gray-100 pb-3">
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Correo Electrónico</dt>
                                    <dd class="mt-1 text-sm text-indigo-600">
                                        <a href="mailto:{{ $patient->email }}" class="hover:text-indigo-900">
                                            {{ $patient->email }}
                                        </a>
                                    </dd>
                                </div>

                                <div class="border-b border-gray-100 pb-3">
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Teléfono</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $patient->phone ?? 'No registrado' }}
                                    </dd>
                                </div>

                                <div class="border-b border-gray-100 pb-3">
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Fecha de Nacimiento</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($patient->date_of_birth)
                                            {{ $patient->date_of_birth->format('d \d\e F \d\e Y') }}
                                            <span class="text-gray-500">({{ $patient->age }} años)</span>
                                        @else
                                            No registrada
                                        @endif
                                    </dd>
                                </div>

                                <div class="border-b border-gray-100 pb-3">
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Tipo de Sangre</dt>
                                    <dd class="mt-1">
                                        @if($patient->blood_type)
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ $patient->blood_type }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400">No registrado</span>
                                        @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Dirección</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $patient->address ?? 'No registrada' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Contacto de Emergencia --}}
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Contacto de Emergencia
                            </h3>
                            
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Nombre del Contacto</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $patient->emergency_contact_name ?? 'No registrado' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Teléfono del Contacto</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $patient->emergency_contact_phone ?? 'No registrado' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Seguro Médico --}}
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Seguro Médico
                            </h3>
                            
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Aseguradora</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $patient->insurance_provider ?? 'No registrada' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Número de Póliza</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $patient->insurance_number ?? 'No registrado' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Info Médica y Citas --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Información Médica --}}
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                                Información Médica
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Alergias</h4>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                                        <p class="text-sm text-yellow-800">
                                            {{ $patient->allergies ?? 'Sin alergias conocidas' }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Notas e Historial Médico</h4>
                                    <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                                        <p class="text-sm text-gray-700 whitespace-pre-line">
                                            {{ $patient->medical_notes ?? 'Sin notas médicas registradas' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Citas Recientes --}}
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Historial de Citas Recientes
                            </h3>
                            
                            @if($patient->appointments->count() > 0)
                                <div class="space-y-4">
                                    @foreach($patient->appointments as $appointment)
                                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors duration-150">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center flex-wrap gap-2">
                                                        <span class="text-sm font-semibold text-gray-900">
                                                            {{ $appointment->date->format('d/m/Y') }}
                                                        </span>
                                                        <span class="text-gray-300 hidden sm:inline">|</span>
                                                        <span class="text-sm text-gray-600">
                                                            {{ $appointment->start_time->format('H:i') }} - {{ $appointment->end_time->format('H:i') }}
                                                        </span>
                                                    </div>
                                                    <div class="mt-1">
                                                        <p class="text-sm text-gray-600">
                                                            <span class="font-medium">Doctor:</span> Dr. {{ $appointment->doctor->full_name }}
                                                        </p>
                                                        <p class="text-sm text-gray-600">
                                                            <span class="font-medium">Servicio:</span> {{ $appointment->service->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    @php
                                                        $statusLabels = [
                                                            'scheduled' => 'Programada',
                                                            'confirmed' => 'Confirmada',
                                                            'attended' => 'Atendida',
                                                            'cancelled' => 'Cancelada',
                                                            'no_show' => 'No Asistió'
                                                        ];
                                                    @endphp
                                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        bg-{{ $appointment->status->color() }}-100 
                                                        text-{{ $appointment->status->color() }}-800">
                                                        {{ $statusLabels[$appointment->status->value] ?? $appointment->status->label() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sin citas registradas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Este paciente aún no tiene historial de citas.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>