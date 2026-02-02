<div class="py-6">
    <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Lista de areas") }}
            </h2>
            <x-badge-title :count="$this->departments->total()" />
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->departments">
            <x-slot name="toolbar">
                <div class="w-full sm:flex-1 sm:max-w-md">
                    <x-wireui-input
                        wire:model.live.debounce.500ms="search"
                        icon="magnifying-glass"
                        placeholder="Buscar area..."
                        class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                    />
                </div>
                <div class="w-full sm:w-48">
                    @if($canManage)
                        <x-wireui-button
                            label="Nueva Area"
                            icon="plus"
                            wire:click="create"
                            primary
                            class="w-full sm:w-auto sm:px-6 sm:ml-2"
                        />
                    @endif
                </div>
            </x-slot>
            <x-slot name="headers">
                <tr class="text-custom-dark-bg dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4">Area</th>
                    <th class="px-6 py-4">Creado por</th>
                    <th class="px-6 py-4">Actualizado por</th>
                    @if($canManage)
                    <th class="px-6 py-4">Acciones</th>
                    @endif
                </tr>
            </x-slot>
            <x-slot name="dataTBody" lazy>
                @foreach($this->departments as $department)
                <tr class="border-b border-gray-700" wire:key="model-{{ $department->id }}">
                    <td class="px-4 py-2">{{ $department->name}}</td>
                    <td class="px-4 py-2 text-center">{{ $department->creator?->name ?? 'sin movimiento' }}</td>
                    <td class="px-4 py-2 text-center">{{ $department->updater?->name ?? 'sin actualizacion' }}</td>
                    @if($canManage)
                    <td class="px-4 py-2 text-center align-middle">
                        <div class="flex justify-center items-center gap-2">
                        <x-wireui-button xs circle secondary icon="pencil" wire:click="edit({{ $department->id }})" />
                        <x-wireui-button
                                    xs
                                    circle
                                    negative
                                    icon="trash"
                                    wire:click="confirmDelete({{ $department->id }})"
                                    wire:loading.attr="disabled"
                        />
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
                @if($this->departments->isEmpty())
                <tr>
                    <td colspan="5" class="py-12">
                        <div class="flex flex-col items-center justify-center text-secondary-500">
                            <x-wireui-icon name="face-frown" class="w-12 h-12 mb-2 outline-none" />
                            <p class="text-lg font-semibold">No se encontro el area
                            <p>
                            <p class="text-sm">Intenta con otros términos de búsqueda.
                            <p>
                        </div>
                    </td>
                </tr>
                @endif
            </x-slot>
        </x-data-table>
        <x-wireui-modal-card title="{{ $isEditing ? 'Editar Area' : 'Nueva Area' }}" name="departmentModal"
            wire:model.defer="departmentModal">
            <div class="grid grid-cols-1 gap-4">
                <x-wireui-input label="Nombre del area" placeholder="Ej. gestion humana, gerencia..." wire:model.defer="name"
                    class="uppercase" />
            </div>
            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-wireui-button flat label="Cancelar" x-on:click="$wire.departmentModal = false" />
                <x-wireui-button primary label="Guardar" wire:click="store" wire:loading.attr="disabled" />
            </x-slot>
        </x-wireui-modal-card>
    </div>
</div>
