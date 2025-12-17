@props([
    'editRoute' => null,
    'deleteRoute' => null,
    'deleteId' => null,
])

<div class="flex justify-around items-center py-2 space-x-1">
    @if($editRoute || isset($edit))
        <!-- Botón Editar -->
        <div class="flex items-center space-x-1">
            @if($editRoute)
               <a href="{{ $editRoute }}"
                class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-white bg-gray-700 border-red-700 border-b-2 rounded-md
                hover:bg-gray-800 hover:text-green-600
                hover:brightness-110 hover:-translate-y-[1px]
                hover:shadow-sm hover:shadow-red-500

                transition-colors duration-200 group"
                title="Editar este registro">
                    <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform duration-200"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span class="hidden sm:inline">Editar</span>
                </a>
            @else
                {{ $edit }}
            @endif
        </div>
    @endif

    @if($deleteRoute || $deleteId || isset($delete))
        <!-- Botón Eliminar -->
        @if($deleteRoute)
            <form method="POST" action="{{ $deleteRoute }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Estás seguro de que quieres eliminar este registro?')"
                        class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 hover:border-red-300 transition-colors duration-200 group"
                        title="Eliminar registro">
                    <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform duration-200"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="hidden sm:inline">Eliminar</span>
                </button>
            </form>
        @elseif($deleteId)
            <button wire:click="delete({{ $deleteId }})"
                    wire:confirm="¿Estás seguro de que quieres eliminar este registro?"
                    class="inline-flex items-center px-2 py-1.5 text-sm font-medium text-white bg-gray-700 border-red-700 border-b-2 rounded-md hover:bg-gray-800
                    hover:brightness-110 hover:-translate-y-[1px]
                    hover:shadow-sm hover:shadow-red-600 hover:text-red-600
                    hover:border-red-700
                    transition-colors duration-200 group"
                    title="Eliminar este registro">
                <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform duration-200"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span class="hidden sm:inline">Eliminar</span>
            </button>
        @endif
    @endif

    {{-- Mensaje cuando no hay botones disponibles --}}
    @if(!$editRoute && !$deleteRoute && !$deleteId)
        <span class="inline-flex items-center px-2 py-1.5 text-xs text-gray-500 bg-gray-50 border border-gray-200 rounded-md">
            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
            </svg>
            Sin acciones
        </span>
    @endif
</div>
