<div>
    <div x-data="{ showModal: @entangle('isOpen') }" x-show="showModal"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
        style="display: none;">

        <div x-show="showModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
            x-on:click="showModal = false"></div>

        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="flex flex-col items-center justify-center h-screen dark">
                    <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center pb-3">
                            <h2 class="text-2xl font-bold text-gray-200 mb-2">Editar Usuario</h2>
                            <button type="button" class="text-gray-400 hover:text-gray-500" wire:click="closeModal">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form wire:submit="update" class="flex flex-col">
                            <div class="flex space-x-4 mb-4">
                                <input placeholder="Nombres" class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 w-1/2 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                                    type="text" wire:model="name"/>
                                <input placeholder="Apellidos" class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 w-1/2 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                                    type="text" wire:model="last_name" name="last_name"/>
                            </div>
                            <input placeholder="Email" class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                                type="email" wire:model="email"/>

                            <label class="text-sm mb-2 text-gray-200 cursor-pointer" for="role">Rol de Usuario</label>
                            <select class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                                id="role" wire:model="role_id">
                                <option value="" disabled selected>Seleccione un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                            <button
                                class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150"
                                type="submit">
                                Actualizar Usuario
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


