<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ __("Lista de Marcas") }}
            </h2>
        </div>
    </x-slot>

    @hasanyrole
    <x-data-table :data="$brands">
        <x-slot name="headers">
            <tr class="bg-gray-800 text-gray-100">
                <th class="px-4 py-2 justification-start">ID</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Creado por</th>
                <th class="px-4 py-2">Actualizado por</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </x-slot>
        <x-slot name="dataTBody">
            @foreach($brands as $brand)
                <tr class="border-b border-gray-700">
                                            <td class="px-4 py-2">{{ $brand->id }}</td>
                                            <td class="px-4 py-2">{{ $brand->names}}</td>
                                            <td class="px-4 py-2">{{ $brand->created_by?->name ?? 'sin movimiento' }}</td>
                                            <td class="px-4 py-2">{{ $brand->updated_by?->name ?? 'sin actualizacion' }}</td>
                                            <td class="px-4 py-2">
                                                <!-- <x-buttons.actions-button editRoute="{{route('dashboard.collaborators.edit', $collaborator)}}"
                                                deleteId="{{$collaborator->id}}"/> -->
                                            </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
    
</div>
