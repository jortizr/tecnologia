<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold text-gray-700 uppercase">Gestión de {{ $modelName }}</h1>
        <x-button wire:click="create" primary label="Nuevo {{ $modelName }}" icon="plus" />
    </div>

    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($items as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <x-button.circle icon="pencil" primary wire:click="edit({{ $item->id }})" />
                        <x-button.circle icon="trash" negative wire:click="deleteConfirm({{ $item->id }})" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-modal wire:model.defer="isOpen">
        <x-card title="Formulario de {{ $modelName }}">
            <div class="space-y-3">
                <x-input wire:model.defer="name" label="Nombre" placeholder="Ej: Sistemas" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancelar" x-on:click="close" />
                    <x-button primary label="Guardar" wire:click="save" spinner="save" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
