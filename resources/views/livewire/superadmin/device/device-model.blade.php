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
                <th class="px-4 py-2">Nombre</th>
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
                    <td class="px-4 py-2">{{ $deviceModel->brand_id->name}}</td>
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
                                xs
                                circle
                                negative
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
                        </td>
                    @endif
                </tr>

            @endforeach
            @if($this->deviceModels->isEmpty())
                <tr>
                    <td colspan="4" class="text center">
                        <strong>No hay modelos registrados</strong>
                    </td>
                </tr>
            @endif
        </x-slot>
    </x-data-table>

    <x-wireui-modal-card title="{{ $isEditing ? 'Editar Marca' : 'Nueva Marca' }}" name="deviceModelModal" wire:model.defer="deviceModelModal">
        <div class="grid grid-cols-1 gap-4">
            <x-wireui-input
                label="Nombre de la Marca"
                placeholder="Ej. Samsung, Apple..."
                wire:model.defer="name"
            />
        </div>

        <x-slot name="footer" class="flex justify-end gap-x-4">
            <x-wireui-button flat label="Cancelar" x-on:click="$wire.deviceModelModal = false"/>
            <x-wireui-button primary label="Guardar" wire:click="save" wire:loading.attr="disabled" />
        </x-slot>
    </x-wireui-modal-card>
</div>
