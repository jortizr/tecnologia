@props(['active' => false, 'title', 'icon'])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="space-y-1">
    {{-- Botón Principal --}}
    <button type="button"
        @click="open = !open"
        class="flex items-center w-full p-2 text-base font-medium transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ $active ? 'bg-gray-100 dark:bg-gray-700' : '' }}">

        {{-- Icono dinámico --}}
        @if(isset($icon))
            {{ $icon }}
        @endif

        <span class="flex-1 ms-3 text-left whitespace-nowrap">{{ $title }}</span>

        {{-- Flecha indicadora --}}
        <svg class="w-3 h-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
    </button>

    {{-- Lista de sub-elementos --}}
    <ul x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        class="py-2 space-y-2 ms-4 border-l border-gray-200 dark:border-gray-600">
        {{ $slot }}
    </ul>
</div>
