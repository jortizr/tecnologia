<div class="py-6">
    <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Lista de modelos") }}
            </h2>
            <x-badge-title :count="$this->deviceModels->total()" />
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->deviceModels">
            <x-slot name="toolbar">
                <div class="w-full sm:flex-1 sm:max-w-md">
                    <x-wireui-input
                        wire:model.live.debounce.500ms="search"
                        icon="magnifying-glass"
                        placeholder="Buscar modelo..."
                        class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                    />
                </div>
                <div class="w-full sm:w-48">
                    @if($canManage)
                        <x-wireui-button
                            label="Nuevo modelo"
                            icon="plus"
                            wire:click="create" {{-- Mejor llamar al método create del controlador --}}
                            primary
                            class="w-full sm:w-auto sm:px-6 sm:ml-2"
                        />
                    @endif
                </div>
            </x-slot>
            <x-slot name="headers">
                <tr class="text-custom-dark-bg dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4">Modelo</th>
                    <th class="px-6 py-4">Marca</th>
                    <th class="px-6 py-4">Creado por</th>
                    <th class="px-6 py-4">Actualizado por</th>
                    @if($canManage)
                    <th class="px-6 py-4">Acciones</th>
                    @endif
                </tr>
            </x-slot>
            <x-slot name="dataTBody" lazy>
                @foreach($this->deviceModels as $deviceModel)
                <tr class="border-b border-gray-700" wire:key="model-{{ $deviceModel->id }}">
                    <td class="px-4 py-2">{{ $deviceModel->name}}</td>
                    <td class="px-4 py-2">{{ $deviceModel->brand?->name ?? 'sin marca' }}</td>
                    <td class="px-4 py-2 text-center">{{ $deviceModel->creator?->name ?? 'sin movimiento' }}</td>
                    <td class="px-4 py-2 text-center">{{ $deviceModel->updater?->name ?? 'sin actualizacion' }}</td>
                    @if($canManage)
                    <td class="px-4 py-2 text-center align-middle">
                        <div class="flex justify-center items-center gap-2">
                        <x-wireui-button xs circle secondary icon="pencil" wire:click="edit({{ $deviceModel->id }})" />
                        <x-wireui-button xs circle negative
                                icon="trash"
                                x-on:confirm="{
                                    title: '¿Estás seguro?',
                                    description: 'Esta acción eliminará la marca permanentemente.',
                                    icon: 'question',
                                    accept: {
                                        label: 'Sí, eliminar',
                                        method: 'delete',
                                        params: {{ $deviceModel->id }}
                                    }
                                }"
                            />
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
                @if($this->deviceModels->isEmpty())
                <tr>
                    <td colspan="5" class="py-12">
                        <div class="flex flex-col items-center justify-center text-secondary-500">
                            <x-wireui-icon name="face-frown" class="w-12 h-12 mb-2 outline-none" />
                            <p class="text-lg font-semibold">No se encontraron modelos
                            <p>
                            <p class="text-sm">Intenta con otros términos de búsqueda.
                            <p>
                        </div>
                    </td>
                </tr>
                @endif
            </x-slot>
        </x-data-table>

        <x-wireui-modal-card title="{{ $isEditing ? 'Editar Marca' : 'Nueva Marca' }}" name="deviceModelModal"
            wire:model.defer="deviceModelModal">
            <div class="grid grid-cols-1 gap-4">
                <x-wireui-input label="Nombre del Modelo" placeholder="Ej. Samsung, Apple..." wire:model.defer="name"
                    class="uppercase" />

                <x-wireui-select label="Seleccionar Marca" placeholder="Busca la marca" wire:model.defer="brand_id"
                    :options="$this->brands" option-label="name" option-value="id" />
            </div>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-wireui-button flat label="Cancelar" x-on:click="$wire.deviceModelModal = false" />
                <x-wireui-button primary label="Guardar" wire:click="store" wire:loading.attr="disabled" />
            </x-slot>
        </x-wireui-modal-card>
    </div>
</div>
