<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ __("Lista de marcas") }}
            </h2>
            @if($canManage)
                <x-wireui-button primary label="Nueva Marca" icon="plus" wire:click="create" />
            @endif
        </div>
    </x-slot>

    <x-data-table :data="$brands">
        <x-section-title>
            <x-slot name="title">Lista de fabricantes</x-slot>
            <x-slot name="description">Administración de marcas de dispositivos</x-slot>
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
            @foreach($brands as $brand)
                <tr class="border-b border-gray-700" wire:key="brand-{{ $brand->id }}">
                    <td class="px-4 py-2">{{ $brand->name}}</td>
                    <td class="px-4 py-2 text-center">{{ $brand->creator?->name ?? 'sin movimiento' }}</td>
                    <td class="px-4 py-2 text-center">{{ $brand->updater?->name ?? 'sin actualizacion' }}</td>
                    @if($canManage)
                        <td class="px-4 py-2 flex gap-2 justify-center">
                            <x-wireui-button
                                xs
                                circle
                                primary
                                icon="pencil"
                                wire:click="edit({{ $brand->id }})"
                            />
                            <x-wireui-button
                                xs
                                circle
                                negative
                                icon="trash"
                                x-on:click="$wireui.confirmDialog({
                                    title: '¿Estás seguro?',
                                    description: 'Eliminarás el fabricante permanentemente.',
                                    icon: 'error',
                                    accept: {
                                        label: 'Sí, eliminar',
                                        params: {{ $brand->id }},
                                        execute: (id) => $wire.delete(id)
                                    },
                                    reject: {
                                        label: 'Cancelar',
                                        style: 'flat'
                                    }
                                })"
                            />
                        </td>
                    @endif
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>

    <x-wireui-modal-card title="{{ $isEditing ? 'Editar Marca' : 'Nueva Marca' }}" name="brandModal" wire:model.defer="brandModal">
        <div class="grid grid-cols-1 gap-4">
            <x-wireui-input
                label="Nombre de la Marca"
                placeholder="Ej. Samsung, Apple..."
                wire:model.defer="name"
            />
        </div>

        <x-slot name="footer" class="flex justify-end gap-x-4">
            <x-wireui-button flat label="Cancelar" x-on:click="close" />
            <x-wireui-button primary label="Guardar" wire:click="save" wire:loading.attr="disabled" />
        </x-slot>
    </x-wireui-modal-card>
</div>
