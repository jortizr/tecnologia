@props(['editRoute' => null, 'deleteRoute' => null, 'deleteId' => null])

<div class="flex justify-around items-center py-1">
    @if($editRoute || isset($edit))
        <!-- Botón Editar -->
        <div class="flex gap-2 text-gray-600 hover:scale-110 duration-200 hover:cursor-pointer">
            <svg class="w-6 stroke-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            @if($editRoute)
                <a href="{{ $editRoute }}" class="font-semibold text-sm text-green-700" title="Editar">
                    Editar
                </a>
            @else
                {{ $edit }}
            @endif
        </div>
    @endif

    @if($deleteRoute || $deleteId || isset($delete))
        <!-- Botón Eliminar -->
        <div class="flex gap-2 text-gray-600 hover:scale-110 duration-200 hover:cursor-pointer">
            <svg class="w-6 stroke-red-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>

            @if($deleteRoute)
                <form method="POST" action="{{ $deleteRoute }}" class="inline"
                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar este registro?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="font-semibold text-sm text-red-700" title="Eliminar">
                        Eliminar
                    </button>
                </form>
            @elseif($deleteId)
                <button wire:click="delete({{ $deleteId }})"
                        wire:confirm="¿Estás seguro de que quieres eliminar este registro?"
                        class="font-semibold text-sm text-red-700" title="Eliminar">
                    Eliminar
                </button>
            @else
                {{ $delete }}
            @endif
        </div>
    @endif

    <!-- Para acciones adicionales -->
    @if(isset($additional))
        {{ $additional }}
    @endif
</div>
