<div class="py-6">
    <div class="flex justify-center items-center" x-data x-on:model-updated.window="$wire.$refresh()">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion de Roles') }}
        </h2>
        <x-badge-title :count="$this->roles->total()" />
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->roles">
            {{-- TOOLBAR: Buscador y Botón Nuevo --}}
            <x-slot name="toolbar">
                <div class="w-full sm:flex-1 sm:max-w-md">
                   {{-- <x-wireui-input
                        wire:model.live.debounce.500ms="search"
                        icon="magnifying-glass"
                        placeholder="Buscar usuario por nombre, email o rol..."
                        class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                    />
                    --}}
                </div>

                    @if($canManage)
                        <x-wireui-button
                            label="Nuevo Rol"
                            icon="user-plus"
                            wire:click="create"
                            primary
                            class="w-full sm:w-auto sm:px-6 sm:ml-2"
                        />
                    @endif
            </x-slot>
            <x-slot name="headers">
                <tr class="text-custom-dark-bg dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4 text-left">Rol</th>
                    <th class="px-6 py-4 text-left">Permisos</th>
                     @if($canManage)
                    <th class="px-6 py-4 text-center">Acciones</th>
                    @endif
                </tr>
            </x-slot>
            <x-slot name="dataTBody">
                @forelse($this->roles as $role)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors duration-200" wire:key="role-{{ $role->id }}">
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $role->name }}</span>
                        </td>

                        <td class="px-4 py-2">
                            @if($role->name === 'Superadmin')
                                <x-wireui-badge label="Todos los permisos" cyan />
                            @else
                                <div class="flex flex-wrap gap-1">
                                    @foreach($role->permissions->take(5) as $p)
                                        <x-wireui-badge :label="$p->name" flat />
                                    @endforeach
                                    @if($role->permissions->count() > 5)
                                        <span class="text-xs text-gray-400">+{{ $role->permissions->count() - 5 }} más</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center align-middle">
                            <div class="flex justify-center items-center gap-2">
                            <x-wireui-button xs circle secondary icon="pencil" wire:click="edit({{ $role->id }})" />
                            <x-wireui-button
                                xs
                                circle
                                negative
                                icon="trash"
                                x-on:confirm="{
                                    title: '¿Eliminar Rol?',
                                    description: 'Esta acción es irreversible',
                                    icon: 'error',
                                    method: 'delete',
                                    params: {{ $role->id }}
                                }"
                            />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500">
                            <x-wireui-icon name="users" class="w-12 h-12 mx-auto mb-2 opacity-20" />
                            <p>No se encontraron roles que coincidan.</p>
                        </td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>

        {{-- MODAL DE CREACIÓN/EDICIÓN --}}
        <x-wireui-modal-card title="Detalles del Rol"  wire:model.defer="roleModal">
            <div class="grid grid-cols-1 gap-4">
                <x-wireui-input label="Nombre del Rol" wire:model="name" placeholder="ej. Editor de Contenido" />

                <p>Asignar Permisos:</p>
                <div class="space-y-4 max-h-96 overflow-y-auto p-2">
                    @foreach($permissions as $modulo => $items)
                        <div class="border rounded-lg p-3">
                            <h3 class="text-sm font-bold uppercase text-gray-500 mb-2 border-b">{{ $modulo }}</h3>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($items as $lp)
                                    <x-wireui-checkbox
                                        id="p-{{ $lp->id }}"
                                        wire:model="selectedPermissions"
                                        label="{{ str_replace(['dashboard.', $modulo . '.'], '', $lp->name) }}"
                                        value="{{ $lp->name }}"
                                    />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-wireui-button flat label="Cancelar" x-on:click="close" />
                    <x-wireui-button primary label="Guardar" wire:click="save" />
                </div>
            </x-slot>
        </x-wireui-modal-card>
    </div>
</div>
