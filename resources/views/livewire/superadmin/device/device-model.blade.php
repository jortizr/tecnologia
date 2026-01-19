<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ __("Lista de modelos") }}
            </h2>
            @if($canManage)
                <x-wireui-button label="Nuevo modelo" icon="plus" x-on:click="$openModal('deviceModelModal')" class="mr-2"  primary />
            @endif
        </div>
    </x-slot>

    <x-data-table :data="$this->deviceModels">
        <x-section-title>
            <x-slot name="title">Lista de modelos</x-slot>
            <x-slot name="description">Administración de los modelos de dispositivos</x-slot>
        </x-section-title>

        <x-slot name="headers">
            <tr class="bg-gray-800 text-gray-100">
                <th class="px-4 py-2">Modelo</th>
                <th class="px-4 py-2">Marca</th>
                <th class="px-4 py-2">Creado por</th>
                <th class="px-4 py-2">Actualizado por</th>
                @if($canManage)
                <th class="px-4 py-2">Acciones</th>
                @endif
            </tr>
        </x-slot>

        <x-slot name="dataTBody" lazy >
            @foreach($this->deviceModels as $deviceModel)
                <tr class="border-b border-gray-700" wire:key="model-{{ $deviceModel->id }}">
                    <td class="px-4 py-2">{{ $deviceModel->name}}</td>
                    <td class="px-4 py-2">{{ $deviceModel->brand?->name ?? 'sin marca' }}</td>
                    <td class="px-4 py-2 text-center">{{ $deviceModel->creator?->name ?? 'sin movimiento' }}</td>
                    <td class="px-4 py-2 text-center">{{ $deviceModel->updater?->name ?? 'sin actualizacion' }}</td>
                    @if($canManage)
                        <td class="px-4 py-2 flex gap-2 justify-center">
                            <x-wireui-button
                                xs
                                circle
                                primary
                                icon="pencil"
                                wire:click="edit({{ $deviceModel->id }})"
                            />
                            <x-wireui-button
                                xs circle negative icon="trash"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50"
                                x-on:click="$confirm({
                                    title: '¿Eliminar modelo?',
                                    description: 'Esta acción no se puede deshacer',
                                    icon: 'error',
                                    accept: {
                                        label: 'Sí, eliminar',
                                        method: 'delete',
                                        params: {{ $deviceModel->id }}
                                    }
                                })"
                            />
                        </td>
                    @endif
                </tr>
            @endforeach
            @if($this->deviceModels->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">
                        <x-heroicon-m-face-frown class="h-10 w-auto text-gray-500"/>
                        <strong>No hay modelos registrados</strong>
                    </td>
                </tr>
            @endif
        </x-slot>
    </x-data-table>

    <x-wireui-modal-card title="{{ $isEditing ? 'Editar Marca' : 'Nueva Marca' }}" name="deviceModelModal" wire:model.defer="deviceModelModal">
        <div class="grid grid-cols-1 gap-4">
            <x-wireui-input
                label="Nombre del Modelo"
                placeholder="Ej. Samsung, Apple..."
                wire:model.defer="name"
                class="uppercase"
            />

            <x-wireui-select
                label="Seleccionar Marca"
                placeholder="Busca la marca"
                wire:model.defer="brand_id"
                :options="$this->brands"
                option-label="name"
                option-value="id"
            />
        </div>

        <x-slot name="footer" class="flex justify-end gap-x-4">
            <x-wireui-button flat label="Cancelar" x-on:click="$wire.deviceModelModal = false"/>
            <x-wireui-button primary label="Guardar" wire:click="save" wire:loading.attr="disabled" />
        </x-slot>
    </x-wireui-modal-card>
</div>
