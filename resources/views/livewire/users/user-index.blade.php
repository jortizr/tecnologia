<div class="py-6">
    <div class="flex justify-center items-center" x-data x-on:model-updated.window="$wire.$refresh()">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Lista de Usuarios') }}
        </h2>
        <x-badge-title :count="$this->users->total()" />
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-data-table :data="$this->users">
            {{-- TOOLBAR: Buscador y Botón Nuevo --}}
            <x-slot name="toolbar">
                <div class="w-full sm:flex-1 sm:max-w-md">
                    <x-wireui-input
                        wire:model.live.debounce.500ms="search"
                        icon="magnifying-glass"
                        placeholder="Buscar usuario por nombre, email o rol..."
                        class="bg-white dark:bg-custom-dark-header border-gray-300 dark:border-gray-600"
                    />
                </div>

                <div class="w-full sm:w-48">
                    <x-wireui-select
                        placeholder="Estado: Todos"
                        wire:model.live="filterStatus"
                        :options="[
                            ['name' => 'Todos', 'id' => ''],
                            ['name' => 'Solo Activos', 'id' => '1'],
                            ['name' => 'Solo Inactivos', 'id' => '0'],
                        ]"
                        option-label="name"
                        option-value="id"
                        shadow="flat"
                        class="dark:bg-custom-dark-header"
                    />
                </div>
                    @if($canManage)
                        <x-wireui-button
                            label="Nuevo Usuario"
                            icon="user-plus"
                            wire:click="create"
                            primary
                            class="w-full sm:w-auto sm:px-6 sm:ml-2"
                        />
                    @endif
            </x-slot>
            <x-slot name="headers">
                <tr class="text-custom-dark-bg dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-4 text-left">Usuario</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-center">Rol</th>
                    <th class="px-6 py-4 text-center">Estado</th>
                     @if($canManage)
                    <th class="px-6 py-4 text-center">Acciones</th>
                    @endif
                </tr>
            </x-slot>
            <x-slot name="dataTBody">
                @forelse($this->users as $user)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors duration-200" wire:key="user-{{ $user->id }}">
                        <td class="px-4 py-3">
                            <span class="font-bold text-gray-900 dark:text-gray-100">{{ $user->name }} {{ $user->last_name }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-center">
                            @foreach($user->roles as $role)
                                <x-wireui-badge flat primary class="bg-brand-soft text-brand-primary" :label="$role->name" />
                            @endforeach
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center items-center">
                                <x-wireui-toggle
                                    positive
                                    wire:key="user-status-{{ $user->id }}-{{ (int)$user->is_active }}"
                                    :checked="$user->is_active"
                                    x-on:click="$dispatch('toggleStatus', { userId: {{ $user->id }} })"
                                    wire:loading.attr="disabled"
                                    wire:target="toggleStatus"
                                />
                            </div>

                        </td>
                        <td class="px-4 py-2 text-center align-middle">
                            <div class="flex justify-center items-center gap-2">
                            <x-wireui-button xs circle secondary icon="pencil" wire:click="edit({{ $user->id }})" />
                            <x-wireui-button
                                    xs
                                    circle
                                    negative
                                    icon="trash"
                                    wire:click="confirmDelete({{ $user->id }})"
                                    wire:loading.attr="disabled"
                            />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500">
                            <x-wireui-icon name="users" class="w-12 h-12 mx-auto mb-2 opacity-20" />
                            <p>No se encontraron usuarios que coincidan.</p>
                        </td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>

        {{-- MODAL DE CREACIÓN/EDICIÓN --}}
        <x-wireui-modal-card title="{{ $isEditing ? 'Editar Usuario' : 'Nuevo Usuario' }}" wire:model.defer="userModal">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-wireui-input label="Nombre" wire:model.defer="name" />
                <x-wireui-input label="Apellido" wire:model.defer="last_name" />
                <div class="sm:col-span-2">
                    <x-wireui-input label="Correo Electrónico" icon="envelope" wire:model.defer="email" />
                </div>

                @if(!$isEditing)
                    <div class="sm:col-span-2">
                        <x-wireui-password label="Contraseña" wire:model.defer="password" />
                    </div>
                @endif

                <x-wireui-select
                    label="Asignar Rol"
                    placeholder="Seleccione un rol"
                    wire:model.defer="role"
                    :options="$this->rolesList"
                    option-label="name"
                    option-value="id"
                />

                <div class="flex items-center pt-6">
                    <x-wireui-toggle label="¿Usuario Activo?" wire:model.defer="is_active" />
                </div>
            </div>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-wireui-button flat label="Cancelar" x-on:click="$wire.userModal = false" />
                <x-wireui-button primary label="Guardar Usuario" wire:click="save" spinner="save" />
            </x-slot>
        </x-wireui-modal-card>
    </div>
</div>
