<div class="py-6">
    <div class="flex justify-center items-center" x-data x-on:model-updated.window="$wire.$refresh()">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Lista de marcas") }}
        </h2>
        <x-badge-title :count="$this->brands->total()" />
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->brands">
            <x-slot name="toolbar">
                <div class="w-full sm:flex-1 sm:max-w-md">
                    <x-wireui-input
                        wire:model.live.debounce.500ms="search"
                        icon="magnifying-glass"
                        placeholder="Buscar marcas..."
                        class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                    />
                </div>
                    @can('dashboard.brands.create')
                        <x-wireui-button
                            label="Nueva Marca"
                            icon="plus"
                            wire:click="create"
                            primary
                            class="w-full sm:w-auto sm:px-6 sm:ml-2"
                        />
                    @endcan
            </x-slot>

            <x-slot name="headers">
                <tr class="text-custom-dark-bg dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4 text-left">Nombre</th>
                    <th class="px-6 py-4 text-center">Creado por</th>
                    <th class="px-6 py-4 text-center">Actualizado por</th>
                    @can('dashboard.departments.update')
                    <th class="px-6 py-4 text-center">Acciones</th>
                    @endcan
                </tr>
            </x-slot>

            <x-slot name="dataTBody" lazy >
                @foreach($this->brands as $brand)
                    <tr class="border-b border-gray-700" wire:key="brand-{{ $brand->id }}">
                        <td class="px-4 py-2">{{ $brand->name}}</td>
                        <td class="px-4 py-2 text-center">{{ $brand->creator?->name ?? 'sin movimiento' }}</td>
                        <td class="px-4 py-2 text-center">{{ $brand->updater?->name ?? 'sin actualizacion' }}</td>
                        @can('dashboard.brands.update')
                            <td class="px-4 py-2 flex gap-2 justify-center">
                                <x-wireui-button
                                    xs
                                    circle
                                    secondary
                                    icon="pencil"
                                    wire:click="edit({{ $brand->id }})"
                                />
                                <x-wireui-button
                                    xs
                                    circle
                                    negative
                                    icon="trash"
                                    wire:click="confirmDelete({{ $brand->id }})"
                                    wire:loading.attr="disabled"
                                />
                            </td>
                        @endcan
                    </tr>
                @endforeach
                @if($this->brands->isEmpty())
                <tr>
                    <td colspan="5" class="py-12">
                        <div class="flex flex-col items-center justify-center text-secondary-500">
                            <x-wireui-icon name="face-frown" class="w-12 h-12 mb-2 outline-none" />
                            <p class="text-lg font-semibold">No se encontro la marca
                            <p>
                            <p class="text-sm">Intenta con otros términos de búsqueda.
                            <p>
                        </div>
                    </td>
                </tr>
                @endif
            </x-slot>
        </x-data-table>
        @can('dashboard.brands.create')
        <x-wireui-modal-card title="{{ $isEditing ? 'Editar Marca' : 'Nueva Marca' }}" name="brandModal" wire:model.defer="brandModal">
            <div class="grid grid-cols-1 gap-4">
                <x-wireui-input
                    label="Nombre de la Marca"
                    placeholder="Ej. Samsung, Apple..."
                    wire:model.defer="name"
                />
            </div>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-wireui-button flat label="Cancelar" x-on:click="$wire.brandModal = false"/>
                <x-wireui-button primary label="Guardar" wire:click="store" wire:loading.attr="disabled" />
            </x-slot>
        </x-wireui-modal-card>
        @endcan
    </div>
</div>
