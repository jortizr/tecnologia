<x-form-card>
    <x-form-section submit="update">
        <x-slot name="title">
            Editar Usuario
        </x-slot>
        <x-slot name="description">
            Actualiza la información del usuario.
        </x-slot>
        <x-slot name="form">

            <div class="w-full">
                <x-label for="name" value="Nombre" class="text-center block"/>
                <x-input id="name" type="text" class="mt-1 block w-full text-center" value="{{ $user->name }}" wire:model="name" />
                <x-input-error for="name" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="last_name" value="Apellidos" class="text-center block"/>
                <x-input id="last_name" type="text" class="mt-1 block w-full text-center" value="{{ $user->last_name }}" wire:model="last_name"/>
                <x-input-error for="last_name" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="email" value="Email" class="text-center block"/>
                <x-input id="email" type="email" class="mt-1 block w-full text-center" value="{{ $user->email }}" wire:model="email"/>
                <x-input-error for="email" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="role" value="Rol" class="text-center block"/>
                <select id="role" class="mt-1 block w-full text-center bg-gray-700 text-gray-200 border-0 rounded-md p-2 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500" wire:model="role">
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error for="role" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="password" value="Nueva contraseña (opcional)" class="text-center block"/>
                <x-input id="password" type="password" class="mt-1 block w-full text-center" wire:model.defer="password"/>
                <x-input-error for="password" class="mt-2 text-center"/>
            </div>

            <div class="w-full flex justify-center mt-6 space-x-4">
                <x-button wire:loading.attr="disabled" wire:click="cancel">
                    Cancelar
                </x-button>
                <x-button wire:loading.attr="disabled" wire:target="update">
                    Actualizar Usuario
                </x-button>
            </div>
        </x-slot>
    </x-form-section>
</x-form-card>
