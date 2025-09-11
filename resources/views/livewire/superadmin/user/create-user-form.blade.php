<div>
    <button wire:click="openModal"
        class="cursor-pointer transition-all
bg-gray-700 text-white px-6 py-2 rounded-lg
border-indigo-400
border-b-[4px] hover:brightness-110 hover:-translate-y-[1px]
active:border-b-[2px] active:brightness-90 active:translate-y-[1px] hover:shadow-lg hover:shadow-indigo-300 shadow-indigo-300 active:shadow-none">
        Crear Usuario
    </button>
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
                            <h2 class="text-2xl font-bold text-gray-200 mb-2" id="modal-title">Formulario de Usuario</h2>
                            <button type="button" class="text-gray-400 hover:text-gray-500" x-on:click="showModal = false">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form wire:submit="store" class="flex flex-col">
                            <div class="flex space-x-4 mb-4">
                                <input placeholder="Nombres"
                                    class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 w-1/2 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                                    type="text" wire:model="name"/>
                                    <input placeholder="Apellidos"
                                        class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 w-1/2 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                                        type="text" wire:model="last_name"/>
                            </div>
                                                                        @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
                            <input placeholder="Email"
                                class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                                type="email" wire:model="email"/>
                                    @error('email')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror

<div class="relative w-full">
    <input
        placeholder="Contraseña"
        class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150 pr-10 w-full"
        type="password"
        wire:model="password"
        id="password"
    />
        @error('password')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror

    <div
        class="absolute inset-y-0 right-0 pr-3 flex items-center mb-4"
        style="height: 42px;"
        x-data="tooltipComponent()" {{-- Usa tu componente Alpine.js --}}
        data-message="Generar contraseña" {{-- Pasa el mensaje como un data attribute --}}
        @mouseenter="showTooltip = true"
        @mouseleave="showTooltip = false"
        @focusin="showTooltip = true"
        @focusout="showTooltip = false"
    >
        <button
            type="button"
            wire:click="generatePassword"
            class="cursor-pointer h-full flex items-center justify-center group"
        >
            <svg class="h-5 w-5 text-gray-400 hover:text-green-500 transition ease-in-out duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </button>

        {{-- El Tooltip --}}
        <div
            x-show="showTooltip"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            class="absolute z-10 top-full right-0 mt-2 px-3 py-1 bg-gray-800 text-white text-xs rounded-md shadow-lg whitespace-nowrap"
            x-text="message" {{-- Ahora el texto viene de la propiedad 'message' del componente Alpine --}}
        ></div>
    </div>
</div>


                            <label class="text-sm mb-2 text-gray-200 cursor-pointer" for="role">
                                Rol de Usuario
                            </label>
                            <select
                                class="bg-gray-700 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150"
                                id="role" wire:model="role">
                                <option value="" selected>Seleccione un rol</option>
                                 @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                 @endforeach

                            </select>
                                @error('role')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
                            <label class="text-sm mb-2 text-gray-200 cursor-pointer">
                                Estado usuario
                            <input type="checkbox" class="sr-only peer" value="true" wire:model="is_active" />
                                <div
                                    class="group peer bg-gray-700 rounded-full duration-300 w-8 h-4 ring-1 ring-red-500 after:duration-300 after:bg-red-500 peer-checked:after:bg-green-500 peer-checked:ring-green-500 after:rounded-full after:absolute after:h-4 after:w-4 after:left-0.1 after:flex after:justify-center after:items-center peer-checked:after:translate-x-4 peer-hover:after:scale-95"
                                ></div>
                            </label>
                            <button
                                class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150"
                                type="submit">
                                Crear usuario
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


