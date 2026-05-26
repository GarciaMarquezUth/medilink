<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Encabezado --}}
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Pacientes
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Gestionar todos los registros de pacientes del sistema
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.patients.create') }}" 
                       class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Nuevo Paciente
                    </a>
                </div>
            </div>

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
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none">
                                    <span class="sr-only">Cerrar</span>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Mensaje de error --}}
            @if($errors->any())
                <div class="rounded-md bg-red-50 p-4 mb-6 border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron los siguientes errores:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Búsqueda y Filtros --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('admin.patients.index') }}" method="GET">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            {{-- Buscador --}}
                            <div class="sm:col-span-2">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                                    Buscar Paciente
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                           placeholder="Buscar por nombre, correo electrónico o teléfono...">
                                </div>
                            </div>

                            {{-- Filtro tipo de sangre --}}
                            <div>
                                <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tipo de Sangre
                                </label>
                                <select name="blood_type" id="blood_type" 
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Todos los tipos</option>
                                    @foreach($bloodTypes as $type)
                                        <option value="{{ $type }}" {{ request('blood_type') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="mt-4 flex items-center justify-end space-x-3">
                            @if(request()->anyFilled(['search', 'blood_type']))
                                <a href="{{ route('admin.patients.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Limpiar Filtros
                                </a>
                            @endif
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Aplicar Filtros
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Resultados y contador --}}
            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    Mostrando <span class="font-medium">{{ $patients->firstItem() ?? 0 }}</span> 
                    a <span class="font-medium">{{ $patients->lastItem() ?? 0 }}</span> 
                    de <span class="font-medium">{{ $patients->total() }}</span> pacientes
                </p>
            </div>

            {{-- Tabla de Pacientes --}}
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paciente
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Información de Contacto
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tipo de Sangre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Edad
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Seguro Médico
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha de Registro
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($patients as $patient)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    {{-- Columna Paciente --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <span class="text-indigo-600 font-medium text-sm">
                                                        {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('admin.patients.show', $patient) }}" class="hover:text-indigo-600">
                                                        {{ $patient->full_name }}
                                                    </a>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    ID: #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Columna Contacto --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <a href="mailto:{{ $patient->email }}" class="hover:text-indigo-600">
                                                {{ $patient->email }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $patient->phone ?? 'Sin teléfono registrado' }}
                                        </div>
                                    </td>

                                    {{-- Columna Tipo de Sangre --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($patient->blood_type)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ $patient->blood_type }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400">No registrado</span>
                                        @endif
                                    </td>

                                    {{-- Columna Edad --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $patient->age ? $patient->age . ' años' : 'No registrada' }}
                                    </td>

                                    {{-- Columna Seguro --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($patient->insurance_provider)
                                            <div class="text-sm text-gray-900">{{ $patient->insurance_provider }}</div>
                                            <div class="text-sm text-gray-500">Póliza: {{ $patient->insurance_number }}</div>
                                        @else
                                            <span class="text-sm text-gray-400">Sin seguro médico</span>
                                        @endif
                                    </td>

                                    {{-- Columna Fecha Registro --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $patient->created_at->format('d/m/Y') }}
                                        <div class="text-xs text-gray-400">
                                            {{ $patient->created_at->format('H:i') }}
                                        </div>
                                    </td>

                                    {{-- Columna Acciones --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex space-x-2 justify-end">
                                            {{-- Botón Ver --}}
                                            <a href="{{ route('admin.patients.show', $patient) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 p-1.5 rounded-full hover:bg-indigo-50 transition-colors" 
                                               title="Ver detalles del paciente">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            
                                            {{-- Botón Editar --}}
                                            <a href="{{ route('admin.patients.edit', $patient) }}" 
                                               class="text-green-600 hover:text-green-900 p-1.5 rounded-full hover:bg-green-50 transition-colors" 
                                               title="Editar información del paciente">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            
                                            {{-- Botón Eliminar --}}
                                            <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Está seguro de que desea eliminar a {{ $patient->full_name }}?\n\nEsta acción no se puede deshacer y se eliminará todo el historial del paciente.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 p-1.5 rounded-full hover:bg-red-50 transition-colors" 
                                                        title="Eliminar paciente">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                                            @if(request()->anyFilled(['search', 'blood_type']))
                                                No se encontraron pacientes con los filtros aplicados
                                            @else
                                                No hay pacientes registrados
                                            @endif
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            @if(request()->anyFilled(['search', 'blood_type']))
                                                Intente con diferentes criterios de búsqueda o limpie los filtros.
                                            @else
                                                Comience registrando el primer paciente en el sistema.
                                            @endif
                                        </p>
                                        @if(!request()->anyFilled(['search', 'blood_type']))
                                            <div class="mt-6">
                                                <a href="{{ route('admin.patients.create') }}" 
                                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                    Registrar Primer Paciente
                                                </a>
                                            </div>
                                        @else
                                            <div class="mt-6">
                                                <a href="{{ route('admin.patients.index') }}" 
                                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Limpiar Filtros
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Paginación --}}
                @if($patients->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Página {{ $patients->currentPage() }} de {{ $patients->lastPage() }}
                            </div>
                            {{ $patients->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>