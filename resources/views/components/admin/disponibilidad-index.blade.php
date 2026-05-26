<div class="p-6 bg-white rounded-xl shadow-sm dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-zinc-900 dark:text-white tracking-tight">Gestión de Disponibilidad</h2>
        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Asigna y administra los días y rangos de horario en los que los médicos atienden citas.</p>
    </div>

    @if (!empty($successMessage))
        <div class="mb-6 p-3 bg-emerald-50 text-emerald-800 text-sm font-medium rounded-lg dark:bg-emerald-950/50 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-900/50">
            {{ $successMessage }}
        </div>
    @endif

    <div class="mb-8 p-4 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-200 dark:border-zinc-700">
        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-2">Selecciona un Médico para gestionar su horario:</label>
        <select wire:model.live="medico_id" class="w-full md:w-1/2 px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Elige un médico de la lista --</option>
            @foreach($medicos as $medico)
                <option value="{{ $medico->id }}">{{ $medico->nombre }} {{ $medico->apellido }} ({{ $medico->especialidad }})</option>
            @endforeach
        </select>
        @error('medico_id') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
    </div>

    @if($medico_id)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm h-fit">
                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 mb-4 uppercase tracking-wider">Asignar Nuevo Horario</h3>
                
                <form wire:submit.prevent="save" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1">Día Laboral</label>
                        <select wire:model="dia_semana" class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Selecciona Día --</option>
                            <option value="1">Lunes</option>
                            <option value="2">Martes</option>
                            <option value="3">Miércoles</option>
                            <option value="4">Jueves</option>
                            <option value="5">Viernes</option>
                            <option value="6">Sábado</option>
                            <option value="7">Domingo</option>
                        </select>
                        @error('dia_semana') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1">Hora de Entrada</label>
                        <input type="time" wire:model="hora_inicio" class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('hora_inicio') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 mb-1">Hora de Salida</label>
                        <input type="time" wire:model="hora_fin" class="w-full px-3 py-2 text-sm border border-zinc-300 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('hora_fin') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" style="background-color: #2563eb !important; color: white !important; display: block !important;" class="w-full px-4 py-2 text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition cursor-pointer text-center">
                            Agregar a la Agenda
                        </button>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-2">
                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 mb-4 uppercase tracking-wider">Agenda de Horarios Activos</h3>

                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden shadow-sm">
                    <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($horarios as $horario)
                            <div class="p-4 flex items-center justify-between hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition duration-150">
                                <div class="flex items-center space-x-4">
                                    <span class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300 rounded-lg min-w-[100px] text-center">
                                        {{ $diasTexto[$horario->dia_semana] }}
                                    </span>
                                    <div class="text-sm text-zinc-700 dark:text-zinc-300 font-medium flex items-center gap-2">
                                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }}</span>
                                        <span class="text-zinc-400 dark:text-zinc-600">a</span>
                                        <span>{{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}</span>
                                    </div>
                                </div>

                                <button type="button" 
                                        onclick="confirm('¿Remover este bloque de horario?') ? @this.delete({{ $horario->id }}) : null"
                                        style="background-color: #fee2e2 !important; color: #b91c1c !important;" 
                                        class="px-3 py-1 text-xs font-bold rounded-full hover:bg-red-200 transition duration-150 shadow-sm cursor-pointer">
                                    Remover
                                </button>
                            </div>
                        @empty
                            <div class="p-8 text-center text-sm text-zinc-400 dark:text-zinc-500">
                                <svg class="w-8 h-8 mx-auto mb-2 text-zinc-300 dark:text-zinc-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                Este médico no tiene horarios de atención configurados todavía.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="p-12 text-center border border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl text-zinc-400 dark:text-zinc-500">
            Por favor, selecciona un médico arriba para empezar a registrar o visualizar su agenda semanal.
        </div>
    @endif
</div>