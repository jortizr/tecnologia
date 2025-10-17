@props([
    'placeholder' => 'Buscar...',
    'searchModel' => '',
    'selectedName' => '',
    'items' => [],
    'seletedId' => null,
    'error' => null,
    'minChars' => 2,
    'noResultsMessage' => 'No se encontraron resultados'
])

<div class="relative" x-data="{ open: false }" @click.away="open = false">
    {{-- Input principal --}}
    <input
        type="text"
        {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full']) }}
        placeholder="{{ $selectedName ?: $placeholder }}"
        autocomplete="off"
        @focus="open = true"
    />

    {{-- Dropdown de resultados --}}
    @if($attributes->whereStartsWith('wire:model')->first())
        @php
            $searchValue = $attributes->wire('model')->value();
            $searchLength = strlen($this->$searchValue ?? '');
        @endphp

        @if($searchLength >= $minChars)
        <div
            x-show="open"
            x-transition
            class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg max-h-60 overflow-y-auto"
        >
            @if(!empty($items))
                <ul>
                    @foreach ($items as $item)
                    <li
                        wire:click="{{ $attributes->wire('select')->value }}({{ $item['id'] }}, '{{ addslashes($item['name']) }}')"
                        @click="open = false"
                        class="p-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors"
                    >
                        {{ $item['name'] }}
                    </li>
                    @endforeach
                </ul>
            @else
                {{-- Mensaje cuando no hay resultados --}}
                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">{{ $noResultsMessage }}</p>
                </div>
            @endif
        </div>
        @endif
    @endif

    @if($attributes->whereStartsWith('wire:model')->first())
        @php
            $searchValue = $attributes->wire('model')->value();
            $currentLength = strlen($this->$searchValue ?? '');
        @endphp

        @if($currentLength > 0 && $currentLength < $minChars && !$selectedName)
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Escribe al menos {{ $minChars }} caracteres para buscar
        </p>
        @endif
    @endif
</div>
