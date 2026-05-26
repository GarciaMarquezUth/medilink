<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Encabezado --}}
            <div class="mb-8">
                <div class="flex items-center mb-2">
                    <a href="{{ route('admin.patients.show', $patient) }}" class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Volver a detalles del paciente
                    </a>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Editar Paciente</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Actualice la información de <span class="font-medium">{{ $patient->full_name }}</span>. Los campos marcados con <span class="text-red-500">*</span> son obligatorios.
                </p>
            </div>

            {{-- Formulario --}}
            <form action="{{ route('admin.patients.update', $patient) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                
                <div class="bg-white shadow rounded-lg divide-y divide-gray-200">
                    
                    {{-- Sección 1: Información Personal --}}
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Información Personal</h3>
                        
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            {{-- Nombre --}}
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">
                                    Nombre <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="first_name" id="first_name" 
                                           value="{{ old('first_name', $patient->first_name) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('first_name') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('first_name')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Apellido --}}
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">
                                    Apellido <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="last_name" id="last_name" 
                                           value="{{ old('last_name', $patient->last_name) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('last_name') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('last_name')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Correo Electrónico --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email', $patient->email) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('email') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Teléfono
                                </label>
                                <div class="mt-1">
                                    <input type="tel" name="phone" id="phone" 
                                           value="{{ old('phone', $patient->phone) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('phone') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Fecha de Nacimiento --}}
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">
                                    Fecha de Nacimiento
                                </label>
                                <div class="mt-1">
                                    <input type="date" name="date_of_birth" id="date_of_birth" 
                                           value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}"
                                           max="{{ now()->format('Y-m-d') }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('date_of_birth') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('date_of_birth')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Tipo de Sangre --}}
                            <div>
                                <label for="blood_type" class="block text-sm font-medium text-gray-700">
                                    Tipo de Sangre
                                </label>
                                <div class="mt-1">
                                    <select name="blood_type" id="blood_type" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                   @error('blood_type') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                        <option value="">Seleccione el tipo de sangre</option>
                                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                            <option value="{{ $type }}" {{ old('blood_type', $patient->blood_type) == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('blood_type')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección 2: Dirección --}}
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Dirección</h3>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">
                                Dirección Completa
                            </label>
                            <div class="mt-1">
                                <textarea name="address" id="address" rows="3" 
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                 @error('address') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('address', $patient->address) }}</textarea>
                            </div>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">
                                    <span class="font-medium">Error:</span> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Sección 3: Contacto de Emergencia --}}
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Contacto de Emergencia</h3>
                        
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">
                                    Nombre Completo del Contacto
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="emergency_contact_name" id="emergency_contact_name" 
                                           value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('emergency_contact_name') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('emergency_contact_name')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">
                                    Teléfono del Contacto
                                </label>
                                <div class="mt-1">
                                    <input type="tel" name="emergency_contact_phone" id="emergency_contact_phone" 
                                           value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('emergency_contact_phone') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('emergency_contact_phone')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección 4: Seguro Médico --}}
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Información del Seguro Médico</h3>
                        
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div>
                                <label for="insurance_provider" class="block text-sm font-medium text-gray-700">
                                    Aseguradora
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="insurance_provider" id="insurance_provider" 
                                           value="{{ old('insurance_provider', $patient->insurance_provider) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('insurance_provider') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('insurance_provider')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="insurance_number" class="block text-sm font-medium text-gray-700">
                                    Número de Póliza
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="insurance_number" id="insurance_number" 
                                           value="{{ old('insurance_number', $patient->insurance_number) }}"
                                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                  @error('insurance_number') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                </div>
                                @error('insurance_number')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección 5: Información Médica --}}
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Información Médica</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="allergies" class="block text-sm font-medium text-gray-700">
                                    Alergias Conocidas
                                </label>
                                <div class="mt-1">
                                    <textarea name="allergies" id="allergies" rows="2" 
                                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                     @error('allergies') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('allergies', $patient->allergies) }}</textarea>
                                </div>
                                @error('allergies')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="medical_notes" class="block text-sm font-medium text-gray-700">
                                    Notas e Historial Médico
                                </label>
                                <div class="mt-1">
                                    <textarea name="medical_notes" id="medical_notes" rows="4" 
                                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                     @error('medical_notes') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('medical_notes', $patient->medical_notes) }}</textarea>
                                </div>
                                @error('medical_notes')
                                    <p class="mt-2 text-sm text-red-600">
                                        <span class="font-medium">Error:</span> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="px-4 py-4 sm:px-6 bg-gray-50 rounded-b-lg">
                        <div class="flex justify-between items-center">
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
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.patients.show', $patient) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancelar
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Actualizar Paciente
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>