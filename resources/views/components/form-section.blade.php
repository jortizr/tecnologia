@props(['submit'])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center']) }}>
    <!-- Título y descripción centrados -->
    <div class="text-center mb-2">
        <x-section-title>
            <x-slot name="title">{{ $title }}</x-slot>
            <x-slot name="description">{{ $description }}</x-slot>
        </x-section-title>
    </div>

    <div class="w-full max-w-md">
        <form wire:submit="{{ $submit }}">
            <div class="px-4 py-6 bg-white dark:bg-gray-800 sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="flex flex-col space-y-4">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-center px-4 py-3 bg-gray-50 dark:bg-gray-800 text-center sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md ">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
