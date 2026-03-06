<div class="py-6">
    <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Lista de Dispositivos") }}
            </h2>
            <x-badge-title :count="$this->devices->total()" />
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->devices">
            <x-slot name="toolbar">
                <div class="w-full sm:flex-1 sm:max-w-md">
                    <x-wireui-input
                        wire:model.live.debounce.500ms="search"
                        icon="magnifying-glass"
                        placeholder="Buscar imei o linea..."
                        class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                    />
                </div>
                <div class="w-full sm:w-48">
                    @can('dashboard.devices.create')
                        <x-wireui-button
                            label="Nuevo dispositivo"
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
                    <th class="px-6 py-4">Tipo Dispositivo</th>
                    <th class="px-6 py-4">Modelo</th>
                    <th class="px-6 py-4">Serial</th>
                    <th class="px-6 py-4">Imei</th>
                    <th class="px-6 py-4">Ubicacion</th>
                    <th class="px-6 py-4">Estado Operativo</th>
                    <th class="px-6 py-4">Estado Fisico</th>
                    <th class="px-6 py-4">Fecha de adquisición</th>
                    <th class="px-6 py-4">Creado por</th>
                    <th class="px-6 py-4">Actualizado por</th>
                    @can('dashboard.devicemodels.update')
                    <th class="px-6 py-4">Acciones</th>
                    @endcan
                </tr>
            </x-slot>
            <x-slot name="dataTBody" lazy>
                @foreach($this->devices as $device)
                <tr class="border-b border-gray-700" wire:key="model-{{ $device->id }}">
                    <td class="px-4 py-2">{{ $device->deviceModel->deviceType->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $device->deviceModel->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $device->serial_number ?? 'sin numero de serie'}}</td>
                    <td class="px-4 py-2">{{ $device->imei ?? 'sin imei' }}</td>
                    <td class="px-4 py-2">{{ $device->location?->name ?? 'sin ubicación' }}</td>
                    <td class="px-4 py-2">{{ $device->operational_state?->name ?? 'sin estado operativo' }}</td>
                    <td class="px-4 py-2">{{ $device->physical_state?->name ?? 'sin estado fisico' }}</td>
                    <td class="px-4 py-2">{{ $device->acquisition_date ?? 'sin fecha de adquisición' }}</td>
                    <td class="px-4 py-2 text-center">{{ $device->creator?->name ?? 'sin movimiento' }}</td>
                    <td class="px-4 py-2 text-center">{{ $device->updater?->name ?? 'sin actualizacion' }}</td>
                    @can('dashboard.devices.update')
                    <td class="px-4 py-2 text-center align-middle">
                        <div class="flex justify-center items-center gap-2">
                        <x-wireui-button xs circle secondary icon="pencil" wire:click="edit({{ $device->id }})" />
                        <x-wireui-button
                                    xs
                                    circle
                                    negative
                                    icon="trash"
                                    wire:click="confirmDelete({{ $device->id }})"
                                    wire:loading.attr="disabled"
                        />
                        </div>
                    </td>
                    @endcan
                </tr>
                @endforeach
                @if($this->devices->isEmpty())
                <tr>
                    <td colspan="10" class="py-11">
                        <div class="flex flex-col items-center justify-center text-secondary-500">
                            <x-wireui-icon name="face-frown" class="w-12 h-12 mb-2 outline-none" />
                            <p class="text-lg font-semibold">No se encontraron dispositivos
                            <p>
                            <p class="text-sm">Intenta con otros términos de búsqueda.
                            <p>
                        </div>
                    </td>
                </tr>
                @endif
            </x-slot>
        </x-data-table>
        @can('dashboard.devices.create')
        <x-wireui-modal-card title="{{ $isEditing ? 'Editar Dispositivo' : 'Nuevo Dispositivo' }}" name="deviceModal"
            wire:model.defer="deviceModal">
            <div class="grid grid-cols-1 gap-4">
                <x-wireui-select label="Tipo"
                    placeholder="Buscar..."
                    wire:model.live="deviceTypeId"
                    :options="$this->deviceTypes"
                    option-label="name"
                    option-value="id"
                />

                <x-wireui-select label="Marca"
                    placeholder="Buscar..."
                    wire:model.live="brandId"
                    :options="$this->brands"
                    option-label="name"
                    option-value="id"
                    :disabled="!$deviceTypeId"
                />

                <x-wireui-select label="Modelo"
                    placeholder="Buscar..."
                    wire:model="deviceModelId"
                    :options="$this->filterModels"
                    option-label="name"
                    option-value="id"
                    :disabled="!$brandId"
                />

                <x-wireui-input label="Serial" placeholder="ingrese el serial..." wire:model="serial_number"
                    class="uppercase" />

                <x-wireui-input label="Imei" placeholder="ingrese el Imei..." wire:model="imei"
                    class="uppercase" />

                <x-wireui-select label="Seleccionar ubicacion actual" placeholder="Busca ubicacion actual..." wire:model="locationId" :options="$this->locations" option-label="name" option-value="id" />

                <x-wireui-select label="Seleccionar estado operativo" placeholder="Busca estado operativo del dispositivo" wire:model="operationalStateId" :options="$this->operationalStates" option-label="name" option-value="id" />

                <x-wireui-select label="Seleccionar estado fisico" placeholder="Busca estado fisico del dispositivo" wire:model="physicalStateId" :options="$this->physicalStates" option-label="name" option-value="id" />

                <x-wireui-datetime-picker
                    wire:model="acquisitionDate"
                    label="Feche adquisición"
                    placeholder="seleccione la fecha de adquisición"
                    without-time
                    parse-format="YYYY-MM-DD"
                    display-format="YYYY-MM-DD"
                />
            </div>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-wireui-button flat label="Cancelar" x-on:click="$wire.deviceModal = false" />
                <x-wireui-button primary label="Guardar" wire:click="save" wire:loading.attr="disabled" />
            </x-slot>
        </x-wireui-modal-card>
        @endcan
    </div>
</div>
