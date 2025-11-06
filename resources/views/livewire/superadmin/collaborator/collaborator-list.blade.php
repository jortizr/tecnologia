<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ __("Lista de colaboradores") }}
            </h2>
            <div class="">
                @can('create', App\Models\Collaborator::class)
                <div class="flex justify-end mx-3 space-x-1" id="form-collaborator">
                   @livewire('superadmin.collaborator.create-collaborator-form')
                   <x-buttons.create-button route="{{ route('dashboard.collaborators.import') }}">
                    Importar Colaboradores
                    <x-slot name="icon">
                        <svg fill="#ffff" viewBox="0 0 24 24" id="import-2" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color w-6 h-6"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path id="secondary" d="M13,6a1,1,0,0,0-1,1v3.59L3.71,2.29A1,1,0,0,0,2.29,3.71L10.59,12H7a1,1,0,0,0,0,2h6a1,1,0,0,0,1-1V7A1,1,0,0,0,13,6Z" style="fill: #2ca9bc;"></path><path id="primary" d="M20,22H4a2,2,0,0,1-2-2V13a1,1,0,0,1,2,0v7H20V4H13a1,1,0,0,1,0-2h7a2,2,0,0,1,2,2V20A2,2,0,0,1,20,22Z" style="fill: #fff;"></path></g></svg>
                    </x-slot>
                   </x-buttons.create-button>
                </div>
                @endcan

                @if (session()->has('success'))
                <div
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4"
                    role="alert"
                >
                    <span class="block sm:inline">{{
                        session("success")
                    }}</span>
                </div>
                @endif
            </div>
        </div>

    </x-slot>
    @can('viewAny', App\Models\Collaborator::class)
    <x-data-table :data="$collaborators">
        <x-slot name="headers">
            <tr class="bg-gray-800 text-gray-100">
                <th class="px-4 py-2 justification-start">ID</th>
                <th class="px-4 py-2">Nombres</th>
                <th class="px-4 py-2">Apellidos</th>
                <th class="px-4 py-2">Identificacion</th>
                <th class="px-4 py-2">Codigo de nomina</th>
                <th class="px-4 py-2">Area</th>
                <th class="px-4 py-2">Cargo</th>
                <th class="px-4 py-2">Regional</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </x-slot>
        <x-slot name="dataTBody">
            @foreach($collaborators as $collaborator)
                <tr class="border-b border-gray-700">
                                            <td class="px-4 py-2">{{ $collaborator->id }}</td>
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
                                                <x-buttons.actions-button editRoute="{{route('dashboard.collaborators.edit', $collaborator)}}"
                                                deleteId="{{$collaborator->id}}"/>
                                            </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
    @endcan


</div>
