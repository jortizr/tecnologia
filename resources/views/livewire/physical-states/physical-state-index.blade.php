<div class="py-6">
    <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Lista de estados fisicos") }}
            </h2>
            <x-badge-title :count="$this->physicalStates->total()" />
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->physicalStates">
            <x-slot name="toolbar">
                <div class="w-full sm:flex-1 sm:max-w-md">
                    <x-wireui-input
                        wire:model.live.debounce.500ms="search"
                        icon="magnifying-glass"
                        placeholder="Buscar estado fisico..."
                        class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                    />
                </div>
                <div class="w-full sm:w-48">
                    @can('dashboard.physicalstates.create')
                        <x-wireui-button
                            label="Nueva Estado"
                            icon="plus"
                            wire:click="create"
                            primary
                            class="w-full sm:w-auto sm:px-6 sm:ml-2"
                        />
                    @endcan
                </div>
            </x-slot>
            <x-slot name="headers">
                <tr class="text-custom-dark-bg dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4">Estado</th>
                    <th class="px-6 py-4">Descripción</th>
                    <th class="px-6 py-4">Creado por</th>
                    <th class="px-6 py-4">Actualizado por</th>
                    @can('dashboard.physicalstates.update')
                    <th class="px-6 py-4">Acciones</th>
                    @endcan
                </tr>
            </x-slot>
            <x-slot name="dataTBody" lazy>
                @foreach($this->physicalStates as $physicalState)
                <tr class="border-b border-gray-700" wire:key="model-{{ $physicalState->id }}">
                    <td class="px-4 py-2">{{ $physicalState->name}}</td>
                    <td class="px-4 py-2">{{ $physicalState->description}}</td>
                    <td class="px-4 py-2 text-center">{{ $physicalState->creator?->name ?? 'sin movimiento' }}</td>
                    <td class="px-4 py-2 text-center">{{ $physicalState->updater?->name ?? 'sin actualizacion' }}</td>
                    @can('dashboard.physicalstates.update')
                    <td class="px-4 py-2 text-center align-middle">
                        <div class="flex justify-center items-center gap-2">
                        <x-wireui-button xs circle secondary icon="pencil" wire:click="edit({{ $physicalState->id }})" />
                        <x-wireui-button
                                    xs
                                    circle
                                    negative
                                    icon="trash"
                                    wire:click="confirmDelete({{ $physicalState->id }})"
                                    wire:loading.attr="disabled"
                        />
                        </div>
                    </td>
                    @endcan
                </tr>
                @endforeach
                @if($this->physicalStates->isEmpty())
                <tr>
                    <td colspan="5" class="py-12">
                        <div class="flex flex-col items-center justify-center text-secondary-500">
                            <x-wireui-icon name="face-frown" class="w-12 h-12 mb-2 outline-none" />
                            <p class="text-lg font-semibold">No se encontró ningun estado fisico
                            <p>
                            <p class="text-sm">Intenta con otros términos de búsqueda o crear un estado.
                            <p>
                        </div>
                    </td>
                </tr>
                @endif
            </x-slot>
        </x-data-table>
        @can('dashboard.physicalstates.create')
        <x-wireui-modal-card title="{{ $isEditing ? 'Editar Estado Fisico' : 'Nueva Estado Fisico' }}" name="physicalStateModal"
            wire:model.defer="physicalStateModal">
            <div class="grid grid-cols-1 gap-4">
                <x-wireui-input label="Nombre del estado fisico" placeholder="Ej. averiado, fisurado..." wire:model.defer="name" class="uppercase" />
                <x-wireui-input label="descripción del estado" placeholder="Ej. referencia del nombre..." wire:model.defer="description" class="uppercase" />
            </div>
            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-wireui-button flat label="Cancelar" x-on:click="$wire.physicalStateModal = false" />
                <x-wireui-button primary label="Guardar" wire:click="save" wire:loading.attr="disabled" />
            </x-slot>
        </x-wireui-modal-card>
        @endcan
    </div>
</div>
