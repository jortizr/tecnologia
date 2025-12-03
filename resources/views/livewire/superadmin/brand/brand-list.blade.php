<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ __("Lista de marcas") }}
            </h2>
        </div>
    </x-slot>

    @hasrole(['Superadmin','Manager', 'Viewer'])
    <x-data-table :data="$brands">
        <x-section-title>
            <x-slot name="title">Lista de fabricantes</x-slot>
            <x-slot name="description">lista de fabricantes de los dispositivos</x-slot>
        </x-section-title>
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
                                            <td class="px-4 py-2">{{ $brand->name}}</td>
                                            <td class="px-4 py-2 text-center">{{ $brand->creator?->name ?? 'sin movimiento' }}</td>
                                            <td class="px-4 py-2 text-center">{{ $brand->updater?->name ?? 'sin actualizacion' }}</td>
                                            <td class="px-4 py-2">
                                                <x-buttons.actions-button editRoute="{{route('dashboard.collaborators.edit', $brand)}}"
                                                deleteId="{{$brand->id}}"/>
                                            </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
    @endhasrole
</div>
