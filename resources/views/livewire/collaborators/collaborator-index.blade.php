<div class="py-6">
    <div class="flex justify-center items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Lista de colaboradores") }}
        </h2>
        <x-badge-title :count="$this->collaborators->total()" />
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->collaborators">
            <x-slot name="toolbar">
                <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
                    <div class="w-full sm:flex-1 sm:max-w-md">
                        <x-wireui-input
                            wire:model.live.debounce.500ms="search"
                            icon="magnifying-glass"
                            placeholder="Buscar colaborador por nombre, codigo..."
                            class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                        />
                    </div>

                    <div class="flex w-full sm:w-auto justify-end gap-2">
                        @can('dashboard.collaborators.import.show')
                            <x-wireui-button
                                label="Importar datos"
                                icon="arrow-up-tray"
                                wire:click="$set('importModal', true)"
                                secondary
                                class="w-full sm:w-auto"
                            />

                            <x-wireui-button
                                label="Agregar Colaborador"
                                icon="plus"
                                wire:click="create"
                                primary
                                class="w-full sm:w-auto"
                            />
                        @endcan
                    </div>

                </div>
            </x-slot>

            <x-slot name="headers">
                <tr class="text-custom-dark-bg dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4">Nombres y Apellidos</th>
                    <th class="px-6 py-4">Identificacion</th>
                    <th class="px-6 py-4">Codigo de nomina</th>
                    <th class="px-6 py-4">Area</th>
                    <th class="px-6 py-4">Cargo</th>
                    <th class="px-6 py-4">Regional</th>
                    <th class="px-6 py-4">Estado</th>
                    @can('dashboard.collaborators.update')
                    <th class="px-6 py-4">Acciones</th>
                    @endcan
                </tr>
            </x-slot>
            <x-slot name="dataTBody">
                @forelse($this->collaborators as $collaborator)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors duration-200" wire:key="collaborator-{{ $collaborator->id }}">
                        <td class="px-4 py-2">
                            <span class="font-bold text-gray-900 dark:text-gray-100">{{ $collaborator->names}} {{$collaborator->last_name}}</span>
                        </td>
                        <td class="px-4 py-2">{{ $collaborator->identification }}</td>
                        <td class="px-4 py-2">{{ $collaborator->payroll_code }}</td>
                        <td class="px-4 py-2">{{ $collaborator->department?->name ?? 'Sin area' }}</td>
                        <td class="px-4 py-2">{{ $collaborator->occupation?->name ?? 'Sin cargo' }}</td>
                        <td class="px-4 py-2">{{ $collaborator->regional?->name ?? 'Sin regional' }}</td>
                        <td class="px-4 py-2">
                        <x-wireui-toggle
                            positive
                            wire:key="collaborator-status-{{ $collaborator->id }}-{{(int) $collaborator->is_active }}"
                            :checked="$collaborator->is_active"
                            x-on:click="$dispatch('toggleStatus', { collaboratorId: {{ $collaborator->id }} })"
                            wire:loading.attr="disabled"
                            wire:target="toggleStatus"
                        />
                        </td>
                        @can('dashboard.collaborators.update')
                        <td class="px-4 py-2 text-center align-middle">
                            <div class="flex justify-center items-center gap-2">
                                <x-wireui-button xs circle secondary icon="pencil" wire:click="edit({{ $collaborator->id }})" />
                                <x-wireui-button
                                    xs
                                    circle
                                    negative
                                    icon="trash"
                                    wire:click="confirmDelete({{ $collaborator->id }})"
                                    wire:loading.attr="disabled"
                                />
                            </div>
                        </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-500">
                            <x-wireui-icon name="users" class="w-12 h-12 mx-auto mb-2 opacity-20" />
                            <p>No se encontraron colaboradores que coincidan.</p>
                        </td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>
        @can('dashboard.collaborators.update')
        <x-wireui-modal-card title="{{ $isEditing ? 'Editar Colaborador':'Nuevo Colaborador' }}" wire:model.defer="collaboratorModal">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-wireui-input label="Nombres" wire:model.defer="names" />
                <x-wireui-input label="Apellidos" wire:model.defer="last_name"/>
                <x-wireui-input label="Identificacion" wire:model.defer="identification"/>
                <x-wireui-input label="Cod. Nomina" wire:model.defer="payroll_code"/>
                <x-wireui-select
                    label="Asignar Area"
                    placeholder="Selecciona una area"
                    wire:model.defer="department_id"
                    :options="$this->departments"
                    option-label="name"
                    option-value="id"
                />
                <x-wireui-select
                    label="Asignar Cargo"
                    placeholder="Selecciona un cargo"
                    wire:model.defer="occupation_id"
                    :options="$this->occupations"
                    option-label="name"
                    option-value="id"
                />
                <x-wireui-select
                    label="Asignar Regional"
                    placeholder="Selecciona una regional"
                    wire:model.defer="regional_id"
                    :options="$this->regionals"
                    option-label="name"
                    option-value="id"
                />
                <div class="flex items-center pt-6">
                    <x-wireui-toggle label="¿Está activo?" lg wire:model.defer="is_active" />
                </div>
            </div>
            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-wireui-button flat label="Cancelar" x-on:click="$wire.collaboratorModal = false"/>
                <x-wireui-button primary label="Guardar Colaborador" wire:click="save" spinner="save" />
            </x-slot>
        </x-wireui-modal-card>
        @endcan
        @can('dashboard.collaborators.import.show')
        <x-wireui-modal-card title="Importar Colaboradores" wire:model.defer="importModal" max-width="4xl" x-on:close="$wire.dispatch('import-finished')">
            <livewire:collaborators.collaborator-import wire:key="import-comp-{{ $importModal ? 'open' : 'closed' }}" />

            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-wireui-button flat label="Cerrar" x-on:click="close" />
                </div>
            </x-slot>
        </x-wireui-modal-card>
        @endcan
    </div>
</div>
