<div class="p-6 bg-white rounded-xl shadow-sm dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800">
    <div class="flex flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white tracking-tight">Catálogo de Médicos</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Administra el personal médico de la clínica, especialidades y datos de contacto.</p>
        </div>
        <button wire:click="openCreateModal" 
                style="background-color: #2563eb !important; color: white !important; width: auto !important;" 
                class="px-4 py-2 text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 active:bg-blue-800 transition duration-150 flex items-center gap-2 cursor-pointer whitespace-nowrap">
            <span style="font-size: 1.15rem; line-height: 1; font-weight: bold;">+</span>
            <span>Registrar Médico</span>
        </button>
    </div>

    <div class="mb-6">
        <div class="relative w-full md:w-1/3">
            <input wire:model.live="search" type="text" placeholder="Buscar por nombre, apellido o especialidad..." class="w-full px-4 py-2 text-sm border border-zinc-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
        </div>
    </div>

    <div class="overflow-x-auto border border-zinc-200 dark:border-zinc-800 rounded-xl">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
            <thead class="bg-zinc-50/70 dark:bg-zinc-800/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Nombre Completo</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Especialidad</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Teléfono</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-36">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-900 dark:divide-zinc-800">
                @forelse($medicos as $medico)
                    <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-zinc-900 dark:text-white">{{ $medico->nombre }} {{ $medico->apellido }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                            <span class="px-2 py-1 text-xs font-medium bg-zinc-100 dark:bg-zinc-800 rounded-md text-zinc-800 dark:text-zinc-300">
                                {{ $medico->especialidad }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400 font-mono">{{ $medico->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $medico->telefono ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center items-center gap-2">
                                <button wire:click="edit({{ $medico->id }})" 
                                        style="background-color: #e0f2fe !important; color: #0369a1 !important;" 
                                        class="px-3 py-1 text-xs font-bold rounded-full hover:bg-sky-200 transition duration-150 shadow-sm cursor-pointer">
                                    Editar
                                </button>
                                
                                <button type="button"
                                        onclick="confirm('¿Estás seguro de que deseas eliminar al médico {{ $medico->nombre }} {{ $medico->apellido }}? Esta acción no se puede deshacer.') ? @this.delete({{ $medico->id }}) : null"
                                        style="background-color: #fee2e2 !important; color: #b91c1c !important;" 
                                        class="px-3 py-1 text-xs font-bold rounded-full hover:bg-red-200 transition duration-150 shadow-sm cursor-pointer">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-zinc-400 dark:text-zinc-500">
                            No se encontraron médicos registrados en el sistema.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $medicos->links() }}
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-950/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-4">
                    {{ $medicoId ? 'Modificar Médico' : 'Registrar Nuevo Médico' }}
                </h3>
                
                <form wire:submit.prevent="save" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1">Nombre</label>
                            <input type="text" wire:model="nombre" class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('nombre') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1">Apellido</label>
                            <input type="text" wire:model="apellido" class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('apellido') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1">Especialidad</label>
                        <input type="text" wire:model="especialidad" class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('especialidad') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1">Correo Electrónico</label>
                        <input type="email" wire:model="email" class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1">Teléfono</label>
                        <input type="text" wire:model="telefono" class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('telefono') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-2 pt-4 border-t border-zinc-100 dark:border-zinc-800 mt-6">
                        <button type="button" wire:click="$set('isModalOpen', false)" class="px-4 py-2 text-sm font-semibold text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition cursor-pointer">
                            Cancelar
                        </button>
                        <button type="submit" style="background-color: #2563eb !important; color: white !important; display: inline-block !important;" class="px-4 py-2 text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition cursor-pointer">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>