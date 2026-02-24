<div class="py-6">
    <div class="flex justify-center items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion de Roles') }}
        </h2>
        <x-badge-title :count="$this->roles->total()" />
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->roles">
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

                    @can('dashboard.roles.create')
                        <x-wireui-button
                            label="Nuevo Rol"
                            icon="user-plus"
                            wire:click="create"
                            primary
                            class="w-full sm:w-auto sm:px-6 sm:ml-2"
                        />
                    @endcan
            </x-slot>
            <x-slot name="headers">
                <tr class="text-custom-dark-bg dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4 text-left">Rol</th>
                    <th class="px-6 py-4 text-left">Permisos</th>
                     @can('dashboard.roles.update')
                    <th class="px-6 py-4 text-center">Acciones</th>
                    @endcan
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
                                xs circle negative
                                icon="trash"
                                wire:click="confirmDelete({{ $role->id }})"
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
        @can('dashboard.roles.create')
        {{-- MODAL DE CREACIÓN/EDICIÓN --}}
        <x-wireui-modal-card title="{{ $isEditing ? 'Editar Rol' : 'Nuevo Rol' }}" wire:model.defer="roleModal">
            <div class="grid grid-cols-1 gap-4">
                <x-wireui-input label="Nombre del Rol" wire:model.defer="name" placeholder="ej. Editor de Contenido" />

                <div class="flex items-center gap-2 mt-2">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Asignar Permisos</span>
                    <hr class="flex-1 border-gray-200 dark:border-gray-700">
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto p-2 border rounded-lg bg-gray-50/50 dark:bg-gray-800/20">
                    @foreach($permissions as $modulo => $items)
                        <div class="bg-white dark:bg-custom-dark-header border dark:border-gray-700 rounded-lg p-3 shadow-sm">
                            <h3 class="text-xs font-black uppercase text-primary-600 dark:text-primary-400 mb-3 flex items-center gap-2">
                                <x-wireui-icon name="chevron-right" class="w-3 h-3" />
                                {{ $modulo }}
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($items as $lp)
                                    <x-wireui-checkbox
                                        id="p-{{ $lp->id }}"
                                        wire:model.defer="selectedPermissions"
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
                    <x-wireui-button flat label="Cancelar" x-on:click="$wire.roleModal = false" />
                    <x-wireui-button primary label="Guardar Datos" wire:click="save" wire:loading.attr="disabled" />
                </div>
            </x-slot>
        </x-wireui-modal-card>
        @endcan
    </div>
</div>
