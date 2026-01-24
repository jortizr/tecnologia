<div class="py-6">
    <div class="flex justify-center items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Lista de colaboradores") }}
        </h2>
        <x-badge-title :count="$this->collaborators->total()" />
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @can('viewAny', App\Models\Collaborator::class)
        <x-data-table :data="$this->collaborators">
            <x-slot name="toolbar">
                <div class="w-full sm:flex-1 sm:max-w-md">
                    <x-wireui-input
                        wire:model.live.debounce.500ms="search"
                        icon="magnifying-glass"
                        placeholder="Buscar colaborador..."
                        class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                    />
                </div>
                <div class="w-full sm:w-48">
                    @if($canManage)
                        <x-wireui-button
                            label="Nuevo colaborador"
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
                    <th class="px-6 py-4">Nombres</th>
                    <th class="px-6 py-4">Apellidos</th>
                    <th class="px-6 py-4">Identificacion</th>
                    <th class="px-6 py-4">Codigo de nomina</th>
                    <th class="px-6 py-4">Area</th>
                    <th class="px-6 py-4">Cargo</th>
                    <th class="px-6 py-4">Regional</th>
                    <th class="px-6 py-4">Estado</th>
                    @if($canManage)
                    <th class="px-6 py-4">Acciones</th>
                    @endif
                </tr>
            </x-slot>
            <x-slot name="dataTBody">
                @foreach($this->collaborators as $collaborator)
                    <tr class="border-b border-gray-700" wire:key="model-{{ $collaborator->id }}">
                        <td class="px-4 py-2">{{ $collaborator->names}}</td>
                            <td class="px-4 py-2">{{$collaborator->last_name}}</td>
                            <td class="px-4 py-2">{{ $collaborator->identification }}</td>
                                                <td class="px-4 py-2">{{ $collaborator->payroll_code }}</td>
                                                <td class="px-4 py-2">{{ $collaborator->department?->name ?? 'Sin area' }}</td>
                                                <td class="px-4 py-2">{{ $collaborator->occupation?->name ?? 'Sin cargo' }}</td>
                                                <td class="px-4 py-2">{{ $collaborator->regional?->name ?? 'Sin regional' }}</td>
                                                <td class="px-4 py-2">
                                                    <x-buttons.toggle-status toggleId="{{ $collaborator->id }}" :isActive="$collaborator->is_active" keyName="collaboratorId"/>
                                                </td>
                                                <td class="px-4 py-2">
                                                    botones
                                                </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-data-table>
        @endcan
    </div>

</div>
